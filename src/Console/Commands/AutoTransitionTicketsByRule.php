<?php

namespace KevinBHarris\Support\Console\Commands;

use Illuminate\Console\Command;
use KevinBHarris\Support\Models\Rule;
use KevinBHarris\Support\Models\Ticket;
use KevinBHarris\Support\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class AutoTransitionTicketsByRule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:auto-transition-tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically transition ticket statuses based on enabled automation rules';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (!config('support.automation.enabled', false)) {
            $this->info('Automation is disabled in configuration.');
            return self::SUCCESS;
        }

        $this->info('Starting automatic ticket status transitions...');

        // Get all enabled rules
        $rules = Rule::where('is_enabled', true)
            ->with(['fromStatus', 'toStatus'])
            ->get();

        if ($rules->isEmpty()) {
            $this->info('No enabled automation rules found.');
            return self::SUCCESS;
        }

        $transitionedCount = 0;

        foreach ($rules as $rule) {
            $this->info("Processing rule: {$rule->name}");

            // Find tickets that match this rule's criteria
            $cutoffTime = now()->subHours($rule->after_hours);

            $tickets = Ticket::where('status_id', $rule->from_status_id)
                ->where('status_changed_at', '<=', $cutoffTime)
                ->whereNotNull('status_changed_at')
                ->get();

            foreach ($tickets as $ticket) {
                try {
                    DB::beginTransaction();

                    $oldStatus = $ticket->status->name;

                    // Update ticket status
                    $ticket->status_id = $rule->to_status_id;
                    // status_changed_at will be automatically updated by the model observer
                    $ticket->save();

                    // Log the activity
                    ActivityLog::create([
                        'ticket_id' => $ticket->id,
                        'action' => 'status_auto_transitioned',
                        'description' => "Status automatically changed by rule: {$rule->name}",
                        'properties' => [
                            'Status' => "{$oldStatus} → {$ticket->status->name}",
                            'Rule' => $rule->name,
                            'After Hours' => $rule->after_hours,
                        ],
                        'user_id' => null,
                        'user_name' => 'System (Automation)',
                    ]);

                    DB::commit();

                    $transitionedCount++;
                    $this->info("  Ticket #{$ticket->ticket_number}: {$oldStatus} → {$ticket->status->name}");
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->error("  Failed to transition ticket #{$ticket->ticket_number}: {$e->getMessage()}");
                }
            }
        }

        $this->info("Completed. Transitioned {$transitionedCount} ticket(s).");

        return self::SUCCESS;
    }
}

@component('mail::message')
# Ticket Updated

Your support ticket has been updated.

**Ticket Number:** {{ $ticket->ticket_number }}  
**Subject:** {{ $ticket->subject }}  
**Status:** {{ $ticket->status->name }}  
**Priority:** {{ $ticket->priority->name }}

@if(!empty($changes))
**Changes:**
@foreach($changes as $field => $change)
- {{ $field }}: {{ $change }}
@endforeach
@endif

You can view your ticket using the link below:

@component('mail::button', ['url' => route('support.portal.show', $ticket->access_token)])
View Ticket
@endcomponent

Thanks,<br>
{{ config('support.email.from_name') }}
@endcomponent

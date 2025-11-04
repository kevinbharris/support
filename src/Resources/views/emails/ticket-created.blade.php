@component('mail::message')
# Ticket Created

Your support ticket has been created successfully.

**Ticket Number:** {{ $ticket->ticket_number }}  
**Subject:** {{ $ticket->subject }}  
**Status:** {{ $ticket->status->name }}  
**Priority:** {{ $ticket->priority->name }}

**Description:**  
{{ $ticket->description }}

You can view and reply to your ticket using the link below:

@component('mail::button', ['url' => route('support.portal.show', $ticket->access_token)])
View Ticket
@endcomponent

Thanks,<br>
{{ config('support.email.from_name') }}
@endcomponent

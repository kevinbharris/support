@component('mail::message')
# New Reply on Your Ticket

A new reply has been added to your support ticket.

**Ticket Number:** {{ $note->ticket->ticket_number }}  
**Subject:** {{ $note->ticket->subject }}  
**From:** {{ $note->created_by_name }}

**Message:**  
{{ $note->content }}

You can view the full conversation and reply using the link below:

@component('mail::button', ['url' => route('support.portal.show', $note->ticket->access_token)])
View Ticket
@endcomponent

Thanks,<br>
{{ config('support.email.from_name') }}
@endcomponent

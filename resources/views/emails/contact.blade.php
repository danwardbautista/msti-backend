@component('mail::message')
# {{ $contact['subject'] }}

**Name:** {{ $contact['name'] }}

@if (!empty($contact['company']))
**Company:** {{ $contact['company'] }}
@endif

@if (!empty($contact['position']))
**Position:** {{ $contact['position'] }}
@endif

**Email:** {{ $contact['email'] }}

@if (!empty($contact['phone']))
**Phone:** {{ $contact['phone'] }}
@endif

**Subject:** {{ $contact['subject'] }}

**Message:**

{{ $contact['message'] }}

@endcomponent

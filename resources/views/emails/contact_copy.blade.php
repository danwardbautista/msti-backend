@component('mail::message')
# We received your inquiry

Thank you, **{{ $contact['name'] }}**, for getting in touch with us. Below is a copy of your message:

---

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

---

We will get back to you shortly.

Thank you,<br>
**The Medsol Team**
@endcomponent

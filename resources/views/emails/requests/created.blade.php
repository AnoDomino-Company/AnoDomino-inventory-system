@component('mail::message')
# New Request Created

A new request has been submitted by **{{ $request->requester->name }}**.

@component('mail::button', ['url' => route('approvals.pending')])
Review & Approve
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent



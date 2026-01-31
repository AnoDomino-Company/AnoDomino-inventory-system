@component('mail::message')
# Request Approved

The request **#{{ $request->id }}** has been approved by a supervisor.  
Next step: Authorization required.

@component('mail::button', ['url' => route('authorizations.pending')])
Authorize Request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

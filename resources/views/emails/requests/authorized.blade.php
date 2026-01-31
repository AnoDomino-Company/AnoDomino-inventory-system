@component('mail::message')
# Request Authorized

The request **#{{ $request->id }}** has been authorized.  
Next step: Storekeeper to issue items.

@component('mail::button', ['url' => route('issues.index')])
Go to Pending Issues
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
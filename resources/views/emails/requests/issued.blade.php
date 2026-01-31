@component('mail::message')
# Request Completed

Your request **#{{ $request->id }}** has been successfully issued by the storekeeper. 🎉  

You can view the details anytime.

@component('mail::button', ['url' => route('requests.show', $request->id) ])
View Request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
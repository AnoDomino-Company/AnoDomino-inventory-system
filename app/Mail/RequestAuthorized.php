<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestModel;

class RequestAuthorized extends Mailable
{
    use Queueable, SerializesModels;
    public $requestModel;

    public function __construct(RequestModel $requestModel)
    {
        $this->requestModel = $requestModel;
    }

    public function build()
    {
        return $this->subject('Request Authorized')
                    ->markdown('emails.requests.authorized')
                    ->with(['request' => $this->requestModel]);
    }
}

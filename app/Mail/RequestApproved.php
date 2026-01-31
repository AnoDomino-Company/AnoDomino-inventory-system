<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestModel;

class RequestApproved extends Mailable
{
    use Queueable, SerializesModels;
    public $requestModel;

    public function __construct(RequestModel $requestModel)
    {
        $this->requestModel = $requestModel;
    }

    public function build()
    {
        return $this->subject('Request Approved')
                    ->markdown('emails.requests.approved')
                    ->with(['request' => $this->requestModel]);
    }
}


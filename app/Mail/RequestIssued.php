<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestModel;

class RequestIssued extends Mailable
{
    use Queueable, SerializesModels;
    public $requestModel;

    public function __construct(RequestModel $requestModel)
    {
        $this->requestModel = $requestModel;
    }

    public function build()
    {
        return $this->subject('Request Issued')
                    ->markdown('emails.requests.issued')
                    ->with(['request' => $this->requestModel]);
    }
}



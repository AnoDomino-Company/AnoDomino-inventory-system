<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\RequestModel;

class RequestCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $requestModel;

    public function __construct(RequestModel $requestModel)
    {
        $this->requestModel = $requestModel;
    }

    public function build()
    {
        return $this->subject('New Request Created')
                    ->markdown('emails.requests.created')
                    ->with(['request' => $this->requestModel]);
    }
}



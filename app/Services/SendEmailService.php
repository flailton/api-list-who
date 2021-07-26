<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
//use App\Interfaces\ISendEmailService;

class SendEmailService //implements ISendEmailService
{
    private SendEmailJob $sendMailJob;

    public function __construct(SendEmailJob $sendMailJob) {
        $this->sendMailJob = $sendMailJob;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string  $send_mail
     * @return void
     */
    public function send(string $send_mail)
    {
        SendEmailJob::dispatch($send_mail);
    }
}

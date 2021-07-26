<?php


namespace App\Interfaces;

use App\Interfaces\IService;

interface ISendEmailService extends IService
{    
    public function send(string $send_mail);
}

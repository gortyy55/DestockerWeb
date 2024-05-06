<?php
// src/Service/TwilioSmsService.php
/*
namespace App\Service;

use Twilio\Rest\Client;

class TwilioSmsService
{
    private $accountSid;
    private $authToken;
    private $twilioPhoneNumber;

    public function __construct(string $accountSid, string $authToken, string $twilioPhoneNumber)
    {
        $this->accountSid = $accountSid;
        $this->authToken = $authToken;
        $this->twilioPhoneNumber = $twilioPhoneNumber;
    }

    public function sendSms(string $to, string $message): void
    {
        $twilio = new Client($this->accountSid, $this->authToken);

        $twilio->messages->create(
            $to,
            [
                'from' => $this->twilioPhoneNumber,
                'body' => $message,
            ]
        );
    }
}*/
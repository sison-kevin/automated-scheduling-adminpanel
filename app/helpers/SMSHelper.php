<?php

use Twilio\Rest\Client;

function sendSMS($to, $message)
{
    $sid = $_ENV['TWILIO_SID'];
    $auth = $_ENV['TWILIO_AUTH'];
    $from = $_ENV['TWILIO_FROM'];

    $client = new Client($sid, $auth);

    $client->messages->create($to, [
        'from' => $from,
        'body' => $message,
    ]);
}

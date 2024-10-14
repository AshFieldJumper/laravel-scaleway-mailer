<?php

namespace ashfieldjumper\LaravelScalewayMailer\Transport;

use ashfieldjumper\LaravelScalewayMailer\Events\ScalewayEmailSent;
use GuzzleHttp\Client;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\MessageConverter;

class ScalewayTransport extends AbstractTransport
{
    private Client $client;

    /**
     * Create a new Scaleway transport instance.
     */
    public function __construct(
        protected string $secretKey,
        protected string $projectId,
        protected string $region
    )
    {
        $this->client = new Client();
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        // Convert the Symfony message to an Email instance
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        // Prepare the payload for Scaleway API
        $payload = [
            'from' => [
                'email' => $email->getFrom()[0]->getAddress(),
                'name' => $email->getFrom()[0]->getName(),
            ],
            'to' => collect($email->getTo())->map(function (Address $address) {
                return ['email' => $address->getAddress(), 'type' => 'to'];
            })->all(),
            'subject' => $email->getSubject(),
            'text' => $email->getTextBody(),
            'html' => $email->getHtmlBody(),
            'project_id' => $this->projectId,
        ];

        // Handle attachments if present
        if ($email->getAttachments()) {
            $payload['attachments'] = collect($email->getAttachments())->map(function ($attachment) {
                return [
                    'name' => $attachment->getFilename(),
                    'type' => $attachment->getContentType(),
                    'content' => base64_encode($attachment->getBody()),
                ];
            })->all();
        }

        // Send the request to Scaleway API
        $response = $this->client->post("https://api.scaleway.com/transactional-email/v1alpha1/regions/{$this->region}/emails", [
            'headers' => [
                'X-Auth-Token' => $this->secretKey,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        // Log the response for debugging
        $responseBody = json_decode($response->getBody()->getContents(), true);

        event(new ScalewayEmailSent($responseBody));

        \Log::info('Scaleway email response', $responseBody);
    }

    /**
     * Get the string representation of the transport.
     */
    public function __toString(): string
    {
        return 'scaleway';
    }
}
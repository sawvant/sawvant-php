<?php

namespace Sawvant;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class StreamEvent
{
    public string $type;
    public array $data;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
    }
}

class Streaming
{
    /**
     * Stream job progress via Server-Sent Events.
     *
     * @param string $jobId Job UUID
     * @param string $apiKey API key with sk_ prefix
     * @param string $baseUrl Base API URL
     * @return \Generator<StreamEvent>
     */
    public static function streamJob(
        string $jobId,
        string $apiKey,
        string $baseUrl = 'https://api.sawvant.com'
    ): \Generator {
        $client = new Client();
        $url = "{$baseUrl}/v1/jobs/{$jobId}/stream";

        $response = $client->request('GET', $url, [
            'headers' => [
                'X-API-Key' => $apiKey,
                'Accept' => 'text/event-stream',
            ],
            'stream' => true,
        ]);

        $body = $response->getBody();
        $currentEvent = '';
        $buffer = '';

        while (!$body->eof()) {
            $buffer .= $body->read(1024);
            $lines = explode("\n", $buffer);
            $buffer = array_pop($lines);

            foreach ($lines as $line) {
                if (str_starts_with($line, 'event:')) {
                    $currentEvent = trim(substr($line, 6));
                } elseif (str_starts_with($line, 'data:')) {
                    $data = json_decode(trim(substr($line, 5)), true);
                    yield new StreamEvent($currentEvent, $data);
                }
            }
        }
    }
}

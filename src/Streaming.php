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
     * SSE events emitted by the server intentionally omit the full OptimizeResult
     * to avoid buffer overflow errors on large result payloads. When a "completed"
     * event is received, the SDK automatically fetches the full job via
     * GET /v1/jobs/{id} and uses that as the event data. All other event types
     * are forwarded as-is.
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

                    // SSE events don't include the full result to avoid buffer
                    // overflow; fetch via REST instead.
                    if ($currentEvent === 'completed') {
                        $data = self::fetchJobResult($client, $jobId, $apiKey, $baseUrl);
                    }

                    yield new StreamEvent($currentEvent, $data);
                }
            }
        }
    }

    /**
     * Fetch the full job response via REST API.
     *
     * @param Client $client HTTP client
     * @param string $jobId Job UUID
     * @param string $apiKey API key
     * @param string $baseUrl Base API URL
     * @return array Full job response data
     * @throws \RuntimeException If the REST fetch fails
     */
    private static function fetchJobResult(
        Client $client,
        string $jobId,
        string $apiKey,
        string $baseUrl
    ): array {
        $response = $client->request('GET', "{$baseUrl}/v1/jobs/{$jobId}", [
            'headers' => [
                'X-API-Key' => $apiKey,
                'Accept' => 'application/json',
            ],
        ]);

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        if ($data === null) {
            throw new \RuntimeException(
                "Failed to decode job result for job {$jobId}: " . json_last_error_msg()
            );
        }

        return $data;
    }
}

# Sawvant PHP SDK

The official PHP client for the [Sawvant](https://sawvant.com) Cutting Optimization API.

- API version: `1.0.0`
- Requires PHP 8.1 or later

## Installation

```sh
composer require sawvant/sdk
```

## Quick Start

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Sawvant\Client\Configuration;
use Sawvant\Client\ApiClient;
use Sawvant\Api\OptimizeApi;
use Sawvant\Api\JobsApi;
use Sawvant\Model\OptimizeRequest;
use Sawvant\Model\Sheet;
use Sawvant\Model\Part;

$config = new Configuration();
$config->setHost('https://api.sawvant.com');
$config->setApiKey('ApiKeyAuth', 'sk_your_api_key_here');

$client = new ApiClient($config);
$api = new OptimizeApi($client);

// Submit an optimization job
$request = new OptimizeRequest([
    'sheets' => [
        new Sheet(['width' => 2440, 'height' => 1220, 'quantity' => 5]),
    ],
    'parts' => [
        new Part(['width' => 600, 'height' => 400, 'quantity' => 10, 'label' => 'Panel A']),
        new Part(['width' => 300, 'height' => 200, 'quantity' => 20, 'label' => 'Panel B']),
    ],
]);

$job = $api->createOptimization($request);
echo 'Job created: ' . $job->getId() . PHP_EOL;

// Poll for results
$jobsApi = new JobsApi($client);

do {
    sleep(1);
    $result = $jobsApi->getJob($job->getId());
} while (in_array($result->getStatus(), ['pending', 'running']));

if ($result->getStatus() === 'completed') {
    echo 'Optimization complete: ' . print_r($result->getResult(), true) . PHP_EOL;
} else {
    echo 'Job failed: ' . $result->getStatus() . PHP_EOL;
}
```

## SSE Streaming

Stream real-time progress events as the job runs:

```php
<?php

$jobsApi = new JobsApi($client);

foreach ($jobsApi->streamJob($job->getId()) as $event) {
    match ($event->getType()) {
        'progress'  => print('Progress: ' . $event->getData() . PHP_EOL),
        'completed' => (function () use ($event) {
            echo 'Done: ' . $event->getData() . PHP_EOL;
        })(),
        'failed'    => throw new \RuntimeException('Job failed: ' . $event->getData()),
    };

    if (in_array($event->getType(), ['completed', 'failed'])) {
        break;
    }
}
```

## Configuration

```php
$config = new Configuration();
$config->setHost('https://api.sawvant.com');
$config->setApiKey('ApiKeyAuth', getenv('SAWVANT_API_KEY'));
$config->setCurlTimeout(30);
```

| Method | Description |
|--------|-------------|
| `setHost(string)` | API base URL (default: `https://api.sawvant.com`) |
| `setApiKey(string, string)` | Set API key for `ApiKeyAuth` scheme |
| `setCurlTimeout(int)` | Request timeout in seconds |

## API Reference

All endpoints are relative to `https://api.sawvant.com`.

| Method | HTTP | Path | Description |
|--------|------|------|-------------|
| `createOptimization` | POST | `/v1/optimize` | Submit a new cutting optimization job |
| `getJob` | GET | `/v1/jobs/{id}` | Retrieve job status and result |
| `streamJob` | GET | `/v1/jobs/{id}/stream` | Stream job progress via SSE |
| `getHealth` | GET | `/health` | Health check (no auth required) |

## License

MIT

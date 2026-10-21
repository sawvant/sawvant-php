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

use GuzzleHttp\Client;
use Sawvant\Api\JobsApi;
use Sawvant\Api\OptimizationApi;
use Sawvant\Configuration;
use Sawvant\Model\CutDirection;
use Sawvant\Model\GrainDirection;
use Sawvant\Model\Machine;
use Sawvant\Model\OptimizeRequest;
use Sawvant\Model\Part;
use Sawvant\Model\Sheet;

$config = Configuration::getDefaultConfiguration()
    ->setHost('https://api.sawvant.com')
    ->setApiKey('X-API-Key', 'sk_your_api_key_here');

$http = new Client();
$optimizationApi = new OptimizationApi($http, $config);
$jobsApi = new JobsApi($http, $config);

// Submit an optimization job. Sizes are in mm.
$request = new OptimizeRequest([
    'sheets' => [
        new Sheet(['id' => 'board', 'length' => 2800, 'width' => 2070, 'quantity' => 10, 'grain' => GrainDirection::NONE]),
    ],
    'parts' => [
        new Part(['id' => 'panel-a', 'length' => 600, 'width' => 400, 'quantity' => 10, 'grain' => GrainDirection::NONE]),
        new Part(['id' => 'panel-b', 'length' => 300, 'width' => 200, 'quantity' => 20, 'grain' => GrainDirection::NONE]),
    ],
    'machine' => new Machine(['blade_thickness' => 4.4, 'max_levels' => 3, 'cut_direction' => CutDirection::_DEFAULT]),
]);

$job = $optimizationApi->createOptimization($request);
echo 'Job created: ' . $job->getJobId() . PHP_EOL;

// Poll for results
do {
    sleep(1);
    $result = $jobsApi->getJob($job->getJobId());
} while (in_array($result->getStatus(), ['pending', 'running'], true));

if ($result->getStatus() === 'completed') {
    echo 'Optimization complete: ' . print_r($result->getResult(), true) . PHP_EOL;
} else {
    echo 'Job failed: ' . $result->getError() . PHP_EOL;
}
```

Error responses (4xx and 5xx) throw `Sawvant\ApiException`; `getResponseBody()` holds the error details.

## SSE Streaming

Stream real-time progress events as the job runs with `Sawvant\Streaming`. Pass the job ID that `createOptimization` returned:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Sawvant\Streaming;

$jobId = '550e8400-e29b-41d4-a716-446655440000';
$events = Streaming::streamJob($jobId, (string) getenv('SAWVANT_API_KEY'));

foreach ($events as $event) {
    if ($event->type === 'progress') {
        echo 'Progress: ' . $event->data['progress'] . PHP_EOL;
    } elseif ($event->type === 'completed') {
        echo 'Done: ' . print_r($event->data['result'], true) . PHP_EOL;
        break;
    } elseif ($event->type === 'failed') {
        throw new \RuntimeException('Job failed: ' . ($event->data['error'] ?? 'unknown error'));
    }
}
```

`streamJob` takes an optional third argument with the base URL (default `https://api.sawvant.com`). `$event->data` is an associative array with the job fields.

When a `completed` event arrives, the SDK fetches the full job via `GET /v1/jobs/{id}` and puts it in the event, so `$event->data['result']` holds the complete result. The server leaves the result out of stream events to keep them small. Other events are passed on as received.

## Configuration

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use Sawvant\Api\JobsApi;
use Sawvant\Configuration;

$config = Configuration::getDefaultConfiguration()
    ->setHost('https://api.sawvant.com')
    ->setApiKey('X-API-Key', (string) getenv('SAWVANT_API_KEY'));

// Timeouts and other HTTP options go on the Guzzle client.
$jobsApi = new JobsApi(new Client(['timeout' => 30]), $config);
```

| Method | Description |
|--------|-------------|
| `setHost(string)` | API base URL (default: `https://api.sawvant.com`) |
| `setApiKey('X-API-Key', string)` | Your `sk_...` API key |
| `setUserAgent(string)` | User agent sent with each request |

## API Reference

All endpoints are relative to `https://api.sawvant.com`.

| Class | Method | HTTP | Path | Description |
|-------|--------|------|------|-------------|
| `OptimizationApi` | `createOptimization` | POST | `/v1/optimize` | Submit a new cutting optimization job |
| `OptimizationApi` | `createBatchOptimization` | POST | `/v1/optimize/batch` | Submit several optimization jobs at once |
| `JobsApi` | `getJob` | GET | `/v1/jobs/{id}` | Retrieve job status and result |
| `JobsApi` | `getJobDiagramSVG` | GET | `/v1/jobs/{id}/diagram` | Cutting diagram as SVG |
| `JobsApi` | `getJobDiagramPDF` | GET | `/v1/jobs/{id}/diagram.pdf` | Cutting diagram as PDF |
| `Streaming` | `streamJob` | GET | `/v1/jobs/{id}/stream` | Stream job progress via SSE |
| `SystemApi` | `getHealth` | GET | `/health` | Health check (no auth required) |
| `SystemApi` | `listTiers` | GET | `/v1/tiers` | List subscription tiers (no auth required) |

## License

Apache-2.0. See [LICENSE](LICENSE).

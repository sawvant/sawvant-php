# Sawvant\JobsApi

All URIs are relative to https://api.sawvant.com, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getJob()**](JobsApi.md#getJob) | **GET** /v1/jobs/{id} | Get job status |
| [**getJobDiagramPDF()**](JobsApi.md#getJobDiagramPDF) | **GET** /v1/jobs/{id}/diagram.pdf | Render a cutting plan as PDF |
| [**getJobDiagramSVG()**](JobsApi.md#getJobDiagramSVG) | **GET** /v1/jobs/{id}/diagram | Render a cutting plan as SVG |
| [**streamJob()**](JobsApi.md#streamJob) | **GET** /v1/jobs/{id}/stream | Stream job progress via SSE |


## `getJob()`

```php
getJob($id): \Sawvant\Model\JobResponse
```

Get job status

Returns the current state of a job including progress, result, and errors.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: apiKey
$config = Sawvant\Configuration::getDefaultConfiguration()->setApiKey('X-API-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Sawvant\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-API-Key', 'Bearer');


$apiInstance = new Sawvant\Api\JobsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = 'id_example'; // string | Job UUID

try {
    $result = $apiInstance->getJob($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling JobsApi->getJob: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Job UUID | |

### Return type

[**\Sawvant\Model\JobResponse**](../Model/JobResponse.md)

### Authorization

[apiKey](../../README.md#apiKey)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getJobDiagramPDF()`

```php
getJobDiagramPDF($id): \SplFileObject
```

Render a cutting plan as PDF

Returns every sheet layout of a completed job as a printable PDF cutting plan.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: apiKey
$config = Sawvant\Configuration::getDefaultConfiguration()->setApiKey('X-API-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Sawvant\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-API-Key', 'Bearer');


$apiInstance = new Sawvant\Api\JobsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = 'id_example'; // string | Job UUID

try {
    $result = $apiInstance->getJobDiagramPDF($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling JobsApi->getJobDiagramPDF: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Job UUID | |

### Return type

**\SplFileObject**

### Authorization

[apiKey](../../README.md#apiKey)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/pdf`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getJobDiagramSVG()`

```php
getJobDiagramSVG($id, $sheet): string
```

Render a cutting plan as SVG

Returns one sheet layout of a completed job as an SVG cutting plan with dimensions and grain direction.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: apiKey
$config = Sawvant\Configuration::getDefaultConfiguration()->setApiKey('X-API-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Sawvant\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-API-Key', 'Bearer');


$apiInstance = new Sawvant\Api\JobsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = 'id_example'; // string | Job UUID
$sheet = 0; // int | Index into the job's `layouts` array

try {
    $result = $apiInstance->getJobDiagramSVG($id, $sheet);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling JobsApi->getJobDiagramSVG: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Job UUID | |
| **sheet** | **int**| Index into the job&#39;s &#x60;layouts&#x60; array | [optional] [default to 0] |

### Return type

**string**

### Authorization

[apiKey](../../README.md#apiKey)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `image/svg+xml`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `streamJob()`

```php
streamJob($id): string
```

Stream job progress via SSE

Server-Sent Events stream that emits `progress`, `completed`, or `failed` events. The stream closes automatically when the job reaches a terminal state.  A `: heartbeat` comment is sent every 30 seconds to keep the connection alive through proxies and load balancers. SSE clients ignore these automatically.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: apiKey
$config = Sawvant\Configuration::getDefaultConfiguration()->setApiKey('X-API-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Sawvant\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-API-Key', 'Bearer');


$apiInstance = new Sawvant\Api\JobsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = 'id_example'; // string | Job UUID

try {
    $result = $apiInstance->streamJob($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling JobsApi->streamJob: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| Job UUID | |

### Return type

**string**

### Authorization

[apiKey](../../README.md#apiKey)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `text/event-stream`, `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

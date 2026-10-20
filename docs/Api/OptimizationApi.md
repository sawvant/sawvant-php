# Sawvant\OptimizationApi

All URIs are relative to https://api.sawvant.com, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createBatchOptimization()**](OptimizationApi.md#createBatchOptimization) | **POST** /v1/optimize/batch | Submit multiple cutting optimization jobs |
| [**createOptimization()**](OptimizationApi.md#createOptimization) | **POST** /v1/optimize | Submit a cutting optimization job |


## `createBatchOptimization()`

```php
createBatchOptimization($batch_request): \Sawvant\Model\BatchAccepted
```

Submit multiple cutting optimization jobs

Enqueues an array of optimization requests as individual jobs and returns their IDs immediately. Poll or stream each job separately.  Maximum 50 fast jobs or 10 thorough jobs per batch. Requires a tier with the `batch` feature.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: apiKey
$config = Sawvant\Configuration::getDefaultConfiguration()->setApiKey('X-API-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Sawvant\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-API-Key', 'Bearer');


$apiInstance = new Sawvant\Api\OptimizationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$batch_request = new \Sawvant\Model\BatchRequest(); // \Sawvant\Model\BatchRequest

try {
    $result = $apiInstance->createBatchOptimization($batch_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OptimizationApi->createBatchOptimization: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **batch_request** | [**\Sawvant\Model\BatchRequest**](../Model/BatchRequest.md)|  | |

### Return type

[**\Sawvant\Model\BatchAccepted**](../Model/BatchAccepted.md)

### Authorization

[apiKey](../../README.md#apiKey)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `createOptimization()`

```php
createOptimization($optimize_request): \Sawvant\Model\OptimizeAccepted
```

Submit a cutting optimization job

Validates the request synchronously, then enqueues the job for async processing. Returns 202 with a job ID and URLs for polling/streaming.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: apiKey
$config = Sawvant\Configuration::getDefaultConfiguration()->setApiKey('X-API-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Sawvant\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-API-Key', 'Bearer');


$apiInstance = new Sawvant\Api\OptimizationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$optimize_request = {"parts":[{"id":"shelf","length":600,"width":400,"quantity":8,"grain":"none"},{"id":"bracket","length":300,"width":200,"quantity":4,"grain":"none"}],"sheets":[{"id":"mdf-18","length":2440,"width":1220,"quantity":0,"grain":"none"}],"machine":{"blade_thickness":3.2,"max_levels":3,"cut_direction":"default"}}; // \Sawvant\Model\OptimizeRequest

try {
    $result = $apiInstance->createOptimization($optimize_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OptimizationApi->createOptimization: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **optimize_request** | [**\Sawvant\Model\OptimizeRequest**](../Model/OptimizeRequest.md)|  | |

### Return type

[**\Sawvant\Model\OptimizeAccepted**](../Model/OptimizeAccepted.md)

### Authorization

[apiKey](../../README.md#apiKey)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

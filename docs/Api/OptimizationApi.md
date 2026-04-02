# Sawvant\OptimizationApi

All URIs are relative to https://api.sawvant.com, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createOptimization()**](OptimizationApi.md#createOptimization) | **POST** /v1/optimize | Submit a cutting optimization job |


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
$optimize_request = new \Sawvant\Model\OptimizeRequest(); // \Sawvant\Model\OptimizeRequest

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

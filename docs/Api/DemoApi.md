# Sawvant\DemoApi

All URIs are relative to https://api.sawvant.com, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createDemoOptimization()**](DemoApi.md#createDemoOptimization) | **POST** /v1/demo/optimize | Run a small optimization without an API key |


## `createDemoOptimization()`

```php
createDemoOptimization($optimize_request): \Sawvant\Model\DemoOptimizeResponse
```

Run a small optimization without an API key

Public endpoint behind the playground on sawvant.com. No API key or account needed. Runs the fast strategy synchronously and returns the result together with an SVG cutting plan per layout, so there is no job to poll.  Limits: at most 30 part types, a total part quantity of 100, 3 sheet types and a 64 KB request body. `strategy` must be omitted or `fast`; `cost_tariffs` is ignored. Each client IP may make 10 requests per minute and 100 per day. The input is not stored.  Browsers may only call this endpoint from sawvant.com.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Sawvant\Api\DemoApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$optimize_request = {"parts":[{"id":"side","length":720,"width":560,"quantity":2,"grain":"length"},{"id":"shelf","length":564,"width":540,"quantity":3,"grain":"none"},{"id":"door","length":716,"width":396,"quantity":2,"grain":"length"}],"sheets":[{"id":"oak-18","length":2800,"width":2070,"quantity":0,"grain":"length"}],"machine":{"blade_thickness":3.2,"max_levels":3,"cut_direction":"default"}}; // \Sawvant\Model\OptimizeRequest

try {
    $result = $apiInstance->createDemoOptimization($optimize_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DemoApi->createDemoOptimization: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **optimize_request** | [**\Sawvant\Model\OptimizeRequest**](../Model/OptimizeRequest.md)|  | |

### Return type

[**\Sawvant\Model\DemoOptimizeResponse**](../Model/DemoOptimizeResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

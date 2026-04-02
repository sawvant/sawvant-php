# # OptimizeRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**parts** | [**\Sawvant\Model\Part[]**](Part.md) |  |
**sheets** | [**\Sawvant\Model\Sheet[]**](Sheet.md) |  |
**machine** | [**\Sawvant\Model\Machine**](Machine.md) |  |
**strategy** | **string** | Solve strategy. \&quot;fast\&quot; runs all greedy solvers concurrently. \&quot;thorough\&quot; adds Gilmore-Gomory column generation for optimal patterns. Each strategy has its own rate limit quota. | [optional] [default to 'fast']
**cost_tariffs** | [**\Sawvant\Model\CostTariffs**](CostTariffs.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

# # Sheet

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** |  |
**length** | **float** | Length in mm |
**width** | **float** | Width in mm |
**quantity** | **int** | 0 &#x3D; unlimited |
**grain** | [**\Sawvant\Model\GrainDirection**](GrainDirection.md) |  |
**is_offcut** | **bool** | Offcut sheets are prioritized by the solver | [optional] [default to false]
**trim_margins** | [**\Sawvant\Model\Margins**](Margins.md) |  | [optional]
**article_number** | **string** | Optional article/SKU reference for this sheet type | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

# # Summary

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**total_sheets** | **int** |  |
**yield_percent** | **float** |  |
**waste_percent** | **float** |  |
**waste_area** | **float** | mm² |
**unplaced_parts** | **string[]** | IDs of parts the solver could not fit on any available sheet. A grain direction that forbids the only orientation that would fit is a common cause, alongside sheet quantity limits. The rest of the plan is still valid and cuttable. | [optional]
**sheets_used** | [**\Sawvant\Model\SheetUsage[]**](SheetUsage.md) |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

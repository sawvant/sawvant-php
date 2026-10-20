# # Placement

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**part_id** | **string** |  |
**sheet_id** | **string** | Which sheet type this part is placed on |
**x** | **float** | mm from the top-left of the usable area, along the sheet&#39;s length axis. x + width never exceeds the usable length. |
**y** | **float** | mm from the top-left of the usable area, along the sheet&#39;s width axis. y + height never exceeds the usable width. |
**width** | **float** | Post-edge-banding dimension along the sheet&#39;s length axis |
**height** | **float** | Post-edge-banding dimension along the sheet&#39;s width axis |
**rotated** | **bool** | True when the part&#39;s length runs along the sheet&#39;s width axis, so width is the part&#39;s width and height is its length. |
**grain** | [**\Sawvant\Model\GrainDirection**](GrainDirection.md) |  |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

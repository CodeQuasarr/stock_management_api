# OpenAPI\Client\StockStatisticsApi

All URIs are relative to http://localhost:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**call4740c389300a1febb4d2433695527d18()**](StockStatisticsApi.md#call4740c389300a1febb4d2433695527d18) | **GET** /api/v1/stock-statistics | Get stock statistics |


## `call4740c389300a1febb4d2433695527d18()`

```php
call4740c389300a1febb4d2433695527d18($unique_code): \OpenAPI\Client\Model\4740c389300a1febb4d2433695527d18200Response
```

Get stock statistics

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\StockStatisticsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$unique_code = 'unique_code_example'; // string | Unique code of the product

try {
    $result = $apiInstance->call4740c389300a1febb4d2433695527d18($unique_code);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling StockStatisticsApi->call4740c389300a1febb4d2433695527d18: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **unique_code** | **string**| Unique code of the product | [optional] |

### Return type

[**\OpenAPI\Client\Model\4740c389300a1febb4d2433695527d18200Response**](../Model/4740c389300a1febb4d2433695527d18200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

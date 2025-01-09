# OpenAPI\Client\StocksApi

All URIs are relative to http://localhost:8000/api/v1, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**call287cd14e3ddf7d47e4d1d6bb9a5fa936()**](StocksApi.md#call287cd14e3ddf7d47e4d1d6bb9a5fa936) | **GET** /api/v1/stocks/{id} | Get a specific stock |
| [**call3a9cf9c5eb404bb591e2add0538d734c()**](StocksApi.md#call3a9cf9c5eb404bb591e2add0538d734c) | **GET** /stocks | List all stocks |
| [**call78bc4d75db95facc99c15171f703f3de()**](StocksApi.md#call78bc4d75db95facc99c15171f703f3de) | **GET** /api/v1/stocks/{productCode}/movements | Get stock movements for a specific product |
| [**call86e2293fb3723492729aee3662457cb9()**](StocksApi.md#call86e2293fb3723492729aee3662457cb9) | **POST** /stocks | Create a new stock |
| [**call8d9d37a321a4be13afd43f4f4ab6bfe2()**](StocksApi.md#call8d9d37a321a4be13afd43f4f4ab6bfe2) | **DELETE** /api/v1/stocks/{id} | Delete a specific stock |
| [**call9594154d15e6955281fa134aeac6b63f()**](StocksApi.md#call9594154d15e6955281fa134aeac6b63f) | **PUT** /api/v1/stocks/{id} | Update a specific stock |
| [**f737e1a87c5f7a202beccd97cac4554b()**](StocksApi.md#f737e1a87c5f7a202beccd97cac4554b) | **GET** /api/v1/stocks/{productCode}/days-in-stock | Get days in stock for a specific product |


## `call287cd14e3ddf7d47e4d1d6bb9a5fa936()`

```php
call287cd14e3ddf7d47e4d1d6bb9a5fa936($id): \OpenAPI\Client\Model\Product
```

Get a specific stock

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\StocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 56; // int | ID of the stock

try {
    $result = $apiInstance->call287cd14e3ddf7d47e4d1d6bb9a5fa936($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling StocksApi->call287cd14e3ddf7d47e4d1d6bb9a5fa936: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **int**| ID of the stock | |

### Return type

[**\OpenAPI\Client\Model\Product**](../Model/Product.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `call3a9cf9c5eb404bb591e2add0538d734c()`

```php
call3a9cf9c5eb404bb591e2add0538d734c(): \OpenAPI\Client\Model\Product[]
```

List all stocks

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\StocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->call3a9cf9c5eb404bb591e2add0538d734c();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling StocksApi->call3a9cf9c5eb404bb591e2add0538d734c: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\OpenAPI\Client\Model\Product[]**](../Model/Product.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `call78bc4d75db95facc99c15171f703f3de()`

```php
call78bc4d75db95facc99c15171f703f3de($product_code): \OpenAPI\Client\Model\78bc4d75db95facc99c15171f703f3de200Response
```

Get stock movements for a specific product

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\StocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$product_code = 'product_code_example'; // string | Unique code of the product

try {
    $result = $apiInstance->call78bc4d75db95facc99c15171f703f3de($product_code);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling StocksApi->call78bc4d75db95facc99c15171f703f3de: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **product_code** | **string**| Unique code of the product | |

### Return type

[**\OpenAPI\Client\Model\78bc4d75db95facc99c15171f703f3de200Response**](../Model/78bc4d75db95facc99c15171f703f3de200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `call86e2293fb3723492729aee3662457cb9()`

```php
call86e2293fb3723492729aee3662457cb9($product): \OpenAPI\Client\Model\Product
```

Create a new stock

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\StocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$product = new \OpenAPI\Client\Model\Product(); // \OpenAPI\Client\Model\Product

try {
    $result = $apiInstance->call86e2293fb3723492729aee3662457cb9($product);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling StocksApi->call86e2293fb3723492729aee3662457cb9: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **product** | [**\OpenAPI\Client\Model\Product**](../Model/Product.md)|  | |

### Return type

[**\OpenAPI\Client\Model\Product**](../Model/Product.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `call8d9d37a321a4be13afd43f4f4ab6bfe2()`

```php
call8d9d37a321a4be13afd43f4f4ab6bfe2($id)
```

Delete a specific stock

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\StocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 56; // int | ID of the stock

try {
    $apiInstance->call8d9d37a321a4be13afd43f4f4ab6bfe2($id);
} catch (Exception $e) {
    echo 'Exception when calling StocksApi->call8d9d37a321a4be13afd43f4f4ab6bfe2: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **int**| ID of the stock | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `call9594154d15e6955281fa134aeac6b63f()`

```php
call9594154d15e6955281fa134aeac6b63f($id, $product): \OpenAPI\Client\Model\Product
```

Update a specific stock

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\StocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$id = 56; // int | ID of the stock
$product = new \OpenAPI\Client\Model\Product(); // \OpenAPI\Client\Model\Product

try {
    $result = $apiInstance->call9594154d15e6955281fa134aeac6b63f($id, $product);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling StocksApi->call9594154d15e6955281fa134aeac6b63f: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **int**| ID of the stock | |
| **product** | [**\OpenAPI\Client\Model\Product**](../Model/Product.md)|  | |

### Return type

[**\OpenAPI\Client\Model\Product**](../Model/Product.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `f737e1a87c5f7a202beccd97cac4554b()`

```php
f737e1a87c5f7a202beccd97cac4554b($product_code): \OpenAPI\Client\Model\F737e1a87c5f7a202beccd97cac4554b200Response
```

Get days in stock for a specific product

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\StocksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$product_code = 'product_code_example'; // string | Unique code of the product

try {
    $result = $apiInstance->f737e1a87c5f7a202beccd97cac4554b($product_code);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling StocksApi->f737e1a87c5f7a202beccd97cac4554b: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **product_code** | **string**| Unique code of the product | |

### Return type

[**\OpenAPI\Client\Model\F737e1a87c5f7a202beccd97cac4554b200Response**](../Model/F737e1a87c5f7a202beccd97cac4554b200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

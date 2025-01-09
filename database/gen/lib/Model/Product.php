<?php
/**
 * Product
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * API Documentation
 *
 * Documentation for the API endpoints
 *
 * The version of the OpenAPI document: 1.0.0
 * Contact: support@example.com
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 6.2.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace OpenAPI\Client\Model;

use \ArrayAccess;
use \OpenAPI\Client\ObjectSerializer;

/**
 * Product Class Doc Comment
 *
 * @category Class
 * @description Product model
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class Product implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'Product';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'id' => 'int',
        'name' => 'string',
        'unique_code' => 'string',
        'therapeutic_category' => 'string',
        'purchase_price' => 'float',
        'sale_price' => 'float',
        'profit_margin' => 'float',
        'manufacturer' => 'string',
        'description' => 'string',
        'created_at' => '\DateTime',
        'updated_at' => '\DateTime',
        'deleted_at' => '\DateTime'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'id' => 'int64',
        'name' => null,
        'unique_code' => null,
        'therapeutic_category' => null,
        'purchase_price' => 'float',
        'sale_price' => 'float',
        'profit_margin' => 'float',
        'manufacturer' => null,
        'description' => null,
        'created_at' => 'date-time',
        'updated_at' => 'date-time',
        'deleted_at' => 'date-time'
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'id' => false,
		'name' => false,
		'unique_code' => false,
		'therapeutic_category' => false,
		'purchase_price' => false,
		'sale_price' => false,
		'profit_margin' => false,
		'manufacturer' => false,
		'description' => false,
		'created_at' => false,
		'updated_at' => false,
		'deleted_at' => false
    ];

    /**
      * If a nullable field gets set to null, insert it here
      *
      * @var boolean[]
      */
    protected array $openAPINullablesSetToNull = [];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of nullable properties
     *
     * @return array
     */
    protected static function openAPINullables(): array
    {
        return self::$openAPINullables;
    }

    /**
     * Array of nullable field names deliberately set to null
     *
     * @return boolean[]
     */
    private function getOpenAPINullablesSetToNull(): array
    {
        return $this->openAPINullablesSetToNull;
    }

    /**
     * Checks if a property is nullable
     *
     * @param string $property
     * @return bool
     */
    public static function isNullable(string $property): bool
    {
        return self::openAPINullables()[$property] ?? false;
    }

    /**
     * Checks if a nullable property is set to null.
     *
     * @param string $property
     * @return bool
     */
    public function isNullableSetToNull(string $property): bool
    {
        return in_array($property, $this->getOpenAPINullablesSetToNull(), true);
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'id' => 'id',
        'name' => 'name',
        'unique_code' => 'unique_code',
        'therapeutic_category' => 'therapeutic_category',
        'purchase_price' => 'purchase_price',
        'sale_price' => 'sale_price',
        'profit_margin' => 'profit_margin',
        'manufacturer' => 'manufacturer',
        'description' => 'description',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
        'deleted_at' => 'deleted_at'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'name' => 'setName',
        'unique_code' => 'setUniqueCode',
        'therapeutic_category' => 'setTherapeuticCategory',
        'purchase_price' => 'setPurchasePrice',
        'sale_price' => 'setSalePrice',
        'profit_margin' => 'setProfitMargin',
        'manufacturer' => 'setManufacturer',
        'description' => 'setDescription',
        'created_at' => 'setCreatedAt',
        'updated_at' => 'setUpdatedAt',
        'deleted_at' => 'setDeletedAt'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'name' => 'getName',
        'unique_code' => 'getUniqueCode',
        'therapeutic_category' => 'getTherapeuticCategory',
        'purchase_price' => 'getPurchasePrice',
        'sale_price' => 'getSalePrice',
        'profit_margin' => 'getProfitMargin',
        'manufacturer' => 'getManufacturer',
        'description' => 'getDescription',
        'created_at' => 'getCreatedAt',
        'updated_at' => 'getUpdatedAt',
        'deleted_at' => 'getDeletedAt'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }


    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->setIfExists('id', $data ?? [], null);
        $this->setIfExists('name', $data ?? [], null);
        $this->setIfExists('unique_code', $data ?? [], null);
        $this->setIfExists('therapeutic_category', $data ?? [], null);
        $this->setIfExists('purchase_price', $data ?? [], null);
        $this->setIfExists('sale_price', $data ?? [], null);
        $this->setIfExists('profit_margin', $data ?? [], null);
        $this->setIfExists('manufacturer', $data ?? [], null);
        $this->setIfExists('description', $data ?? [], null);
        $this->setIfExists('created_at', $data ?? [], null);
        $this->setIfExists('updated_at', $data ?? [], null);
        $this->setIfExists('deleted_at', $data ?? [], null);
    }

    /**
    * Sets $this->container[$variableName] to the given data or to the given default Value; if $variableName
    * is nullable and its value is set to null in the $fields array, then mark it as "set to null" in the
    * $this->openAPINullablesSetToNull array
    *
    * @param string $variableName
    * @param array  $fields
    * @param mixed  $defaultValue
    */
    private function setIfExists(string $variableName, array $fields, $defaultValue): void
    {
        if (self::isNullable($variableName) && array_key_exists($variableName, $fields) && is_null($fields[$variableName])) {
            $this->openAPINullablesSetToNull[] = $variableName;
        }

        $this->container[$variableName] = $fields[$variableName] ?? $defaultValue;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param int|null $id ID of the product
     *
     * @return self
     */
    public function setId($id)
    {

        if (is_null($id)) {
            throw new \InvalidArgumentException('non-nullable id cannot be null');
        }

        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string|null $name Name of the product
     *
     * @return self
     */
    public function setName($name)
    {

        if (is_null($name)) {
            throw new \InvalidArgumentException('non-nullable name cannot be null');
        }

        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets unique_code
     *
     * @return string|null
     */
    public function getUniqueCode()
    {
        return $this->container['unique_code'];
    }

    /**
     * Sets unique_code
     *
     * @param string|null $unique_code Unique code of the product
     *
     * @return self
     */
    public function setUniqueCode($unique_code)
    {

        if (is_null($unique_code)) {
            throw new \InvalidArgumentException('non-nullable unique_code cannot be null');
        }

        $this->container['unique_code'] = $unique_code;

        return $this;
    }

    /**
     * Gets therapeutic_category
     *
     * @return string|null
     */
    public function getTherapeuticCategory()
    {
        return $this->container['therapeutic_category'];
    }

    /**
     * Sets therapeutic_category
     *
     * @param string|null $therapeutic_category Therapeutic category of the product
     *
     * @return self
     */
    public function setTherapeuticCategory($therapeutic_category)
    {

        if (is_null($therapeutic_category)) {
            throw new \InvalidArgumentException('non-nullable therapeutic_category cannot be null');
        }

        $this->container['therapeutic_category'] = $therapeutic_category;

        return $this;
    }

    /**
     * Gets purchase_price
     *
     * @return float|null
     */
    public function getPurchasePrice()
    {
        return $this->container['purchase_price'];
    }

    /**
     * Sets purchase_price
     *
     * @param float|null $purchase_price Purchase price of the product
     *
     * @return self
     */
    public function setPurchasePrice($purchase_price)
    {

        if (is_null($purchase_price)) {
            throw new \InvalidArgumentException('non-nullable purchase_price cannot be null');
        }

        $this->container['purchase_price'] = $purchase_price;

        return $this;
    }

    /**
     * Gets sale_price
     *
     * @return float|null
     */
    public function getSalePrice()
    {
        return $this->container['sale_price'];
    }

    /**
     * Sets sale_price
     *
     * @param float|null $sale_price Sale price of the product
     *
     * @return self
     */
    public function setSalePrice($sale_price)
    {

        if (is_null($sale_price)) {
            throw new \InvalidArgumentException('non-nullable sale_price cannot be null');
        }

        $this->container['sale_price'] = $sale_price;

        return $this;
    }

    /**
     * Gets profit_margin
     *
     * @return float|null
     */
    public function getProfitMargin()
    {
        return $this->container['profit_margin'];
    }

    /**
     * Sets profit_margin
     *
     * @param float|null $profit_margin Profit margin of the product
     *
     * @return self
     */
    public function setProfitMargin($profit_margin)
    {

        if (is_null($profit_margin)) {
            throw new \InvalidArgumentException('non-nullable profit_margin cannot be null');
        }

        $this->container['profit_margin'] = $profit_margin;

        return $this;
    }

    /**
     * Gets manufacturer
     *
     * @return string|null
     */
    public function getManufacturer()
    {
        return $this->container['manufacturer'];
    }

    /**
     * Sets manufacturer
     *
     * @param string|null $manufacturer Manufacturer of the product
     *
     * @return self
     */
    public function setManufacturer($manufacturer)
    {

        if (is_null($manufacturer)) {
            throw new \InvalidArgumentException('non-nullable manufacturer cannot be null');
        }

        $this->container['manufacturer'] = $manufacturer;

        return $this;
    }

    /**
     * Gets description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string|null $description Description of the product
     *
     * @return self
     */
    public function setDescription($description)
    {

        if (is_null($description)) {
            throw new \InvalidArgumentException('non-nullable description cannot be null');
        }

        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets created_at
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->container['created_at'];
    }

    /**
     * Sets created_at
     *
     * @param \DateTime|null $created_at Creation date of the product
     *
     * @return self
     */
    public function setCreatedAt($created_at)
    {

        if (is_null($created_at)) {
            throw new \InvalidArgumentException('non-nullable created_at cannot be null');
        }

        $this->container['created_at'] = $created_at;

        return $this;
    }

    /**
     * Gets updated_at
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->container['updated_at'];
    }

    /**
     * Sets updated_at
     *
     * @param \DateTime|null $updated_at Last update date of the product
     *
     * @return self
     */
    public function setUpdatedAt($updated_at)
    {

        if (is_null($updated_at)) {
            throw new \InvalidArgumentException('non-nullable updated_at cannot be null');
        }

        $this->container['updated_at'] = $updated_at;

        return $this;
    }

    /**
     * Gets deleted_at
     *
     * @return \DateTime|null
     */
    public function getDeletedAt()
    {
        return $this->container['deleted_at'];
    }

    /**
     * Sets deleted_at
     *
     * @param \DateTime|null $deleted_at Deletion date of the product
     *
     * @return self
     */
    public function setDeletedAt($deleted_at)
    {

        if (is_null($deleted_at)) {
            throw new \InvalidArgumentException('non-nullable deleted_at cannot be null');
        }

        $this->container['deleted_at'] = $deleted_at;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}



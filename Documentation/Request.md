# Using Request in Model

## Extending the Parent Model

```php
class SomeModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
}
```

---

## Accessing Raw HTTP Body

```php
public function getRawRequestBody()
{
    // Retrieve the raw HTTP request body as a string
    $rawBody = $this->request->getBody();

    // Can be used for logging, debugging, or manual processing
    return $rawBody;
}
```

* `getBody()` returns the raw HTTP payload exactly as received.

---

## Accessing JSON Request Data

```php
public function processJsonData()
{
    // Decode JSON request body into an associative array
    $jsonData = $this->request->getJSON();

    // Safely access JSON fields with null coalescing operator
    $fieldA = $jsonData['fieldA'] ?? null;
    $fieldB = $jsonData['fieldB'] ?? null;

    if (!$fieldA || !$fieldB) {
        throw new \Exception("Required fields missing");
    }

    // Proceed with data processing, filtering, or validation
}
```

* `getJSON()` decodes the JSON payload into an array.
* Returns an empty array if JSON is invalid or empty.

---

## Summary

* `$this->request` is automatically available in any model extending the base `Model`.
* Use `$this->request->getBody()` to get raw HTTP input as a string.
* Use `$this->request->getJSON()` to get JSON-decoded input as an array.
* Always validate and sanitize data before use.

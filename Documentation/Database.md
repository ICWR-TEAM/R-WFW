# Model Class: Database Usage Examples

Your model class should extend `App\Core\Model` to gain access to the `$db` property, which is an instance of the `Database` class.

```php
use App\Core\Model;

class ExampleModel extends Model
{
    // If you override the constructor, always call parent::__construct()
    public function __construct()
    {
        parent::__construct();
        // additional initialization if needed
    }
}
```

---

## Fetch multiple records

Retrieve multiple rows from a table as an associative array.

```php
public function getAllRecords(): array
{
    return $this->db->query_fetch_array("SELECT * FROM your_table");
}
```

Example usage:

```php
$model = new ExampleModel();
$records = $model->getAllRecords();
```

---

## Fetch single record by ID

Retrieve a single record by ID with input sanitization.

```php
public function getRecordById(int $id): ?array
{
    $id = $this->db->filter((string)$id);
    $result = $this->db->query("SELECT * FROM your_table WHERE id = $id");
    return $this->db->fetch_array($result);
}
```

Example usage:

```php
$record = $model->getRecordById(10);
```

---

## Insert new record

Insert a new row into the table with sanitized inputs.

```php
public function insertRecord(string $field1, string $field2): bool
{
    $field1 = $this->db->filter($field1);
    $field2 = $this->db->filter($field2);
    $query = "INSERT INTO your_table (column1, column2) VALUES ('$field1', '$field2')";
    return $this->db->query($query);
}
```

Example usage:

```php
$model->insertRecord('value1', 'value2');
```

---

## Count records

Count the total number of rows in a table.

```php
public function countRecords(): int
{
    return $this->db->query_num_rows("SELECT * FROM your_table");
}
```

Example usage:

```php
$total = $model->countRecords();
echo "Total records: $total";
```

---

## Delete record by ID

Delete a record by its ID with input sanitization.

```php
public function deleteRecord(int $id): bool
{
    $id = $this->db->filter((string)$id);
    return $this->db->query("DELETE FROM your_table WHERE id = $id");
}
```

Example usage:

```php
$model->deleteRecord(5);
```

---

## Important

If your model class **defines its own constructor**, always call:

```php
parent::__construct();
```

inside it. Otherwise, `$this->db` will be `null` and calls like `$this->db->query()` will cause fatal errors.

---

All the examples above use `$this->db` directly because it is initialized in the base `Model` constructor. This keeps your models clean and easy to maintain.

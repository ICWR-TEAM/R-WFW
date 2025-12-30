# Model Class: Database Usage Examples (Updated)

Your model class should extend `App\Core\Model` to gain access to the `$db` property, which is an instance of the `Database` class.

```php
use App\Core\Model;

class ExampleModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
}
```

---

## Fetch Multiple Records

Retrieve multiple rows from a table as an associative array.

```php
public function getAllRecords(): array
{
    return $this->db->query_fetch_array("SELECT * FROM your_table");
}
```

Usage:

```php
$model = new ExampleModel();
$records = $model->getAllRecords();
```

---

## Fetch Single Record by ID (Safe Parameterized Query)

Retrieve one row by ID using parameter binding.

```php
public function getRecordById(int $id): ?array
{
    $result = $this->db->query("SELECT * FROM your_table WHERE id = :id", ['id' => $id]);
    return $this->db->fetch_array($result);
}
```

Usage:

```php
$record = $model->getRecordById(10);
```

---

## Insert New Record (Safe Input Handling)

Insert a new record using named parameters. Input is automatically sanitized.

```php
public function insertRecord(string $field1, string $field2): bool
{
    $query = "INSERT INTO your_table (column1, column2) VALUES (:field1, :field2)";
    return $this->db->query($query, ['field1' => $field1, 'field2' => $field2]);
}
```

Usage:

```php
$model->insertRecord('value1', 'value2');
```

---

## Count Total Records

Count all rows in a given table.

```php
public function countRecords(): int
{
    return $this->db->query_num_rows("SELECT * FROM your_table");
}
```

Usage:

```php
$total = $model->countRecords();
echo "Total records: $total";
```

---

## Delete Record by ID (Securely)

Delete a specific record by ID using parameter binding.

```php
public function deleteRecord(int $id): bool
{
    return $this->db->query("DELETE FROM your_table WHERE id = :id", ['id' => $id]);
}
```

Usage:

```php
$model->deleteRecord(5);
```

---

## Important Notes

* All query methods support **named parameters** (e.g., `:id`) and use automatic sanitization.
* You **do not need to call `filter()` manually** — the `Database` class handles it internally.
* If you override your model's constructor, **always call `parent::__construct()`**, or `$this->db` will not be initialized.
* Use `fetch_array()` to retrieve a single row from a `mysqli_result`.

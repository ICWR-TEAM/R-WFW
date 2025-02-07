# **Database Core Documentation**

---

## **Database Class Overview**

The `Database` class provides a simplified interface for interacting with a MySQL database using the `mysqli` extension in PHP. It includes methods for querying the database, fetching results, and handling connections.

### **Constructor: `__construct()`**

```php
public function __construct()
```

- **Purpose**:  
  The constructor establishes a connection to the database using the connection details defined in the configuration file (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`).
  
- **Connection**:  
  If the connection fails, the script will terminate and display an error message.

### **Method: `getConnection()`**

```php
public function getConnection(): mysqli
```

- **Purpose**:  
  Returns the current database connection.
  
- **Usage**:  
  This method is used internally by other methods to interact with the database.

### **Method: `closeConnection()`**

```php
public function closeConnection(): void
```

- **Purpose**:  
  Closes the active database connection.

- **Usage**:  
  Use this method to explicitly close the connection when it is no longer needed (usually done automatically when the script ends).

---

## **Query Methods**

### **Method: `query()`**

```php
public function query(string $query): bool|mysqli_result
```

- **Purpose**:  
  Executes a raw SQL query.

- **Parameters**:  
  - `$query` (string): The SQL query to be executed.
  
- **Returns**:  
  - `mysqli_result` (on success for SELECT queries).
  - `false` (on failure).

- **Usage**:  
  Use this method to execute any SQL query. For `SELECT` queries, the result is returned as a `mysqli_result` object.

### **Method: `query_fetch_array()`**

```php
public function query_fetch_array(string $query): array|bool
```

- **Purpose**:  
  Executes a SQL query and fetches all results as an associative array.

- **Parameters**:  
  - `$query` (string): The SQL query to be executed.

- **Returns**:  
  - An array of results if the query is successful.
  - `false` if the query fails.

- **Usage**:  
  Use this method to retrieve all rows from a query result as an associative array.

  Example:
  ```php
  $db = new Database();
  $results = $db->query_fetch_array("SELECT * FROM users");
  ```

### **Method: `fetch_array()`**

```php
public function fetch_array(mysqli_result $result): array|null
```

- **Purpose**:  
  Fetches a single row from a query result as an associative array.

- **Parameters**:  
  - `$result` (mysqli_result): The result of a previously executed query.

- **Returns**:  
  - An associative array representing a row from the result set.
  - `null` if no more rows are available.

- **Usage**:  
  This method is typically used to fetch a single row from the query result.

  Example:
  ```php
  $row = $db->fetch_array($result);
  ```

### **Method: `query_num_rows()`**

```php
public function query_num_rows(string $query): int
```

- **Purpose**:  
  Executes a query and returns the number of rows in the result.

- **Parameters**:  
  - `$query` (string): The SQL query to be executed.

- **Returns**:  
  - An integer representing the number of rows in the query result.

- **Usage**:  
  This method is useful for checking if a query returned any rows, such as for verifying if a record exists.

  Example:
  ```php
  $numRows = $db->query_num_rows("SELECT * FROM users");
  ```

### **Method: `num_rows()`**

```php
public function num_rows(mysqli_result $result): int
```

- **Purpose**:  
  Returns the number of rows from a given result object.

- **Parameters**:  
  - `$result` (mysqli_result): The result of a previously executed query.

- **Returns**:  
  - The number of rows in the result set.

- **Usage**:  
  This method can be used to determine how many rows were returned by a query.

---

## **Utility Methods**

### **Method: `filter()`**

```php
public function filter(string $string): string
```

- **Purpose**:  
  Escapes special characters in a string for safe use in SQL queries, preventing SQL injection.

- **Parameters**:  
  - `$string` (string): The string to be filtered.

- **Returns**:  
  - A string that is safe to use in SQL queries.

- **Usage**:  
  Use this method to sanitize input before using it in a SQL query.

  Example:
  ```php
  $safeInput = $db->filter($userInput);
  ```

---

## **Example Usage**

### Connecting to the Database

```php
$db = new Database();
```

### Executing a Query

```php
$result = $db->query("SELECT * FROM users");
```

### Fetching Results

```php
$rows = $db->query_fetch_array("SELECT * FROM users");
foreach ($rows as $row) {
    echo $row['username'];
}
```

### Getting the Number of Rows

```php
$numRows = $db->query_num_rows("SELECT * FROM users");
echo "Number of users: " . $numRows;
```

---

## **Conclusion**

- **Database Connection**:  
  The `Database` class provides an easy interface to connect to a MySQL database and execute queries.

- **Fetching Results**:  
  You can fetch results as arrays using `query_fetch_array()` or fetch a single row with `fetch_array()`.

- **Sanitizing Input**:  
  Use the `filter()` method to escape user inputs before using them in SQL queries.

- **Error Handling**:  
  If a query fails, the methods will terminate the script and display an error message.

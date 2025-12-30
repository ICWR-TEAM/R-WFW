# **Model Usage Documentation**

---

## **Creating a Model**

Models in R-WFW handle the data layer and business logic of your application. They typically contain methods for processing data or interacting with the database. In R-WFW, models extend the base `Model` class.

### Example Model:

```php
namespace App\Controllers;

use App\Core\Controller;

class TestParameter extends Controller
{
    public function index($parameters): void
    {
        $data['title'] = 'Test';

        // Displaying the header with 'title' data
        $this->view(view: 'templates/header', data: $data);

        // Calling the testFunc method from the model and passing the received parameters
        if ($data['result'] = $this->model(model: 'TestParameterModel')->testFunc($parameters)) {
            // Displaying the result if valid
            $this->view(view: 'home/parameter', data: $data);
        }

        // Displaying the footer after the content
        $this->view(view: 'templates/footer', data: $data);
    }
}
```

### Model Explanation:

- **Class Definition**:  
  `TestParameterModel` extends the `Model` class, which provides core functionality such as interacting with the database (though this example doesn't require DB interaction).
  
- **Method**:  
  The `testFunc()` method checks if the parameters passed are numeric. If both are numeric, it adds them together and returns a string with the result. Otherwise, it returns an error message.

- **Return Value**:  
  The method returns a string, either showing the sum of the parameters if valid or an error message if the input is invalid.

---

## **Using the Model in Controllers**

To use the `TestParameterModel`, you can instantiate it inside a controller and call the `testFunc()` method to process the data.

### Example Controller Using the Model:

```php
namespace App\Controllers;

use App\Core\Controller;

class ExampleController extends Controller
{
    public function calculate($parameters): void
    {
        // The model is already loaded via $this->model(), no need for 'use' statement
        $result = $this->model(model: 'TestParameterModel')->testFunc($parameters);

        // Passing the result to the view
        $this->view('api/result', ['response' => $result]);
    }
}
```

### Controller Explanation:

- **Model Instantiation**:  
  The controller doesn't need to manually instantiate the model with `new TestParameterModel()`. Instead, it uses `$this->model()` to load the model and call its methods.
  
- **Calling Model Method**:  
  The `testFunc()` method is called with the `$parameters` passed to the controller, and the result is stored in `$result`.

- **Passing Data to Views**:  
  The result returned from the model is passed to the view `api/result` using `$this->view()` to be displayed in the front-end.

---

## **Conclusion**

- **Models** are responsible for handling business logic and processing data.
- You can define methods inside models to perform specific tasks, like calculations or input validation.
- Models are used inside controllers by calling `$this->model()` to load and interact with them.
- Data returned from models can be passed to views using `$this->view()`.

# **Controller Usage Documentation**

---

## **Creating a Controller**

Controllers in R-WFW handle incoming requests, interact with models, and return views or responses. A controller method is mapped to a specific route and is executed when the route is accessed.

### Example Controller:

```php
namespace App\Controllers;

use App\Core\Controller;

class TestParameter extends Controller
{
    public function index($parameters): void
    {
        $data['title'] = 'Test';

        $this->view('templates/header', $data);

        if ($data['result'] = $this->model('TestParameterModel')->testFunc($parameters)) {
            $this->view('home/parameter', $data);
        }

        $this->view('templates/footer', $data);
    }
}
```

### Controller Explanation:

- **Class Definition**:  
  The `TestParameter` controller extends the base `Controller` class and defines the actions (methods) to handle the requests.

- **Method**:  
  The `index()` method accepts `$parameters` and handles the logic for rendering the view.
  
- **Loading Views**:  
  The controller uses `$this->view()` to load views. It first loads the `header` view, processes the business logic using the model, and then loads the `parameter` view with the result. Finally, it loads the `footer` view.
  
- **Using Models**:  
  The controller accesses the model (`TestParameterModel`) via `$this->model()`. It calls the `testFunc()` method of the model with the passed `$parameters` and assigns the result to `$data['result']`.

- **View Data**:  
  The data (`$data`) is passed to the views, allowing dynamic content to be displayed. For instance, `$data['title']` is used in the `header` view, and `$data['result']` is used in the `parameter` view.

---

## **Using the Controller with Routes**

To use the `TestParameter` controller, you can map a route to the `index()` method.

### Example Route Setup:

```php
$route->Route(method: 'get', url: '/test/parameter/{1}/parameter/{2}/', handler: "TestParameter::index");
```

- The route `'/test/parameter/{1}/parameter/{2}/'` will call the `index()` method of `TestParameter` controller with parameter.

---

## **Conclusion**

- **Controllers** manage user requests and interact with models and views.
- Use `$this->view()` to render views, passing any necessary data.
- Use `$this->model()` to access models and call their methods within controller actions.
- Controllers are mapped to routes, and their methods are executed when the corresponding route is accessed.

# **View Usage Documentation**

---

## **Creating a View**

Views in R-WFW are responsible for rendering the HTML output for the client. Views can contain dynamic content using PHP variables passed from the controller.

### Example View: `parameter.php`

```html
<div class="container mt-5 p-5 shadow" style="font-size: 15px;">
    <div>
        <span style="font-weight: bold;">Parameter Test</span>
        <hr class="mb-3" />
        <span>
           Output:
           <br />
           <?=$data['result']; ?>
        </span>
        <hr class="mb-3" />
    </div>
</div>
```

### View Explanation:

- **HTML Structure**:  
  The view consists of a `div` container with Bootstrap classes (`mt-5`, `p-5`, `shadow`) for styling and padding.

- **Dynamic Content**:  
  The view uses `<?=$data['result']; ?>` to display dynamic content. The `result` value is passed from the controller to the view in the `$data` array.

- **Using PHP in Views**:  
  Views can include PHP code to insert dynamic content. In this case, the result of the model or controller action is printed directly into the view.

- **Separating Content**:  
  The use of `<hr />` tags separates different sections of content in the view, such as the title and the output.

---

## **Passing Data to Views**

In R-WFW, controllers pass data to views using the `$this->view()` method. The data is typically provided as an associative array, which is then accessible inside the view.

### Example Controller:

```php
namespace App\Controllers;

use App\Models\TestParameterModel;
use App\Core\Controller;

class TestParameter extends Controller
{
    public function index($parameters): void
    {
        $data['title'] = 'Parameter Test';

        // Call model method and store result
        $data['result'] = $this->model('TestParameterModel')->testFunc($parameters);

        // Pass data to view
        $this->view('home/parameter', $data);
    }
}
```

In the above controller:
- The result of `testFunc()` from the `TestParameterModel` is stored in `$data['result']`.
- This data is then passed to the `home/parameter` view, where it will be rendered.

---

## **Conclusion**

- **Views** are responsible for rendering HTML content with dynamic data.
- **Dynamic Data** can be passed from controllers to views using associative arrays.
- **PHP in Views** allows embedding dynamic content in the HTML structure.
- Use `$data['key']` to display the dynamic content in the view, where `key` is the name of the variable passed from the controller.

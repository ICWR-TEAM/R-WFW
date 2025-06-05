# **Library Documentation**

This guide explains how to install external libraries, store them in a custom folder (`app/vendor/`), and use Composer to manage them.

---

## **Overview**

By default, Composer installs libraries in `vendor/`, but in this setup, they are stored in `app/vendor/`. You can install libraries like `html2pdf` and `dompdf` via Composer, then load and use them in your application.

---

## **Steps to Add Libraries to a Custom Folder**

### 1. **Create the Custom Folder**

Ensure you have the following structure:

```
/project-root
  /app
    /vendor
  /composer.json
```

### 2. **Install Libraries Using Composer**

To install a specific library, run the following command from the root directory (where `composer.json` is):

```bash
composer require lib/lib
```

This command installs the `lib/lib` library (replace with the actual library you want) and places it under `app/vendor/`.

To install all libraries defined in `composer.json`:

```bash
composer install
```

This installs all required libraries into `app/vendor/`.

### 3. **Use the Libraries in Your Code**

Load the libraries dynamically using a custom `Library` loader. For example:

```php
<?php

namespace App\Models;

use App\Core\Library;

class TestPDFModel
{
    public function print(string $input): void
    {
        // Load and use html2pdf
        $html2pdf = (new Library())->load('Spipu\Html2Pdf\Html2Pdf');
        $html2pdf->writeHTML($input);
        $html2pdf->output();
    }

    public function printDomPDF(string $input): void
    {
        // Load and use dompdf
        $dompdf = (new Library())->load('Dompdf\Dompdf');
        $dompdf->loadHtml($input);
        $dompdf->render();
        $dompdf->stream();
    }
}
```

---

## **Composer Configuration for Custom Folder**

Your `composer.json` should look like this:

```json
{
  "name": "icwr-team/r-wfw",
  "require": {
    "spipu/html2pdf": "^5.3",
    "dompdf/dompdf": "^3.0"
  },
  "config": {
    "vendor-dir": "app/vendor"
  }
}
```

This configures Composer to install libraries in `app/vendor/`.

---

## **Conclusion**

This approach keeps your libraries organized in a custom directory while using Composer to manage them. The `Library` loader allows you to dynamically load and use libraries in your application.

--- 

Now, this includes the new step for adding a library via Composer and is ready for your use! Let me know if you need any further edits.

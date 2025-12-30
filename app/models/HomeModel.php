<?php

namespace App\Models;

use App\Core\Model;

class HomeModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function description(): string
    {
        return "R-WFW (Rusher Web FrameWork) is a backend framework designed to simplify web application development. It follows the Model-View-Controller (MVC) architecture, which separates the application logic, presentation, and data layers, facilitating the creation of clean and maintainable code. Additionally, R-WFW provides a powerful routing system, making it easy to define URL routes and map them to specific controller actions. It also includes a built-in template engine for managing application views, which enhances the separation of logic and presentation. Overall, R-WFW is a versatile framework that streamlines web application development, improving development speed and efficiency.";
    }

}

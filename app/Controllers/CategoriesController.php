<?php

use App\Libraries\Controller;
use App\Helpers\Auth;
use App\Helpers\HTTP;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->user = Auth::check();
        $this->categoryModel = $this->model("Category");
    }

    public function index()
    {
        $categories = $this->categoryModel->getCategories($this->user->id);
        $income_categories = array_filter($categories, fn ($cat) => $cat->type === "income");
        $expense_categories = array_filter($categories, fn ($cat) => $cat->type === "expense");

        $data = [
            "title" => "Categories",
            "page" => "categories",
            "user" => $this->user,
            "income-categories" => $income_categories,
            "expense-categories" => $expense_categories,
        ];

        $this->view("categories/categories", $data);
    }
    public function add()
    {
        // Auth::allowTo("categories", "admin");       
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $icons = $this->categoryModel->getIcons();

            if ($_GET["type"] === "income") {
                $data = [
                    "title" => "Cateories",
                    "page" => "categories",
                    "user" => $this->user,
                    "type" => "Income",
                    "icons" => $icons,
                    "btn-class" => "bg-active text-white",
                ];
            } elseif ($_GET["type"] === "expense") {
                $data = [
                    "title" => "Cateories",
                    "page" => "categories",
                    "user" => $this->user,
                    "type" => "Expense",
                    "icons" => $icons,
                    "btn-class" => "btn-danger",
                ];
            }

            $this->view("categories/add-category", $data);
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                "name" => $_POST["name"],
                "icon_id" => number_format($_POST["icon-id"]),
                "type" => $_POST["type"],
                "user_id" => $this->user->id,
            ];

            $id = $this->categoryModel->save($data);
            $type = $data['type'];
            if ($id) {
                HTTP::redirect("categories", "type=$type&added=true");
            } else {
                HTTP::redirect("categories/add", "type=$type&error=1");
            }
        }
    }
    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cat_id = $_POST["id"];
            $row = $this->categoryModel->delete($$cat_id, $this->user->id);

            if ($row > 0) {
                HTTP::redirect("categories", "deleted=true");
            } else {
                HTTP::redirect("categories", "error=1");
            }
        }
    }
}

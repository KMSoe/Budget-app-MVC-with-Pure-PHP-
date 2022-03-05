<?php

use App\Libraries\Controller;
use App\Helpers\Auth;
use App\Helpers\HTTP;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->user = Auth::check();
        $this->userModel = $this->model("User");
        $this->categoryModel = $this->model("Category");
        $this->budgetModel = $this->model("Budget");
    }

    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $categories = $this->categoryModel->getCategories($this->user->id);
            $income_categories = array_filter($categories, fn ($cat) => $cat->type === "income");
            $expense_categories = array_filter($categories, fn ($cat) => $cat->type === "expense");

            if ($_GET["type"] === "income") {
                $categories = $this->categoryModel->getCategories($this->user->id);
                $data = [
                    "user" => $this->user,
                    "title" => "Home",
                    "page" => "home",
                    "type" => "Income",
                    "categories" => $income_categories,
                    "btn-class" => "bg-active text-white",
                ];
            } elseif ($_GET["type"] === "expense") {
                $data = [
                    "user" => $this->user,
                    "title" => "Home",
                    "page" => "home",
                    "type" => "Expense",
                    "categories" => $expense_categories,
                    "btn-class" => "btn-danger",
                ];
            }

            $this->view("budget/add-budget", $data);
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            // $date = $_POST["date"] ? date($_POST['date']) : date("Y-m-d H:i:s");
            // $date = date()
            $data = [
                "category_id" => number_format($_POST["category-id"]),
                "remark" => $_POST["remark"],
                "type" => $_POST["type"],
                "amount" => $_POST["type"] === "income" ?  number_format((float) $_POST["amount"], 2, ".", "") : number_format((float) ("-" . $_POST["amount"]), 2, ".", ""),
                "created_at" => $_POST["date"] ? date("Y-m-d H:i:s", strtotime($_POST['date'])) : date("Y-m-d H:i:s"),
                "user_id" => $this->user->id,
            ];

            $id = $this->budgetModel->save($data);

            $type = $data['type'];
            if (intval($id)) {
                HTTP::redirect("", "type=$type&added=true");
            } else {
                HTTP::redirect("budget/add", "type=$type&error=1");
            }
        }
    }

    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            session_start();
    
            if ($_POST["token"] === $_SESSION[$_POST["budget-id"] . "_token"]) {
                $budget_id = number_format($_POST["budget-id"]);
                $user_id = number_format($_POST["user-id"]);

                $row = $this->budgetModel->delete($budget_id, $user_id);
                if (intval($row)) {
                    HTTP::redirect("", "deleted=true");
                } else {
                    HTTP::redirect("", "error=1");
                }
            } else {
                HTTP::redirect("budget/add", "error=1");
            }
        }
    }
}

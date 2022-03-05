<?php

use App\Libraries\Controller;
use App\Helpers\Auth;
use App\Helpers\HTTP;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->user = Auth::check();
        $this->userModel = $this->model("User");
        $this->budgetModel = $this->model("Budget");
    }

    public function index()
    {
        $months = ["Jan", "Feb", "Mar", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        if (isset($_GET["time"])) {
            $request_time = explode(" ", $_GET["time"]);
            if (count($request_time) !== 2) {
                HTTP::redirect("", "invalid=true");
            } elseif(in_array($request_time[0], $months) && intval($request_time[1])) {
                $month = array_search($request_time[0], $months) + 1;
                $year = $request_time[1];
            } else{
                HTTP::redirect("", "invalid=true");
            }
        } else {
            $year = date("Y");
            $month = date("m");
        }
        $request_month = $year . "-" . $months[intval($month) - 1];
        $income_amount = $expense_amount = $net_budget = 0;
        $income_amount = $this->budgetModel->calcBudgetWithinMonth($this->user->id, $month, $year, "income")[0]->amount;
        $expense_amount = $this->budgetModel->calcBudgetWithinMonth($this->user->id, $month, $year, "expense")[0]->amount;

        $net_budget = $income_amount + $expense_amount;
        $total_values = [
            "time" => $request_month,
            "income" => number_format($income_amount, 0, ".", ","),
            "expense" => number_format(abs($expense_amount), 0, ".", ","),
            "net_budget" => number_format($net_budget, 0, ".", ","),
            "percentage" => $net_budget <= 0 ? 100 : number_format((abs($expense_amount) / abs($income_amount) * 100), 2, "."),
        ];

        $budget_cards = $this->budgetModel->getDailyBudgetCards($this->user->id, $month, $year);

        $income_category_detail = $this->budgetModel->getBudgetOnCategoryByTypeInMonth($this->user->id, $month,  $year, "income");
        $expense_category_detail = $this->budgetModel->getBudgetOnCategoryByTypeInMonth($this->user->id, $month, $year, "expense");

        $data = [
            "title" => "Home",
            "page" => "home",
            "user" => $this->user,
            "total" => $total_values,
            "budget_cards" => $budget_cards,
            "category_detail" => [$income_category_detail, $expense_category_detail],
        ];
 
        $this->view("index", $data);
    }
}

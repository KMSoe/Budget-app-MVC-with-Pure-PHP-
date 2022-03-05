<?php

use App\Libraries\Controller;
use App\Helpers\Auth;
use App\Helpers\HTTP;


class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->user = Auth::check();
        $this->budgetModel = $this->model("Budget");
        $this->categoryModel = $this->model("Category");
    }

    public function index()
    {
        $user_start_year = $this->budgetModel->getStartYear($this->user->id)[0]->start_year;

        if (isset($_GET["year"])) {
            if(empty(intval($_GET["year"]))){
                HTTP::redirect("statistics", "invalid=true");
            }
            $year = intval($_GET["year"]);
            if ($year > date("Y")) {
                HTTP::redirect("statistics", "invalid=true");
            }elseif ($year < $user_start_year){
                HTTP::redirect("statistics", "invalid=true");
            }
             elseif ($year < date("Y")) {
                $month = 12;
            } else {
                $month = date("m");
            }
        } else {
            $year = date("Y");
            $month = date("m");
        }
        $yearly_results = $this->budgetModel->getYearlyResult($this->user->id, $year, $month);
        
        if (isset($_GET["first-date"]) && isset($_GET["first-date"])) {
            $start = date("Y-m-d", strtotime($_GET["first-date"]));
            $end = date("Y-m-d", strtotime($_GET["second-date"]));

            if(empty($_GET["first-date"]) || empty($_GET["second-date"]) || $start > $end){
                HTTP::redirect("statistics", "invalid=true");
            }
        } else {
            $start = date("Y-m-d", strtotime("2021-01-01"));
            $end = date("Y-m-d", strtotime("2021-12-31"));
        }

        $income_category_detail = $this->budgetModel->getBudgetOnCategoryByTypeWithDates($this->user->id, $start, $end, "income");
        $expense_category_detail = $this->budgetModel->getBudgetOnCategoryByTypeWithDates($this->user->id, $start, $end, "expense");
    
        $data = [
            "title" => "Statistics",
            "page" => "statistics",
            "user" => $this->user,
            "yearly_results" => $yearly_results,
            "category_detail" => [$income_category_detail, $expense_category_detail, date("M d Y", strtotime($start)) . " - " . date("M d Y", strtotime($end))],
        ];
        $this->view("statistics", $data);
    }
}

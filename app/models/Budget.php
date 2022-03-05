<?php
require_once "../app//models/Category.php";

use PDOException;
use App\Libraries\Database;

class Budget
{
    private $db;
    private $months = ["Jan", "Feb", "Mar", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    public function __construct()
    {
        $this->db = Database::getInstance()->connect();
        $this->categoryModel = new Category;
    }
    public function save($data)
    {
        try {
            $query = "INSERT INTO budget_items (category_id, remark, type, amount, created_at, user_id) VALUES (:category_id, :remark, :type, :amount, :created_at, :user_id)";
            $statement = $this->db->prepare($query);
            $statement->execute($data);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function calcBudgetWithinMonth($user_id, $month, $year, $type)
    {
        try {
            $query = "SELECT SUM(amount) AS amount FROM budget_items WHERE user_id=:user_id AND MONTH(created_at)=:month AND YEAR(created_at)=:year AND type=:type";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "month" => $month,
                "year" => $year,
                "type" => $type,
            ]);

            return $statement->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function calcBudgetByTime($user_id, $month, $year, $type)
    {
        try {
            $query = "SELECT SUM(amount) AS amount FROM budget_items WHERE user_id=:user_id AND MONTH(created_at)=:month AND YEAR(created_at)=:year AND type=:type";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "month" => $month,
                "year" => $year,
                "type" => $type,
            ]);

            return $statement->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function calcBudgetByLimit($user_id, $start, $end, $type)
    {
        try {
            $query = "SELECT SUM(amount) AS amount FROM budget_items WHERE user_id=:user_id AND DATE(created_at) >= :start AND DATE(created_at) <= :end AND type=:type";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "start" => $start,
                "end" => $end,
                "type" => $type,
            ]);

            return $statement->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getBudgetOnCategoryByTypeInMonth($user_id, $month, $year, $type)
    {
        try {
            $query = "SELECT SUM(budget_items.amount) AS amount, budget_items.category_id, categories.name FROM budget_items LEFT JOIN categories ON budget_items.category_id=categories.id WHERE budget_items.user_id=:user_id AND MONTH(budget_items.created_at)=:month AND YEAR(budget_items.created_at)=:year AND budget_items.type=:type GROUP BY budget_items.category_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "month" => $month,
                "year" => $year,
                "type" => $type,
            ]);

            $row = $statement->fetchAll();

            $category_names = $category_amount_percentages = $category_colors = [];
            $len = count($row);
            if ($len > 0) {
                for ($i = 0; $i < $len; $i++) {
                    $row[$i]->percentage = number_format((abs($row[$i]->amount) / abs($this->calcBudgetByTime($user_id, $month, $year, $type)[0]->amount) * 100), 2, ".");
                    $row[$i]->amount = abs($row[$i]->amount);
                    $categories = $this->categoryModel->getCategoryIconColor($row[$i]->category_id);
                    $row[$i]->color = $categories[0]->color;
                    $row[$i]->amount = number_format(abs($row[$i]->amount), 0, ".", ",");

                    $category_names[] = $row[$i]->name;
                    $category_amount_percentages[] = $row[$i]->percentage;
                    $category_colors[] = $row[$i]->color;
                }
            } else {
                $category_names[] = "No " . ucfirst($type);
                $category_amount_percentages[] = 100;
                $category_colors[] = "gray";
            }
            $category_pie_data = [$category_names, $category_amount_percentages, $category_colors];
            return [$row, $category_pie_data];
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getBudgetOnCategoryByTypeWithDates($user_id, $start, $end, $type)
    {
        try {
            $query = "SELECT SUM(budget_items.amount) AS amount, budget_items.category_id, categories.name FROM budget_items LEFT JOIN categories ON budget_items.category_id=categories.id WHERE budget_items.user_id=:user_id AND budget_items.type=:type AND DATE(budget_items.created_at) >= :start AND DATE(budget_items.created_at) <= :end GROUP BY budget_items.category_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "start" => $start,
                "end" => $end,
                "type" => $type,
            ]);

            $row = $statement->fetchAll();

            $category_names = $category_amount_percentages = $category_colors = [];
            $total = 0;
            $len = count($row);
            if ($len > 0) {
                for ($i = 0; $i < $len; $i++) {
                    $row[$i]->percentage = number_format((abs($row[$i]->amount) / abs($this->calcBudgetByLimit($user_id, $start, $end, $type)[0]->amount) * 100), 2, ".");
                    $total += $row[$i]->amount = abs($row[$i]->amount);
                    $categories = $this->categoryModel->getCategoryIconColor($row[$i]->category_id);
                    $row[$i]->color = $categories[0]->color;
                    $row[$i]->amount = number_format(abs($row[$i]->amount), 0, ".", ",");

                    $category_names[] = $row[$i]->name;
                    $category_amount_percentages[] = $row[$i]->percentage;
                    $category_colors[] = $row[$i]->color;
                }
            } else {
                $category_names[] = "No " . ucfirst($type);
                $category_amount_percentages[] = 100;
                $category_colors[] = "gray";
            }
            $category_pie_data = [$category_names, $category_amount_percentages, $category_colors, $total];
            return [$row, $category_pie_data];
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getDailyTotalBudgetByType($user_id, $type, $date)
    {
        try {
            $query = "SELECT SUM(amount) AS amount FROM budget_items WHERE user_id=:user_id AND budget_items.type=:type AND DATE(created_at)=:date";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "type" => $type,
                "date" => $date,
            ]);
            $row = $statement->fetchAll();

            return $row;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getDailyNetBudget($user_id, $month, $year)
    {
        try {
            $query = "SELECT SUM(amount) AS amount, DATE(budget_items.created_at) as date FROM budget_items WHERE user_id=:user_id AND MONTH(created_at)=:month AND YEAR(created_at)=:year GROUP BY DATE(created_at) DESC";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "month" => $month,
                "year" => $year,
            ]);
            $row = $statement->fetchAll();

            return $row;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getDailyBudgets($user_id, $date)
    {
        try {
            $query = "SELECT budget_items.*, budget_items.category_id, categories.name AS category_name FROM budget_items LEFT JOIN categories ON budget_items.category_id=categories.id WHERE budget_items.user_id=:user_id AND DATE(budget_items.created_at)=:date";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
                "date" => $date,
            ]);
            $row = $statement->fetchAll();
            $len = count($row);
            for ($i = 0; $i < $len; $i++) {
                $row[$i]->icon = $this->categoryModel->getIconColor($row[$i]->category_id)[0];
                $row[$i]->amount = number_format($row[$i]->amount, 0, ".", ",");
            }
            return $row;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getDailyBudgetCards($user_id, $month, $year)
    {
        $monthly_total_income = $this->calcBudgetWithinMonth($user_id, $month, $year, "income")[0]->amount;

        $daily_budgets = $this->getDailyNetBudget($user_id, $month, $year);
        $len = count($daily_budgets);
        for ($i = 0; $i < $len; $i++) {
            $income = $this->getDailyTotalBudgetByType($user_id, "income", $daily_budgets[$i]->date)[0]->amount ?? 0;
            $expense = abs($this->getDailyTotalBudgetByType($user_id, "expense", $daily_budgets[$i]->date)[0]->amount ?? 0);
            $daily_budgets[$i]->day = date("M d", strtotime($daily_budgets[$i]->date));
            $daily_budgets[$i]->income = number_format($income, 0, ".", ",");
            $daily_budgets[$i]->expense = number_format($expense, 0, ".", ",");
            $daily_budgets[$i]->budget_items = $this->getDailyBudgets($user_id, $daily_budgets[$i]->date);
            $daily_budgets[$i]->percentage = intval($monthly_total_income) === 0 ? 100 : number_format(($expense / $monthly_total_income) * 100, 2, ".", ",");
        }

        return $daily_budgets;
    }
    public function getYearlyResult($user_id, $year, $num_month)
    {
        $monthly_results = [];
        $yearly_result = [];
        $result_months = $incomes = $expenses = $net_budgets = [];
        for ($i = 1; $i <= $num_month; $i++) {
            $income_amount = $expense_amount = $net_budget = 0;
            $income_amount = $this->calcBudgetWithinMonth($user_id, $i, $year, "income")[0]->amount ?? 0;
            $expense_amount = $this->calcBudgetWithinMonth($user_id, $i, $year, "expense")[0]->amount ?? 0;

            $net_budget = $income_amount + $expense_amount;
            $res = [
                "month" => $this->months[$i - 1],
                "income" => number_format($income_amount, 0, ".", ","),
                "expense" => number_format($expense_amount, 0, ".", ","),
                "net_budget" => number_format($net_budget, 0, ".", ","),
            ];
            $result_months[] = $this->months[$i - 1];
            $incomes[] = $income_amount;
            $expenses[] = abs($expense_amount);
            $net_budgets[] = $net_budget;
            $monthly_results[] = $res;
        }

        $yearly_result[] = $monthly_results;
        $yearly_result[] = [
            "year" => $year,
            "total_income" => number_format(array_sum($incomes), 0, ".", ","),
            "total_expense" => number_format("-" . array_sum($expenses), 0, ".", ","),
            "net_budget" => number_format(array_sum($net_budgets), 0, ".", ","),
            "percentage" => array_sum($incomes) === 0 ? 100 : number_format((array_sum($expenses) / array_sum($incomes)) * 100, 2, ".", ",")
        ];
        $yearly_result[] = $result_months;
        $yearly_result[] = $incomes;
        $yearly_result[] = $expenses;
        
        return $yearly_result;
    }
    public function getBudgetBriefTables($user_id, $start_year)
    {
        $month = 12;
        $current_year = date("Y");
        if ($start_year === $current_year) {
            $month = date("m");
        }

        $result = [];

        for ($i = $current_year; $i >= $start_year; $i--) {
            $yearly_result = $this->getYearlyResult($user_id, $i, $month);
            $result[] = $yearly_result;
        }
        return $result;
    }
    public function getStartYear($user_id)
    {
        try {
            $query = "SELECT MIN(YEAR(created_at)) AS start_year FROM budget_items WHERE user_id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "user_id" => $user_id,
            ]);

            return $statement->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function delete($id, $user_id)
    {
        try {
            $query = "DELETE FROM budget_items WHERE id=:id AND user_id=:user_id";
            $statement = $this->db->prepare($query);
            $statement->execute([
                "id" => $id,
                "user_id" => $user_id,
            ]);

            return $statement->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

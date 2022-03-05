<?php

use App\Libraries\Controller;
use App\Helpers\Auth;
use App\Helpers\HTTP;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->user = Auth::check();
        $this->userModel = $this->model("User");
        $this->budgetModel = $this->model("Budget");
    }

    public function index()
    {
        $user_start_year = $this->budgetModel->getStartYear($this->user->id)[0]->start_year ?? date("Y");

        $results = $this->budgetModel->getBudgetBriefTables($this->user->id, $user_start_year);

        $data = [
            "title" => "Profile",
            "page" => "profile",
            "user" => $this->user,
            "result" => $results,
        ];
 
        $this->view("profile", $data);
    }

    public function upload()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if ($this->user->photo) {
                unlink("../public/images/" . $this->user->photo);
            }

            $error = $_FILES["photo"]["error"];
            $name = $_FILES["photo"]["name"];
            $tmp = $_FILES["photo"]["tmp_name"];
            $type = $_FILES["photo"]["type"];
            
            if ($error) {
                HTTP::redirect("profile", "error=file");
            }

            if ($type === "image/jpeg" or $type === "image/png" or $type === "image/svg") {
                $photo = explode(" ", $this->user->name)[0] . "-" . time() . "-" . $this->user->id . ".jpeg";
                $this->userModel->uploadPhoto($this->user->id, $photo);
                move_uploaded_file($tmp, "../public/images/$photo");
    
                $this->user->photo = $photo;
                HTTP::redirect("profile", "uploaded=true");
            } else {
                HTTP::redirect("profile", "error=type");
            }
        }
    }
}

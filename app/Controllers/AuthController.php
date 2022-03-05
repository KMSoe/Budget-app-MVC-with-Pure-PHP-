<?php

use App\Libraries\Controller;
use App\Helpers\Auth;
use App\Helpers\HTTP;
use App\Helpers\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model("User");
        $this->mailModel = new Mail();
    }

    public function signin()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $data = [
                "title" => "Signin",
            ];
            $this->view("user/signin", $data);
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = $this->userModel->findByEmail($email);

            session_start();
            if ($user) {
                if ($user->activated) {
                    if (!$user->suspended) {
                        if (password_verify($password, $user->password)) {
                            $_SESSION["user"] = $user;
                            HTTP::redirect("", "login=true");
                        } else {
                            HTTP::redirect("auth/signin", "incorrect=true");
                        }
                    } else {
                        HTTP::redirect("auth/signin", "suspended=true");
                    }
                } else {
                    HTTP::redirect("auth/signin", "notactivated=1");
                }
            } else {
                HTTP::redirect("auth/signin", "incorrect=true");
            }
        }
    }
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $data = [
                "title" => "Register",
            ];
            $this->view("user/register", $data);
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $token = password_hash($_POST["email"], PASSWORD_BCRYPT);

            session_start();
            $verification_csrf = sha1(rand(1, 1000) . "secret");
            $_SESSION["verification_csrf"] = $verification_csrf;

            $data = [
                "name" => $_POST["username"],
                "email" => $_POST["email"],
                "verification_token" => $token,
                "password" => password_hash($_POST["password"], PASSWORD_BCRYPT),
            ];

            $result = $this->userModel->findByEmail($data["email"]);

            if (empty($result->id)) {
                $id = $this->userModel->save($data);
                echo $id;
                if (intval($id)) {

                    $mail_data = [
                        "address" => $data["email"],
                        "name" => $data["name"],
                        "subject" => "Activate Your Account",
                        "template_variables" => [
                            "name" => $data["name"],
                            "activate_url" => URLROOT . "auth/activate?id=$id&token=$token&verification_csrf=$verification_csrf",
                        ]
                    ];
                    try {
                        $this->mailModel->sendWelcome($mail_data);

                        $data = [
                            "title" => "Mail Sent",
                            "link" => "Activation link",
                        ];
                        $this->view("mail-sent", $data);
                    } catch (\Throwable $th) {
                        HTTP::redirect("auth/register", "mailError=1");
                    }
                } else {
                    HTTP::redirect("auth/register", "error=1");
                }
            } else {
                HTTP::redirect("auth/register", "already=true");
            }
        }
    }
    public function activate()
    {
        $id = $_GET["id"];
        $token = $_GET["token"];
        $csrf = $_GET["verification_csrf"];

        session_start();
        if (isset($id) && isset($token) && isset($csrf) && $_SESSION["verification_csrf"] === $csrf) {
            $user = $this->userModel->findById($id);
            if ($user->verification_token === $token) {
                $row = $this->userModel->activate($id);

                if ($row === 0) {
                    $result = $this->userModel->setNullVerifyToken($id);
                    HTTP::redirect("auth/signin", "activated=true");
                } else {
                    HTTP::redirect("auth/register", "error=1");
                }
            }
        } else {
            HTTP::redirect("auth/register", "error=1");
        }
    }
    public function signout()
    {
        session_start();
        unset($_SESSION["user"]);
        HTTP::redirect("auth/signin", "logout=true");
    }
    public function forgot()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $data = [
                "title" => "Forgot Password",
            ];
            $this->view("user/forgot", $data);
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user = $this->userModel->findByEmail($_POST["email"]);
            if (!$user) {
                HTTP::redirect("auth/forgot", "notExist=1");
            }
            if (!$user->activated) {
                HTTP::redirect("auth/forgot", "notactivited=1");
            }
            $token = password_hash($_POST["email"], PASSWORD_BCRYPT);

            session_start();
            $reset_csrf = sha1(rand(1, 1000) . "secret");
            $_SESSION["reset_csrf"] = $reset_csrf;

            $data = [
                "name" => $user->name,
                "email" => $user->email,
                "reset_password_token" => $token,
                "reset_token_expire" => date("Y-m-d h:i:s", time() + 60 * 10),
            ];

            $row = $this->userModel->updateResetToken($user->id, $data["reset_password_token"], $data["reset_token_expire"]);

            if ($row !== 1) {
                HTTP::redirect("auth/forgot", "error=1");
            }
            $mail_data = [
                "address" => $data["email"],
                "name" => $data["name"],
                "subject" => "Reset Your Password",
                "template_variables" => [
                    "name" => $data["name"],
                    "reset_url" => URLROOT . "auth/reset?id=$user->id&token=$token&reset_csrf=$reset_csrf",
                ]
            ];
            try {
                $this->mailModel->sendResetPasswordToken($mail_data);

                $data = [
                    "title" => "Mail Sent",
                    "link" => "Reset link",
                ];
                $this->view("mail-sent", $data);
            } catch (\Throwable $th) {
                HTTP::redirect("auth/forgot", "mailError=1");
            }
        }
    }
    public function reset()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $id = $_GET["id"];
            $token = $_GET["token"];
            $csrf = $_GET["reset_csrf"];

            session_start();
            if (isset($id) && isset($token) && isset($csrf) && $_SESSION["reset_csrf"] === $csrf) {
                $user = $this->userModel->findById($id);

                if ($user->reset_password_token === $token && $user->reset_token_expire > date("Y-m-d h:i:s")) {
                    $data = [
                        "title" => "Reset Password",
                        "id" => $id,
                        "token" => $token,
                        "csrf" => $csrf,
                    ];
                    $this->view("user/reset-password", $data);
                } else {
                    HTTP::redirect("auth/forgot", "token_expire=1");
                }
            } else {
                HTTP::redirect("auth/forgot", "error=1");
            }
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $token = $_POST["token"];
            $csrf = $_POST["csrf"];
            $password = $_POST["password"];

            session_start();
            if (isset($id) && isset($token) && isset($csrf) && $_SESSION["reset_csrf"] === $csrf) {
                $user = $this->userModel->findById($id);

                if ($user->reset_password_token === $token && $user->reset_token_expire > date("Y-m-d h:i:s")) {
                    $row = $this->userModel->resetPassword($id, password_hash($password, PASSWORD_BCRYPT));

                    if ($row === 1) {
                        // $result = $this->userModel->setNullResetToken($id);
                        HTTP::redirect("auth/signin", "changed=true");
                    } else {
                        HTTP::redirect("auth/reset", "error=1");
                    }
                }
            } else {
                HTTP::redirect("auth/reset", "error=1");
            }
        }
    }
    public function changePassword()
    {
        $user = Auth::check();
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $id = $_GET["id"];
            $csrf = $_GET["csrf"];

            session_start();
            if (isset($id) && isset($csrf) && $_SESSION["changePassword_csrf"] === $csrf) {
                $data = [
                    "title" => "Change Password",
                    "id" => $id,
                    "csrf" => $csrf,
                    "user" => $user,
                ];
                $this->view("user/change-password", $data);
            } else {
                HTTP::redirect("profile", "error=1");
            }
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $csrf = $_POST["csrf"];
            $current_password = $_POST["current-password"];
            $new_password = $_POST["new-password"];

            session_start();
            if (isset($id) && isset($csrf) && isset($current_password) && isset($new_password)  && $_SESSION["changePassword_csrf"] === $csrf) {
                $user = $this->userModel->findById($id);

                if ($user) {
                    if (password_verify($current_password, $user->password)) {
                        $row = $this->userModel->changePassword($id, password_hash($new_password, PASSWORD_BCRYPT));

                        if ($row === 1) {
                            HTTP::redirect("auth/signin", "changed=true");
                        } else {
                            HTTP::redirect("profile", "error=1");
                        }
                    } else {
                        HTTP::redirect("auth/changePassword", "id=$id&csrf=$csrf&notequal=1");
                    }
                } else {
                    HTTP::redirect("profile", "error=1");
                }
            } else {
                HTTP::redirect("profile", "error=1");
            }
        }
    }
}

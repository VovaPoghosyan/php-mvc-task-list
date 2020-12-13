<?php

class AuthController extends Controller
{

    public function showRegistrationAction()
    {
        $this->checkSessionTime();
        $errorMessages = Session::get("error_messages");
        $old = Session::get("old_values") ? Session::get("old_values") : [];
        $this->render("auth/registration", [
            'old'   => $old,
            'error' => $errorMessages ? $errorMessages : []
        ]);
    }

    public function registrationAction()
    {
        if (!Session::get('userId')) {
            $user         = new User();
            $firstname    = isset($_POST['firstname']) ? App::test_input($_POST['firstname']) : '';
            $lastname     = isset($_POST['lastname']) ? App::test_input($_POST['lastname']) : '';
            $email        = isset($_POST['email']) ? App::test_input($_POST['email']) : '';
            $password     = isset($_POST['password']) ? App::test_input($_POST['password']) : '';
            $confpassword = isset($_POST['confPassword']) ? App::test_input($_POST['confPassword']) : '';
            $gender       = isset($_POST['gender']) ? $_POST['gender'] : 'MALE';
            $errorArr     = [];

            if (empty($firstname)) {
                $errorArr["firstname"] = "(Please write your first name!)";
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
                $errorArr["firstname"] = "(Please write correct first name!)";
            }

            if (empty($lastname)) {
                $errorArr["lastname"] = "(Please write your last name!)";
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
                $errorArr["lastname"] = "(Please write your last name!)";
            }

            if (empty($email)) {
                $errorArr["email"] = "(Please write your email address!)";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorArr["email"] = "(Please write correct email address!)";
            } elseif (count($user->get()->simple(["email" => $email])->query()) > 0) {
                $errorArr["email"] = "(that email is busy!)";
            }

            if (empty($password)) {
                $errorArr["password"] = "(Please write your password!)";
            } elseif (empty($confpassword)) {
                $errorArr["password"] = "(Please write confirm password!)";
            } elseif ($password != $confpassword) {
                $errorArr["confpassword"] = "(write correct confirm password!)";
            }
            Session::set("error_messages", $errorArr);
            Session::set("message_time", time());
            Session::set("old_values", [
                "firstname" => $firstname,
                "lastname"  => $lastname,
                "email"     => $email,
                "gender"    => $gender
            ]);

            if (!count($errorArr)) {
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $data = [
                    "firstname" => $firstname,
                    "lastname"  => $lastname,
                    "email"     => $email,
                    "password"  => $hash_password,
                    "gender"    => $gender
                ];
                if ($user->insert($data)) {
                    return $this->redirect("login");
                } else {
                    die(mysqli_errno(User::getConn()));
                }
            } else {
                return $this->redirect("registration");
            }
        } else {
            $this->redirect("tasks");
        }
    }

    public function showLoginAction()
    {
        $this->checkSessionTime();
        $errorMessages = Session::get("error_messages");
        $old = Session::get("old_values") ? Session::get("old_values") : [];
        $this->render("auth/login", [
            'old'   => $old,
            'error' => $errorMessages ? $errorMessages : []
        ]);
    }

    public function loginAction()
    {
        if (!Session::get('userId')) {
            $user     = new User();
            $email    = isset($_POST['email']) ? App::test_input($_POST['email']) : '';
            $password = isset($_POST['password']) ? App::test_input($_POST['password']) : '';
            $errorArr = [];
            if (empty($email)) {
                $errorArr["email"] = "(Please write your email address!)";
            }

            if (empty($password)) {
                $errorArr["password"] = "(Please write confirm password!)";
            }
            Session::set("error_messages", $errorArr);
            Session::set("message_time", time());
            Session::set("old_values", [
                "email" => $email,
            ]);
            if (!count($errorArr)) {
                $currentUser = $user->get(false, ["id", "password"])->simple(["email" => $email])->query();
                if (count($currentUser)) {
                    if (password_verify($password, $currentUser[0]['password'])) {
                        Session::set("userId", $currentUser[0]['id']);
                        $this->redirect("tasks");
                    } else {
                        Session::set("password", "(write right password!)");
                    }
                }
            }
            $this->redirect("login");
        } else {
            $this->redirect("tasks");
        }
    }

    public function logoutAction()
    {
        Session::destroy();
        $this->redirect("tasks");
    }
}

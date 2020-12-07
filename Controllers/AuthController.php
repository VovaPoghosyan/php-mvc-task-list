<?php

class AuthController extends Controller
{

    public function showRegistrationAction()
    {
        $this->layout = "auth";
        $this->render("auth/registration");
    }

    public function registrationAction()
    {
        if (!Session::get('userId')) {
            $user         = new User();
            $error        = false;
            $firstname    = isset($_POST['firstname']) ? App::test_input($_POST['firstname']) : '';
            $lastname     = isset($_POST['lastname']) ? App::test_input($_POST['lastname']) : '';
            $email        = isset($_POST['email']) ? App::test_input($_POST['email']) : '';
            $password     = isset($_POST['password']) ? App::test_input($_POST['password']) : '';
            $confpassword = isset($_POST['confPassword']) ? App::test_input($_POST['confPassword']) : '';
            $gender       = isset($_POST['gender']) ? $_POST['gender'] : 'MALE';

            if (empty($firstname)) {
                Session::set("firstname", "(Please write your first name!)");
                $error = true;
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
                Session::set("firstname", "(Please write correct first name!)");
                $error = true;
            }

            if (empty($lastname)) {
                Session::set("lastname", "(Please write your last name!)");
                $error = true;
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
                Session::set("lastname", "(Please write correct last name!)");
                $error = true;
            }

            if (empty($email)) {
                Session::set("email", "(Please write your email address!)");
                $error = true;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Session::set("email", "(Please write correct email address!)");
                $error = true;
            } elseif (count($user->get()->simple(["email" => $email])->query()) > 0) {
                Session::set("email", "(that email is busy!)");
                $error = true;
            }

            if (empty($password)) {
                $error = true;
                Session::set("password", "(Please write your password!)");
            } elseif (empty($confpassword)) {
                $error = true;
                Session::set("password", "(Please write confirm password!)");
            } elseif ($password != $confpassword) {
                $error = true;
                Session::set("confpassword", "(write correct confirm password!)");
            }


            if (!$error) {
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
            $this->redirect("profile");
        }
    }

    public function showLoginAction()
    {
        $this->layout = "auth";
        $this->render("auth/login");
    }

    public function loginAction()
    {
        if (!Session::get('userId')) {
            $user     = new User();
            $error    = false;
            $email    = isset($_POST['email']) ? App::test_input($_POST['email']) : '';
            $password = isset($_POST['password']) ? App::test_input($_POST['password']) : '';
            if (empty($email)) {
                Session::set("email", "(Please write your email address!)");
                $error = true;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Session::set("email", "(Please write correct email address!)");
                $error = true;
            }

            if (empty($password)) {
                $error = true;
                Session::set("password", "(Please write your password!)");
            }
            if (!$error) {
                $currentUser = $user->get(false, ["id", "password"])->simple(["email" => $email])->query();
                if (count($currentUser)) {
                    if (password_verify($password, $currentUser[0]['password'])) {
                        Session::set("userId", $currentUser['id']);
                        $this->redirect("profile");
                    } else {
                        Session::set("password", "(write right password!)");
                    }
                }
            }
            $this->redirect("login");
        } else {
            $this->redirect("profile");
        }
    }
}

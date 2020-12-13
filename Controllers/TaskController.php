<?php

class TaskController extends Controller
{
    public function getAllTasksAction()
    {
        $task  = new Task();
        $tasks = $task->get(false, ["title", "description", "created_by", "done"])->query();

        $this->render("tasks/index", ['tasks' => $tasks]);
    }

    public function showCreateTaskAction()
    {
        $this->render("tasks/form", ['create' => true]);
    }

    public function createTaskAction()
    {
        echo '<pre>';
        var_dump(Session::get('userId'));
        die('///');
        $task = new Task();
        if ($id = Session::get('userId')) {
            $user        = new User();
            $currentUser = $user->get(false, ["firstname", "lastname"])->simple(["id" => $id]);
            $created_by  = $currentUser["firstname"] . ' ' . $currentUser["lastname"];
        } else {
            $created_by = isset($_POST['created_by']) ? App::test_input($_POST['created_by']) : '';
            if (empty($created_by)) {
                Session::set("created_by", "(Please write your name!)");
                $error = true;
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $created_by)) {
                Session::set("created_by", "(Please write correct name!)");
                $error = true;
            }
        }
        $error       = false;
        $title       = isset($_POST['title']) ? App::test_input($_POST['title']) : '';
        $description = isset($_POST['description']) ? App::test_input($_POST['description']) : '';

        if (empty($title)) {
            $error = true;
            Session::set("title", "(Please write title!)");
        } elseif (!ctype_alnum($title)) {
            $error = true;
            Session::set("title", "(Please write title!)");
        }

        if (empty($description)) {
            $error = true;
            Session::set("title", "(Please write description!)");
        }


        if (!$error) {
            $data = [
                "title"       => $title,
                "description" => $description,
                "created_by"  => $created_by
            ];
            if ($task->insert($data)) {
                $this->redirect("tasks");
            } else {
                die(mysqli_errno(Task::getConn()));
            }
        } else {
            $this->redirect("user/login");
        }
    }

    public function updateAction($id)
    {
        $user         = new Task();
        $firstname    = isset($_POST['firstname']) ? App::test_input($_POST['firstname']) : '';
        $lastname     = isset($_POST['lastname']) ? App::test_input($_POST['lastname']) : '';
        $email        = isset($_POST['email']) ? App::test_input($_POST['email']) : '';
        $password     = isset($_POST['password']) ? App::test_input($_POST['password']) : '';
        $confpassword = isset($_POST['confPassword']) ? App::test_input($_POST['confPassword']) : '';
        $gender       = isset($_POST['gender']) ? $_POST['gender'] : 'MALE';

        $data = [];
        if (!empty($firstname) && preg_match("/^[a-zA-Z ]*$/", $firstname)) {
            $data['firstname'] = $firstname;
        }

        if (!empty($lastname) && preg_match("/^[a-zA-Z ]*$/", $lastname)) {
            $data['lastname'] = $lastname;
        }

        if (!empty($email) && count($user->get()->simple(["email" => $email])->query()) === 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $email;
        }

        if (!empty($password) && $password === $confpassword) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (count($data)) {
            $data['gender'] = $gender;
            $status = $user->update(
                $data,
                ['id' => $id]
            );
            echo json_encode(array(
                'status' => $status ? 'Success' : 'Fail',
            ));
        } else {
            echo json_encode(array(
                'status'  => 'Fail',
                'message' => 'Empty data',
            ));
        }
    }

    public function deleteTaskAction($id)
    {
        $user = new Task();
        $status = $user->delete([
            'id' => $id
        ]);
        echo json_encode(array(
            'status' => $status ? 'Success' : 'Fail',
        ));
    }
}

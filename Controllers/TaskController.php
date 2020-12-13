<?php

class TaskController extends Controller
{
    public function getAllTasksAction()
    {
        $task  = new Task();
        $tasks = $task->get(false, ["id", "title", "description", "created_by", "priority", "status"])->query();

        $this->render("tasks/index", [
            'tasks' => $tasks,
            'isAdmin' => $this->isAdmin,
        ]);
    }

    public function showCreateTaskAction()
    {
        $this->checkSessionTime();
        $this->checkSessionTime('task');
        $errorMessages = Session::get("error_messages");
        $old = Session::get("old_values") ? Session::get("old_values") : [];
        $this->render("tasks/form", [
            'create' => true,
            'old'    => $old,
            'error'  => $errorMessages ? $errorMessages : []
        ]);
    }

    public function createTaskAction()
    {
        $task = new Task();
        if ($id = Session::get('userId')) {
            $user        = new User();
            $currentUser = $user->get(false, ["firstname", "lastname"])->simple(["id" => $id])->query();
            if(!count($currentUser)) {
                $this->redirect("logout");
            }
            $created_by  = $currentUser[0]["firstname"] . ' ' . $currentUser[0]["lastname"];
        } else {
            $created_by = isset($_POST['created_by']) ? App::test_input($_POST['created_by']) : '';
            if (empty($created_by)) {
                $errorArr["created_by"] = "(Please write your name!)";
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $created_by)) {
                $errorArr["created_by"] = "(Please write correct name!)";
            }
        }
        $errorArr    = [];
        $title       = isset($_POST['title']) ? App::test_input($_POST['title']) : '';
        $description = isset($_POST['description']) ? App::test_input($_POST['description']) : '';
        $priority    = isset($_POST['priority']) ? App::test_input($_POST['priority']) : 'low';

        if (empty($title)) {
            $errorArr["title"] = "(Please write title!)";
        } elseif (!ctype_alnum($title)) {
            $errorArr["title"] = "(Please write correct title!)";
        }

        if (empty($description)) {
            $errorArr["description"] = "(Please write description!)";
        }

        Session::set("error_task", $errorArr);
        Session::set("task_time", time());
        Session::set("old_values", [
            "title"       => $title,
            "description" => $description,
            "priority"    => $priority,
            "name"        => $created_by
        ]);


        if (!count($errorArr)) {
            $data = [
                "title"       => $title,
                "description" => $description,
                "priority"    => $priority,
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

    public function showUpdateTaskAction($id)
    {
        $this->checkSessionTime('task');
        $this->checkSessionTime('task', 'old');
        $old           = Session::get("old_task") ? Session::get("old_task") : [];
        $task          = new Task();
        $errorMessages = Session::get("error_task");
        $currentTask   = $task->get(false, ["id", "title", "description", "created_by", "priority", "status"])->simple(["id" => $id])->query();
        if(count($currentTask)) {
            $this->render("tasks/form", [
                'create' => false,
                'task'   => $currentTask[0],
                'old'    => $old,
                'error'  => $errorMessages ? $errorMessages : []
            ]);
        } else {
            $this->redirect("tasks");
        }
    }

    public function updateTaskAction($id)
    {
        $task        = new Task();
        $errorArr    = [];
        $title       = isset($_POST['title']) ? App::test_input($_POST['title']) : '';
        $description = isset($_POST['description']) ? App::test_input($_POST['description']) : '';
        $priority    = isset($_POST['priority']) ? App::test_input($_POST['priority']) : 'low';
        $status      = isset($_POST['status']) ? App::test_input($_POST['status']) : 'low';

        if (empty($title)) {
            $errorArr["title"] = "(Please write title!)";
        }

        if (empty($description)) {
            $errorArr["description"] = "(Please write description!)";
        }
        
        Session::set("error_task", $errorArr);
        Session::set("task_time", time());
        Session::set("old_values", [
            "title"       => $title,
            "description" => $description,
            "priority"    => $priority,
            "status"      => $status
        ]);


        if (!count($errorArr)) {
            $data = [
                "title"       => $title,
                "description" => $description,
                "priority"    => $priority,
                "status"      => $status,
            ];
            if ($task->update($data, ['id' => $id])) {
                $this->redirect("tasks");
            } else {
                die(mysqli_errno(Task::getConn()));
            }
        } else {
            $this->redirect("tasks/" . $id . "/update");
        }
    }

    public function deleteTaskAction($id)
    {
        $this->checkAdmin();
        $task = new Task();
        $task->delete([
            'id' => $id
        ]);
        $this->redirect("tasks");
    }
}

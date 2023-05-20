<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->checkCSRF();

    if (!$session->isAdmin()) $session->redirect();

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    switch ($_POST['entity']) {
        case 'department':
            require_once(__DIR__ . '/../database/class_department.php');
            $department = Department::getDepartment($db, (int) $_POST['id']);
            if ($department->delete($db))
                $session->addMessage(true, "Department '{$department->name}' successfully deleted");
            else
                $session->addMessage(false, "Department '{$department->name}' could not be deleted");
            break;
        case 'status':
            require_once(__DIR__ . '/../database/class_status.php');
            $status = Status::getStatus($db, (int) $_POST['id']);
            if ($status->delete($db))
                $session->addMessage(true, "Status '{$status->name}' successfully deleted");
            else
                $session->addMessage(false, "Status '{$status->name}' could not be deleted");
            break;
        case 'priority':
            require_once(__DIR__ . '/../database/class_priority.php');
            $priority = Priority::getPriority($db, (int) $_POST['id']);
            if ($priority->delete($db))
                $session->addMessage(true, "Priority '{$priority->name}' successfully deleted");
            else
                $session->addMessage(false, "Priority '{$priority->name}' could not be deleted");
            break;
        case 'tag':
            require_once(__DIR__ . '/../database/class_tag.php');
            $tag = Tag::getTag($db,  (int) $_POST['id']);
            if ($tag->delete($db))
                $session->addMessage(true, "Tag '{$tag->name}' successfully deleted");
            else
                $session->addMessage(false, "Tag '{$tag->name}' could not be deleted");
            break;
        default:
            $session->addMessage(false, 'Entity could not be deleted');
            break;
    }

    header('Location: ../pages/management.php');
?>

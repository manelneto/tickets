<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isAdmin()) {
        header('Location: ../pages/index.php');
        die();
    }

    $name = trim($_POST['name']);

    if ($name === '') {
        $session->addMessage(false, 'Entity name cannot be empty');
        header('Location: ../pages/management.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_department.php');
    require_once(__DIR__ . '/../database/class_status.php');
    require_once(__DIR__ . '/../database/class_priority.php');
    require_once(__DIR__ . '/../database/class_tag.php');

    switch ($_POST['entity']) {
        case 'department':
            if (Department::addDepartment($db, $name))
                $session->addMessage(true, "Department '$name' successfully added");
            else
                $session->addMessage(false, "Department '$name' already exists");
            break;
        case 'status':
            if (Status::addStatus($db, $name))
                $session->addMessage(true, "Status '$name' successfully added");
            else
                $session->addMessage(false, "Status '$name' already exists");
            break;
        case 'priority':
            if (Priority::addPriority($db, $name))
                $session->addMessage(true, "Priority '$name' successfully added");
            else
                $session->addMessage(false, "Priority '$name' already exists");
            break;
        case 'tag':
            if (Tag::addTag($db, $name))
                $session->addMessage(true, "Tag '$name' successfully added");
            else
                $session->addMessage(false, "Tag '$name' already exists");
            break;
        default:
            $session->addMessage(false, 'Action unsuccessful...');
            break;
    }

    header('Location: ../pages/management.php');
?>

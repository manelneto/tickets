<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isAdmin()) {
        header('Location: ../pages/index.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_department.php');
    require_once(__DIR__ . '/../database/class_status.php');
    require_once(__DIR__ . '/../database/class_priority.php');
    require_once(__DIR__ . '/../database/class_tag.php');

    $name = trim($_POST['name']);

    if ($_POST['entity'] === 'department' && Department::addDepartment($db, $name))
        $session->addMessage(true, "Department '$name' successfully added");
    else if ($_POST['entity'] === 'status' && Status::addStatus($db, $name))
        $session->addMessage(true, "Status '$name' successfully added");
    else if ($_POST['entity'] === 'priority' && Priority::addPriority($db, $name))
        $session->addMessage(true, "Priority '$name' successfully added");
    else if ($_POST['entity'] === 'tag' && Tag::addTag($db, $name))
        $session->addMessage(true, "Tag '$name' successfully added");
    else
        $session->addMessage(false, "Action unsuccessful");

    header('Location: ../pages/management.php');
?>

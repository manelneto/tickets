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

    if ($_POST['entity'] === 'department' && Department::addDepartment($db, $_POST['name']))
        header('Location: ../pages/dashboard.php');
    else if ($_POST['entity'] === 'status' && Status::addStatus($db, $_POST['name']))
        header('Location: ../pages/dashboard.php');
    else if ($_POST['entity'] === 'priority' && Priority::addPriority($db, $_POST['name']))
        header('Location: ../pages/dashboard.php');
    else if ($_POST['entity'] === 'tag' && Tag::addTag($db, $_POST['name']))
        header('Location: ../pages/dashboard.php');
    else
        header('Location: ../pages/management.php');
?>

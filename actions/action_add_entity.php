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

    if ($_POST['entity'] === 'department') {
        require_once(__DIR__ . '/../database/class_department.php');
        Department::addDepartment($db, $_POST['name']);
        header('Location: ../pages/dashboard.php');
    } else if ($_POST['entity'] === 'status') {
        require_once(__DIR__ . '/../database/class_status.php');
        Status::addStatus($db, $_POST['name']);
        header('Location: ../pages/dashboard.php');
    } else if ($_POST['entity'] === 'priority') {
        require_once(__DIR__ . '/../database/class_priority.php');
        Priority::addPriority($db, $_POST['name']);
        header('Location: ../pages/dashboard.php');
    } else if ($_POST['entity'] === 'tag') {
        require_once(__DIR__ . '/../database/class_tag.php');
        Tag::addTag($db, $_POST['name']);
        header('Location: ../pages/dashboard.php');
    } else
        header('Location: ../pages/management.php');
?>

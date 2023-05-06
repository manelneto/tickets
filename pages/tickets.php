<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../pages/index.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_ticket.php');

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    $id = $session->getId();
    $after = isset($_POST['after']) ? $_POST['after'] : '';
    $before = isset($_POST['before']) ? $_POST['before'] : '';
    $priority = isset($_POST['priority']) ? (int) $_POST['priorirty'] : 0;
    $status = isset($_POST['status']) ? (int) $_POST['status'] : 0;
    $department = isset($_POST['department']) ? (int) $_POST['department'] : 0;
    $limit = 2;
    $offset = $limit * ($page - 1);

    $tickets = Ticket::getTickets($db, $session->getId(), $after, $before, $priority, $status, $department, $limit, $offset);
    $statuses = Status::getStatuses($db);
    $priorities = Priority::getPriorities($db);
    $departments = Department::getDepartments($db);

    require_once(__DIR__ . '/../templates/template_common.php');
    require_once(__DIR__ . '/../templates/template_tickets.php');

    $remaining = Ticket::getTicketsCount($db, $session->getId()) - $limit * $page;

    drawHeader($session);
    drawTickets($session, $tickets, $page, $remaining, $statuses, $priorities, $departments);
?>

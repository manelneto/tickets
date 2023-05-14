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

    $id = $session->getId();
    $after = $_POST['after'] ?? '';
    $before = $_POST['before'] ?? '';
    $department = (int) $_POST['department'] ?? 0;
    $priority = (int) $_POST['priority'] ?? 0;
    $status = (int) $_POST['status'] ?? 0;

    $priorities = Priority::getPriorities($db);
    $statuses = Status::getStatuses($db);

    if ($session->isAdmin()) {
        $tickets = Ticket::getTickets($db, $after, $before, $department, $priority, $status);
        $departments = Department::getDepartments($db);
    }
    else if ($session->isAgent()) {
        $tickets = Ticket::getTicketsAgent($db, $session->getId(), $after, $before, $department, $priority, $status);
        $departments = array_unique(array_merge(Department::getAgentDepartments($db, $session->getId()), Department::getClientDepartments($db, $session->getId())));
    }
    else {
        $tickets = Ticket::getTicketsClient($db, $session->getId(), $after, $before, $department, $priority, $status);
        $departments = Department::getClientDepartments($db, $session->getId());
    }

    require_once(__DIR__ . '/../templates/template_common.php');
    require_once(__DIR__ . '/../templates/template_tickets.php');

    $limit = 11;
    $offset = isset($_POST['offset']) ? (int) max($_POST['offset'], 0) : 0;

    drawHeader($session, 'Tickets');
    drawTickets($tickets, $limit, $offset, $after, $before, Status::getStatus($db, $status), Priority::getPriority($db, $priority), Department::getDepartment($db, $department), $statuses, $priorities, $departments);
    drawFooter();
?>

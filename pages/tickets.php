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
    $tickets = Ticket::getTickets($db, $session->getId());
    $statuses = Status::getStatuses($db);
    $priorities = Priority::getPriorities($db);
    $departments = Department::getDepartments($db);

    require_once(__DIR__ . '/../templates/template_common.php');
    require_once(__DIR__ . '/../templates/template_tickets.php');

    drawHeader($session);
    drawTickets($session, $tickets, $statuses, $priorities, $departments);
?>

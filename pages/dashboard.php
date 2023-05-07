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
    $opened = Ticket::getTicketsCountByStatus($db, $session->getId(), 1);
    $assigned = Ticket::getTicketsCountByStatus($db, $session->getId(), 2);
    $closed = Ticket::getTicketsCountByStatus($db, $session->getId(), 3);
    $overdue = Ticket::getTicketsCountByStatus($db, $session->getId(), 4);

    require_once(__DIR__ . '/../templates/template_common.php');
    require_once(__DIR__ . '/../templates/template_dashboard.php');

    drawHeader($session, 'Dashboard');
    drawDashboard($opened, $assigned, $closed, $overdue);
    drawFooter();
?>

<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isAgent()) {
        header('Location: ../pages/index.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    $id = (int) $_POST['id'];

    require_once(__DIR__ . '/../database/class_ticket.php');
    $ticket = Ticket::getTicket($db, (int) $id);

    if ($ticket && $ticket->editProperties($db, (int) $_POST['status'], (int) $_POST['priority'], (int) $_POST['department'], (int) $_POST['agent']))
        header("Location: ../pages/ticket.php?id=$id");
    else
        header("Location: ../pages/ticket.php?id=$id");

    /* if-else para depois adicionarmos mensagens de erro/sucesso */
?>

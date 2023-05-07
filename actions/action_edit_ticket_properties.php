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

    require_once(__DIR__ . '/../database/class_ticket.php');
    $ticket = Ticket::getTicket($db, (int) $_GET['id']);

    if ($ticket && $ticket->editProperties($db, trim($_POST['title']), trim($_POST['content'])))
        header("Location: ../pages/ticket?id=$_GET['id'].php");
    else
        header("Location: ../pages/ticket?id=$_GET['id'].php");

    /* if-else para depois adicionarmos mensagens de erro/sucesso */
?>

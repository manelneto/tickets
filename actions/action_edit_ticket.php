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

    $id = (int) $_POST['id'];

    require_once(__DIR__ . '/../database/class_ticket.php');
    $ticket = Ticket::getTicket($db, (int) $id);

    if ($session->getId() !== $ticket->getClient()->getId()) {
        header('Location: ../pages/index.php');
        die();
    }

    if ($ticket && $ticket->edit($db, trim($_POST['title']), trim($_POST['content'])))
        header("Location: ../pages/ticket.php?id=$id");
    else
        header("Location: ../pages/ticket.php?id=$id");

    /* if-else para depois adicionarmos mensagens de erro/sucesso */
?>

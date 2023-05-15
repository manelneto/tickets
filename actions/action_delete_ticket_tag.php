<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->checkCSRF();

    if (!$session->isAgent()) {
        header('Location: ../pages/index.php');
        die();
    }

    $id = (int) $_POST['id'];
    $tag = (int) $_POST['tag'];

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_ticket.php');
    $ticket = Ticket::getTicket($db, $id);

    if ($ticket && $tag && $ticket->deleteTag($db, $tag))
        $session->addMessage(true, "Tag successfully removed");
    else
        $session->addMessage(false, 'Tag could not be removed');

    header("Location: ../pages/ticket.php?id=$id");
?>

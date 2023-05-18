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

    $id = $_POST['id'];

    require_once(__DIR__ . '/../database/class_ticket.php');
    $ticket = Ticket::getTicket($db, (int) $id);

    $date = date('Y-m-d');
    
    $author = $session->getId();

    if ((int)$idFAQ === 0) {
        $content = $_POST['content'];
    } else {
        $content = FAQ::getFAQ($db, (int) $id)->getAnswer();
    }

    if ($ticket && $ticket->addMessage($db, $date, $content, $author))
        header("Location: ../pages/ticket.php?id=$id");
    else
        header("Location: ../pages/ticket.php?id=$id");
?>
<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->checkCSRF();

    if (!$session->isLoggedIn()) {
        $this->addMessage(false, 'You cannot perform that action');
        header('Location: ../pages/index.php');
        die();
    }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if ($title === '' || $description === '') {
        $session->addMessage(false, 'Ticket title/description cannot be empty');
        header('Location: ../pages/new_ticket.php');
        die();
    }

    $dateOpened = date('Y-m-d');
    $department = (int) $_POST['department'];

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();
    
    require_once(__DIR__ . '/../database/class_ticket.php');

    $names = (strpos($_POST['tags'], ',') !== false) ? explode(',', $_POST['tags']) : array(trim($_POST['tags']));

    $tags = array();

    foreach ($names as $name) {
        $tag = Tag::getTagId($db, $name);
        if ($tag) $tags[] = $tag;
    }

    if (Ticket::addTicket($db, $session->getId(), $title, $description, $dateOpened, $department, $tags)) {
        $session->addMessage(true, 'Ticket successfully added');
        header('Location: ../pages/tickets.php');
    }
    else {
        $session->addMessage(false, 'Ticket could not be added');
        header('Location: ../pages/new_ticket.php');
    }
?>

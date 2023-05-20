<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->checkCSRF();

    if (!$session->isLoggedIn()) $session->redirect();

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

    $names = (strpos($_POST['tags'], ',') !== false) ? explode(',', trim($_POST['tags'])) : array(trim($_POST['tags']));
    $tags = array();
    foreach ($names as $name) {
        $tag = Tag::getTagId($db, $name);
        if ($tag) $tags[] = $tag;
    }

    $filename = '';

    if (isset($FILES['file-upload']['name'])) {
        if (!is_dir('../ticket_files')) mkdir('../ticket_files');
    
        $saveDir = "../ticket_files/";
        $originalName = basename($_FILES["file-upload"]["name"]);
        $fileType = pathinfo($originalName, PATHINFO_EXTENSION);

        if ($fileType != "txt" && $fileType != "pdf" && $fileType != "doc") {
            $session->addMessage(false, 'Only TXT, PDF and DOC files are allowed');
            header('Location: ../pages/new_ticket.php');
            die();
        }

        $filename = $saveDir . $session->getId() . "." . $fileType ;

        if (!move_uploaded_file($_FILES["file-upload"]["tmp_name"], $filename)) {
            $session->addMessage(false, 'Error uploading file. Ticket could not be added');
            header('Location: ../pages/new_ticket.php');
            die();
        }
    }

    if (Ticket::addTicket($db, $session->getId(), $title, $description, $dateOpened, $department, $tags, $filename)) {
        $session->addMessage(true, 'Ticket successfully added');
        header('Location: ../pages/tickets.php');
    } else {
        $session->addMessage(false, 'Ticket could not be added');
        header('Location: ../pages/new_ticket.php');
    }
?>

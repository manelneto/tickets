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

    if (isset($FILES['file-upload']['name'])) {
        if (!is_dir('../ticket_files')) mkdir('../ticket_files');
    
        $save_dir = "../ticket_files/";
        $original_name = basename($_FILES["file-upload"]["name"]);
        $file_type = pathinfo($original_name, PATHINFO_EXTENSION);
    
        $save_file = $save_dir . $session->getId() . "." . $file_type ;
    
        if($file_type != "txt" && $file_type != "pdf" && $file_type != "doc") {
            $session->addMessage(false, 'Only TXT, PDF, DOC files are allowed');
            die();
        }
    
        if (move_uploaded_file($_FILES["file-upload"]["tmp_name"], $save_file) && Ticket::addTicket($db, $session->getId(), $title, $description, $dateOpened, $department, $tags, $save_file)) {
            $session->addMessage(true, 'Ticket successfully added 1');
            header('Location: ../pages/tickets.php');
        }
        else {
            $session->addMessage(false, 'Ticket could not be added');
            header('Location: ../pages/new_ticket.php');
        }
    } else {
        if (Ticket::addTicket($db, $session->getId(), $title, $description, $dateOpened, $department, $tags)) {
            $session->addMessage(true, 'Ticket successfully added 2');
            header('Location: ../pages/tickets.php');
        } else {
            $session->addMessage(false, 'Ticket could not be added');
            header('Location: ../pages/new_ticket.php');
        }
    }
?>

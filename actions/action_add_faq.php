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

    require_once(__DIR__ . '/../database/class_faq.php');

    if (FAQ::addFAQ($db, $_POST['question'], $_POST['answer']))
        $session->addMessage(true, 'FAQ successfully added');
    else
        $session->addMessage(false, 'Action unsuccessful');

    header('Location: ../pages/faqs.php');
?>

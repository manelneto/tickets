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

    $session->logout();

    header('Location: /../pages/login.php');
?>

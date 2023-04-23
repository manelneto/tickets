<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/template_common.php');
    require_once(__DIR__ . '/../templates/template_tickets.php');

    drawHeader($session);
    drawTickets();
    drawFooter();
?>

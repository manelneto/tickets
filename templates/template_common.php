<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHeader(Session $session, string $title) : void { ?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Tickets Management</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/common.css">
        <link rel="stylesheet" href="../css/dashboard.css">
        <link rel="stylesheet" href="../css/faqs-management.css">
        <link rel="stylesheet" href="../css/login.css">
        <link rel="stylesheet" href="../css/new_ticket.css">
        <link rel="stylesheet" href="../css/profile.css">
        <link rel="stylesheet" href="../css/register.css">
        <link rel="stylesheet" href="../css/ticket.css">
        <link rel="stylesheet" href="../css/tickets.css">   
    </head>
    <body>
        <?php if ($session->isLoggedIn()) { ?>
        <header id="main-header">
            <h1><?=$title?></h1>
            <form action="../actions/action_logout.php" method="post" class="logout">
                <a href="../pages/profile.php"><?php
                    echo $session->getName();
                    if ($session->isAdmin()) echo ' (Admin)';
                    else if ($session->isAgent()) echo ' (Agent)';
                    else echo ' (Client)';
                ?></a>
                <button type="submit">Logout</button>
            </form>
        </header>
        <nav id="menu">
            <ul>
                <li><a href="../pages/dashboard.php">Dashboard</a></li>
                <li><a href="../pages/new_ticket.php">New Ticket</a></li>
                <li><a href="../pages/tickets.php">Tickets</a></li>
                <li><a href="../pages/faqs.php">FAQ</a></li>
                <?php if ($session->isAdmin()) { ?>
                <li><a href="../pages/management.php">Management</a></li>
                <?php } ?>
            </ul>
        </nav>
        <?php } else { ?>
        <header id="authentication-header">
            <h1><?=$title?></h1>
        </header>
        <?php } ?>
<?php } ?>

<?php function drawFooter() : void { ?>
    </body>
</html>
<?php } ?>

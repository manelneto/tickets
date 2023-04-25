<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHeader(Session $session) { ?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Tickets Management</title>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
            <h1><a href="../pages/index.php">Tickets Management</a></h1>
            <?php if ($session->isLoggedIn()) { ?>
            <form action="../actions/action_logout.php" method="post" class="logout">
                <a href="../pages/profile.php">
                <?php
                    echo $session->getName();
                    if ($session->isAdmin()) echo ' (Admin)';
                    else if ($session->isAgent()) echo ' (Agent)';
                    else echo ' (Client)';
                ?>
                </a>
                <button type="submit">Logout</button>
            </form>
            <?php } ?>
        </header>
        <?php if ($session->isLoggedIn()) { ?>
        <nav id="menu">
            <ul>
                <li><a href="../pages/dashboard.php">Dashboard</a></li>
                <li><a href="../pages/tickets.php">Tickets</a></li>
                <li><a href="../pages/faq.php">FAQ</a></li>
            </ul>
        </nav>
        <?php } ?>
        <main>
<?php } ?>

<?php function drawFooter() { ?>
        </main>
        <footer>
            LTW &copy; 2023
        </footer>
    </body>
</html>
<?php } ?>

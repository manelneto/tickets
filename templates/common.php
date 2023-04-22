<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHeader(Session $session = null) { ?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Tickets Management</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <header>
            <?php
                if (isset($session)) drawMainHeader();
                else drawAuxHeader(); 
            ?>
        </header>
        <main>
<?php } ?>

<?php function drawMainHeader() { /* empty for now */ } ?> 

<?php function drawAuxHeader() { ?>
    <h1>Tickets Management</h1>
<?php } ?>

<?php function drawFooter() { ?>
        </main>
        <footer>
            LTW &copy; 2023
        </footer>
    </body>
</html>
<?php } ?>

<?php function drawLogin() { ?>
    <section id="login">
        <h1>Login</h1>
        <form>
            <label>
                Email Address <input type="email" name="email">
            </label>
            <label>
                Password <input type="password" name="password">
            </label>
            <button>Log In</button>
        </form>
        <p>Don't have an account? Sign up</p>
    </section>
<?php } ?>
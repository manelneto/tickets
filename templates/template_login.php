<?php
    declare(strict_types = 1);
?>

<?php function drawLogin() { ?>
    <h1><a href="../pages/index.php">Tickets Management</a></h1>
    <section id="login">
        <h2>Login</h2>
        <form action="../actions/action_login.php" method="post" class="login">
            <label>
                Username<input type="text" name="username" placeholder="username">
            </label>
            <label>
                Password<input type="password" name="password" placeholder="password">
            </label>
            <button type="submit">Log In</button>
        </form>
        <p>Don't have an account? <a href="../pages/register.php">Sign up</a></p>
    </section>
<?php } ?>

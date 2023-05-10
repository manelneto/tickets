<?php
    declare(strict_types = 1);
?>

<?php function drawLogin() { ?>
    <main>
        <section id="login">
            <h2>Login</h2>
            <form action="../actions/action_login.php" method="post" class="login">
                <label for="username">
                    Username
                </label>
                <input id="username" type="text" name="username" placeholder="username">
                <label for="password">
                    Password
                </label>
                <input id="password" type="password" name="password" placeholder="password">
                <button type="submit">Log In</button>
            </form>
            <p>Don't have an account? <a href="../pages/register.php">Sign up</a></p>
        </section>
    </main>
<?php } ?>

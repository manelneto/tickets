<?php
declare(strict_types = 1);
?>

<?php function drawLogin() : void { ?>
    <main id="authentication">
        <section id="login">
            <h2>Login</h2>
            <form action="../actions/action_login.php" method="post" class="login">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="username" required>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="password" required>
                <button type="submit">Log In</button>
            </form>
            <p>Don't have an account? <a href="../pages/register.php">Sign up</a></p>
        </section>
    </main>
<?php } ?>

<?php function drawRegister() : void { ?>
    <main id="authentication">
        <section id="register">
            <h2>Register</h2>
            <form action="../actions/action_register.php" method="post" class="register">
                <label for="first">First Name</label>
                <input id="first" type="text" name="first" placeholder="First Name" required>
                <label for="last">Last Name</label>
                <input id="last" type="text" name="last" placeholder="Last Name" required>
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Username" required>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Email" required>
                <label for="password">Password</label>
                <input id="pass" type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="../pages/login.php">Log in</a></p>
        </section>
    </main>
<?php } ?>

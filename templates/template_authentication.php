<?php
    declare(strict_types = 1);
?>

<?php function drawLogin() : void { ?>
    <main>
        <section id="login" class="authentication">
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
    <main>
        <section id="register" class="authentication">
            <h2>Register</h2>
            <form action="../actions/action_register.php" method="post" class="register">
                <label for="firstname">First Name</label>
                <input id="firstname" type="text" name="firstname" placeholder="First Name" required>
                <label for="lastname">Last Name</label>
                <input id="lastname" type="text" name="lastname" placeholder="Last Name" required>
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Username" required>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Email" required>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="../pages/login.php">Log in</a></p>
        </section>
    </main>
<?php } ?>

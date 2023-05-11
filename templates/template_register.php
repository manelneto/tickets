<?php
    declare(strict_types = 1);
?>

<?php function drawRegister() : void { ?>
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
<?php } ?>

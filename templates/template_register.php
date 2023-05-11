<?php
    declare(strict_types = 1);
?>

<?php function drawRegister() { ?>
    <section id="register">
        <h2>Register</h2>
        <form action="../actions/action_register.php" method="post" class="register">
            <label for="firstname">
                First Name
            </label>
            <input id="firstname" type="text" name="firstName" placeholder="first">
            <label for="lastname">
                Last Name
            </label>
            <input id="lastname" type="text" name="lastName" placeholder="last">
            <label for="username">
                Username
            </label>
            <input id="username" type="text" name="username" placeholder="username"> 
            <label for="email">
                Email
            </label>
            <input id="email" type="email" name="email" placeholder="email">
            <label for="pass">
                Password
            </label>
            <input id="pass" type="password" name="password" placeholder="password">
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="../pages/login.php">Log in</a></p>
    </section>
<?php } ?>

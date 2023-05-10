<?php
    declare(strict_types = 1);
?>

<?php function drawRegister() { ?>
    <main>
        <section id="register">
            <h2>Register</h2>
            <form action="../actions/action_register.php" method="post" class="register">
                <label>
                    First Name<input type="text" name="firstName" placeholder="first">
                </label>
                <label>
                    Last Name<input type="text" name="lastName" placeholder="last">
                </label>
                <label>
                    Username<input type="text" name="username" placeholder="username">
                </label>
                <label>
                    Email<input type="email" name="email" placeholder="email">
                </label>
                <label>
                    Password<input type="password" name="password" placeholder="password">
                </label>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="../pages/login.php">Log in</a></p>
        </section>
    </main>
<?php } ?>

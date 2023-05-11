<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/class_user.php');
?>

<?php function drawProfile(User $user) : void { ?>
    <main>
        <section id="profile">
            <h2>My Profile</h2>
            <a id="edit-profile" href="../pages/profile.php">Edit Profile</a>
            <a id="change-password" href="../pages/password.php">Change Password</a>
            <form action="../actions/action_edit_profile.php" method="post" class="profile">
                <label for="first">First Name</label>
                <input id="first" type="text" name="first" value="<?=$user->getFirstName()?>" required>
                <label for="last">Last Name</label>
                <input id="last" type="text" name="last" value="<?=$user->getLastName()?>" required>
                <label for="username">Username</label>
                <input id="username" type="text" name="username" value="<?=$user->getUsername()?>" required>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="<?=$user->getEmail()?>" required>
                <button type="submit">Save</button>
            </form>
        </section>
    </main>
<?php } ?>

<?php function drawPassword() : void { ?>
    <main>
        <section id="password">
            <h2>Change Password</h2>
            <a id="edit-profile" href="../pages/profile.php">Edit Profile</a>
            <a id="change-password" href="../pages/password.php">Change Password</a>
            <form action="../actions/action_edit_password.php" method="post" class="profile">
                <label for="current">Current Password</label>
                <input id="current" type="password" name="current" required>
                <label for="new">New Password</label>
                <input id="new" type="password" name="new" required>
                <label for="confirm">Confirm Password</label>
                <input id="confirm" type="password" name="confirm" required>
                <button type="submit">Save</button>
            </form>
        </section>
    </main>
<?php } ?>

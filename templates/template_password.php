<?php
    declare(strict_types = 1);
?>

<?php function drawPassword(User $user) { ?>
    <section id="password">
        <h2>Change Password</h2>
        <a href="../pages/profile.php">Edit Profile</a>
        <form action="../actions/action_edit_password.php" method="post" class="profile">
            <label>
                Current Password<input type="password" name="current">
            </label>
            <label>
                New Password<input type="password" name="new">
            </label>
            <label>
                Confirm Password<input type="password" name="confirm">
            </label>
            <button type="submit">Save</button>
        </form>
    </section>
<?php } ?>

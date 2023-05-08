<?php
    declare(strict_types = 1);
?>

<?php function drawPassword(User $user) { ?>
    <section id="password">
        <h2>Change Password</h2>
        <a class="profileTitle" href="../pages/profile.php">Edit Profile</a>
        <a class="profilePassword" href="../pages/password.php">Change Password</a>
        <form action="../actions/action_edit_password.php" method="post" class="profile">
            <label for="current">Current Password</label>
            <input type="password" name="current">
            <label for="new">New Password</label>
            <input type="password" name="new">
            <label for="confirm">Confirm Password</label>
            <input type="password" name="confirm">
            <button type="submit">Save</button>
        </form>
    </section>
<?php } ?>

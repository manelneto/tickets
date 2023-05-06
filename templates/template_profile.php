<?php
    declare(strict_types = 1);
?>

<?php function drawProfile(User $user) { ?>
    <section id="profile">
        <h2>My Profile</h2>
        <a href="../pages/profile.php">Edit Profile</a>
        <a href="../pages/password.php">Change Password</a>
        <form action="../actions/action_edit_profile.php" method="post" class="profile">
            <label for="firstname">First Name</label>
            <input type="text" name="firstName" value="<?=$user->getFirstName()?>">
            <label>
                Last Name<input type="text" name="lastName" value="<?=$user->getLastName()?>">
            </label>
            <label>
                Username<input type="text" name="username" value="<?=$user->getUsername()?>">
            </label>
            <label>
                Email<input type="email" name="email" value="<?=$user->getEmail()?>">
            </label>
            <button type="submit">Save</button>
        </form>
    </section>
<?php } ?>

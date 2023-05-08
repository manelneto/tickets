<?php
    declare(strict_types = 1);
?>

<?php function drawProfile(User $user) { ?>
    <section id="profile">
        <h2>My Profile</h2>
        <a class="profileTitle" href="../pages/profile.php">Edit Profile</a>
        <a class="profilePassword" href="../pages/password.php">Change Password</a>
        <form action="../actions/action_edit_profile.php" method="post" class="profile">
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" value="<?=$user->getFirstName()?>">
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" value="<?=$user->getLastName()?>">
            <label for="username">Username</label>
            <input type="text" name="username" value="<?=$user->getUsername()?>">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?=$user->getEmail()?>">
            <button type="submit">Save</button>
        </form>
    </section>
<?php } ?>

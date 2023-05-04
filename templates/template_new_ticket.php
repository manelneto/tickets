<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawNewTicket(Session $session, array $departments, array $tags) { ?>
    <section id="new-ticket">
        <h2>How can we help you?</h2>
        <form action="../actions/action_new_ticket.php" method="post" class="new-ticket">
            <label>
                Title<input id="title" type="text" name="title" placeholder="title">
            </label>
            <label for="department">Department</label>
            <select name="department" id="department">
                <?php foreach ($departments as $department) { ?>
                <option value=<?=strtolower($department->getName())?>><?=$department->getName()?></option>
                <?php } ?>
            </select>
            <label for="content">Content</label>
            <textarea name="content">What is your question?</textarea>
            <button type="submit">Submit</button>
        </form>
    </section>
<?php } ?>

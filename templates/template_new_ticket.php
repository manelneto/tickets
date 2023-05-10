<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawNewTicket(Session $session, array $departments, array $tags) { ?>
    <section id="new-ticket">
        <h2>How can we help you?</h2>
        <form action="../actions/action_new_ticket.php" method="post" class="new-ticket" novalidate>
            <label for="title">Title</label>
            <input id="title" type="text" name="title" placeholder="title">
            <label for="department">Department</label>
            <select name="department" id="department">
                <option value="0"></option>
                <?php foreach ($departments as $department) { ?>
                <option value=<?=$department->getId()?>><?=$department->getName()?></option>
                <?php } ?>
            </select>
            <label for="tags">Tags</label>
            <input type="email" list="tags-list" id="tags" name="tags" multiple autocomplete>
            <datalist id="tags-list">
                <?php foreach ($tags as $tag) { ?>
                <option value="<?=$tag->getName()?>"><?=$tag->getName()?></option>
                <?php } ?>
            </datalist>
            <label for="content">Description</label>
            <textarea name="content" id="content">Describe your issue.</textarea>
            <button type="submit">Submit</button>
        </form>
    </section>
<?php } ?>

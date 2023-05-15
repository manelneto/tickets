<?php
    declare(strict_types = 1);
?>

<?php function drawNewTicket(array $departments, array $tags) : void { ?>
    <main>
        <section id="new-ticket">
            <h2>How can we help you?</h2>
            <form action="../actions/action_add_ticket.php" method="post" class="new-ticket" novalidate>
                <label for="title">Title</label>
                <input id="title" type="text" name="title" placeholder="title" required>
                <label for="department">Department</label>
                <select name="department" id="new-ticket-department">
                    <option value="0"></option>
                    <?php foreach ($departments as $department) { ?>
                    <option value=<?=$department->getId()?>><?=$department->getName()?></option>
                    <?php } ?>
                </select>
                <label for="tags">Tags</label>
                <input id="tags" type="email" name="tags" placeholder="#tags" list="tags-list" multiple autocomplete formnovalidate>
                <datalist id="tags-list">
                    <?php foreach ($tags as $tag) { ?>
                    <option value="<?=$tag->getName()?>"><?=$tag->getName()?></option>
                    <?php } ?>
                </datalist>
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Describe your issue" required></textarea>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
<?php } ?>

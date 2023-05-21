<?php
    declare(strict_types = 1);
?>

<?php function drawNewTicket(array $departments) : void { ?>
    <main>
        <section id="new-ticket">
            <h2>How can we help you?</h2>
            <form action="../actions/action_add_ticket.php" method="post" enctype="multipart/form-data" class="new-ticket" novalidate>
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <label for="title">Title</label>
                <input id="title" type="text" name="title" placeholder="title" required>
                <label for="new-ticket-department">Department</label>
                <select id="new-ticket-department" name="department">
                    <option value="0"></option>
                    <?php foreach ($departments as $department) { ?>
                    <option value=<?=$department->id?>><?=htmlentities($department->name)?></option>
                    <?php } ?>
                </select>
                <label for="tags">Tags</label>
                <input id="tags" type="text" name="tags">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Describe your issue" required></textarea>
                <input id="file-upload" type="file" name="file-upload">
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
<?php } ?>

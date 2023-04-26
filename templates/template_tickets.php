<?php
    declare(strict_types = 1);
?>

<?php function drawTickets(array $tickets, array $statuses, array $priorities, array $departments) { ?>
    <section id="tickets">
        <h2>My Tickets</h2>
        <?php foreach ($tickets as $ticket) { ?>
        <article class="ticket">
            <header class="author">
                <img src="perfilIcon.png" alt="Perfil Icon">
                <h3><?=$ticket->getTitle()?></h3>
                <h4><?=$ticket->getClient()->getName()?></h4>
            </header>
            <p><?=$ticket->getStatus()->getName()?></p>
            <p><?=$ticket->getPriority()->getName()?></p>
            <p><?=$ticket->getDateOpened()?></p>
        </article>
        <?php } ?>
    </section>
    <form class="filters">
        <h3>Filters</h3>
        <label for="date">Date</label>
        <input type="date" name="date">
        <label for="status">Status</label>
        <select name="status" id="status" >
            <option value="all">All</option>
            <?php foreach ($statuses as $status) { ?>
            <option value=<?=strtolower($status->getName())?>><?=$status->getName()?></option>
            <?php } ?>
        </select>
        <label for="priority">Priority</label>
        <select name="priority" id="priority" >
            <option value="all">All</option>
            <?php foreach ($priorities as $priority) { ?>
            <option value=<?=strtolower($priority->getName())?>><?=$priority->getName()?></option>
            <?php } ?>
        </select>
        <label for="department">Department</label>
        <select name="department" id="department" >
            <option value="all">All</option>
            <?php foreach ($departments as $department) { ?>
            <option value=<?=strtolower($department->getName())?>><?=$department->getName()?></option>
            <?php } ?>
        </select>
        <button type="submit">Filter</button>
    </form>
<?php } ?>

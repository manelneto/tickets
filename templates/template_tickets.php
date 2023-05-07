<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawTickets(Session $session, ?array $tickets, int $page, int $remaining, ?array $statuses, ?array $priorities, ?array $departments) { ?>
    <div class ="ticketsPage">
        <section id="tickets">
            <h2>My Tickets</h2>
            <?php foreach ($tickets as $ticket) { ?>
            <article class="ticket">
                <a href="../pages/ticket.php?id=<?=$ticket->getId()?>">
                    <header class="author">
                        <img src="../assets/perfilIcon.png" alt="Perfil Icon">
                        <h3><?=$ticket->getClient()->getName()?></h3>
                    </header>
                    <h4><?=$ticket->getTitle()?></h4>
                    <p class="status"><?=$ticket->getStatus()->getName()?></p>
                    <p class="date-opened"><?=$ticket->getDateOpened()?></p>
                    <p class="date-due"><?=$ticket->getDateDue()?></p>
                    <p class="date-closed"><?php if ($ticket->getDateClosed() !== null) echo $ticket->getDateClosed(); ?></p>
                    <p class="agent"><?php if ($ticket->getAgent() !== null) echo $ticket->getAgent()->getName(); ?></p>
                    <p class="priority"><?php if ($ticket->getPriority() !== null) echo $ticket->getPriority()->getName(); ?></p>
                    <p class="department"><?php if ($ticket->getDepartment() !== null) echo $ticket->getDepartment()->getName(); ?></p>
                </a>
            </article>
            <?php } ?>
        </section>
        <div class="paging">
            <?php if ($page > 1) { ?>
            <a href="../pages/tickets.php?page=<?=$page - 1?>">Previous</a>
            <?php } ?>
            <?php if ($remaining > 0) { ?>
            <a href="../pages/tickets.php?page=<?=$page + 1?>">Next</a>
            <?php } ?>
        </div>
        <?php if ($session->isAgent() || $session->isAdmin()) { ?>
        <form action="../actions/action_filter.php" method="post" class="filters">
            <h3>Filters</h3>
            <label for="date">Date</label>
            <input type="date" name="date">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="all">All</option>
                <?php foreach ($statuses as $status) { ?>
                <option value="<?=$status->getId()?>"><?=$status->getName()?></option>
                <?php } ?>
            </select>
            <label for="priority">Priority</label>
            <select name="priority" id="priority">
                <option value="all">All</option>
                <?php foreach ($priorities as $priority) { ?>
                <option value="<?=$priority->getId()?>"><?=$priority->getName()?></option>
                <?php } ?>
            </select>
            <label for="department">Department</label>
            <select name="department" id="department">
                <option value="all">All</option>
                <?php foreach ($departments as $department) { ?>
                <option value="<?=$department->getId()?>"><?=$department->getName()?></option>
                <?php } ?>
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>
    <?php } ?>
<?php } ?>

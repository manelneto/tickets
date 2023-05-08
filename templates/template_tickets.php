<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawTickets(Session $session, ?array $tickets, int $limit, int $offset, string $after, string $before, ?Status $status, ?Priority $priority, ?Department $department, array $statuses, array $priorities, array $departments) { ?>
    <div class ="ticketsPage">
        <section id="tickets">
            <h2>My Tickets</h2>
            <?php for ($i = 0; $i < $limit && $i + $offset < count($tickets); $i++) { $ticket = $tickets[$i + $offset]; ?>
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
            <?php if ($offset > 0) { ?>
            <form action="../pages/tickets.php" method="post" class="previous">
                <input type="hidden" name="after" <?php if ($after !== '') echo "value=$after"; ?>>
                <input type="hidden" name="before" <?php if ($before !== '') echo "value=$before"; ?>>
                <input type="hidden" name="status" <?php if ($status) echo 'value=' . $status->getId(); ?>>
                <input type="hidden" name="priority" <?php if ($priority) echo 'value=' . $priority->getId(); ?>>
                <input type="hidden" name="department" <?php if ($department) echo 'value=' . $department->getId(); ?>>
                <input type="hidden" name="offset" value="<?=$offset - $limit?>">
                <button type="submit">Previous</button>
            </form>
            <?php } ?>
            <?php if ($offset + $limit < count($tickets)) { ?>
            <form action="../pages/tickets.php" method="post" class="next">
                <input type="hidden" name="after" <?php if ($after !== '') echo "value=$after"; ?>>
                <input type="hidden" name="before" <?php if ($before !== '') echo "value=$before"; ?>>
                <input type="hidden" name="status" <?php if ($status) echo 'value=' . $status->getId(); ?>>
                <input type="hidden" name="priority" <?php if ($priority) echo 'value=' . $priority->getId(); ?>>
                <input type="hidden" name="department" <?php if ($department) echo 'value=' . $department->getId(); ?>>
                <input type="hidden" name="offset" value="<?=$offset + $limit?>">
                <button type="submit">Next</button>
            </form>
            <?php } ?>
        </div>
    <?php if ($session->isAgent() || $session->isAdmin()) { ?>
        <form action="../pages/tickets.php" method="post" class="filters">
            <h3>Filters</h3>
            <label for="after">After</label>
            <input type="date" name="after" id="after" <?php if ($after !== '') echo "value=$after"; ?>>
            <label for="before">Before</label>
            <input type="date" name="before" id="before" <?php if ($before !== '') echo "value=$before"; ?>>
            <label for="status">Status</label>
            <select name="status" id="status">
                <?php if (!$status) { ?>
                    <option value="0">All</option>
                    <?php foreach ($statuses as $s) { ?>
                        <option value="<?=$s->getId()?>"><?=$s->getName()?></option>
                    <?php } ?>
                <?php } else { ?>
                    <option value="<?=$status->getId()?>"><?=$status->getName()?></option>
                    <option value="0">All</option>
                    <?php foreach ($statuses as $s) { ?>
                        <?php if ($s->getId() !== $status->getId()) { ?>
                            <option value="<?=$s->getId()?>"><?=$s->getName()?></option>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </select>
            <label for="priority">Priority</label>
            <select name="priority" id="priority">
                <?php if (!$priority) { ?>
                    <option value="0">All</option>
                    <?php foreach ($priorities as $p) { ?>
                        <option value="<?=$p->getId()?>"><?=$p->getName()?></option>
                    <?php } ?>
                <?php } else { ?>
                    <option value="<?=$priority->getId()?>"><?=$priority->getName()?></option>
                    <option value="0">All</option>
                    <?php foreach ($priorities as $p) { ?>
                        <?php if ($p->getId() !== $priority->getId()) { ?>
                            <option value="<?=$p->getId()?>"><?=$p->getName()?></option>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </select>
            <label for="department">Department</label>
            <select name="department" id="department">
                <?php if (!$department) { ?>
                    <option value="0">All</option>
                    <?php foreach ($departments as $d) { ?>
                        <option value="<?=$d->getId()?>"><?=$d->getName()?></option>
                    <?php } ?>
                <?php } else { ?>
                    <option value="<?=$department->getId()?>"><?=$department->getName()?></option>
                    <option value="0">All</option>
                    <?php foreach ($departments as $d) { ?>
                        <?php if ($d->getId() !== $department->getId()) { ?>
                            <option value="<?=$d->getId()?>"><?=$d->getName()?></option>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>
    <?php } ?>
<?php } ?>

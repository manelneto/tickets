<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawTicket(Session $session, Ticket $ticket, array $statuses, array $priorities, array $departments, array $agents) { ?>
    <article id="ticket">
        <?php $paragraphs = explode('\n', $ticket->getContent()); ?>
        <?php if ($session->getId() === $ticket->getClient()->getId()) { ?>
            <form action="../actions/action_edit_ticket.php" method="post" class="edit-ticket">
                <header>
                    <h2 class="title">
                        <input type="text" name="title" value="<?=$ticket->getTitle()?>">
                    </h2>
                </header>
                <textarea class="content" name="content"><?php foreach ($paragraphs as $paragraph) echo $paragraph; ?></textarea>
                <input type="hidden" name="id" value="<?=$ticket->getId()?>">
                <button type="submit">Edit</button>
            </form>
        <?php } else { ?>
            <header>    
                <h2><?=$ticket->getTitle()?></h2>
            </header>
            <?php foreach ($paragraphs as $paragraph) { ?>
            <p><?=$paragraph?></p>
            <?php }
        } ?>
    </article>
    <aside class="dates">
        <section id="date-opened">
            <h3>Opened</h3>
            <p><?=$ticket->getDateOpened()?></p>
        </section>
        <section id="date-due">
            <h3>Due</h3>
            <p><?=$ticket->getDateDue()?></p>
        </section>
    </aside>
    <form action="../actions/action_edit_ticket_properties.php" method="post" class="properties">
        <h3>Properties</h3>
        <label for="status">Status</label>
        <select name="status" id="status">
            <?php if ($ticket->getStatus()) { ?>
            <option value="<?=$ticket->getStatus()->getId()?>"><?=$ticket->getStatus()->getName()?></option>
            <?php } if ($session->isAgent()) {
                foreach ($statuses as $status) { 
                    if ($ticket->getStatus() && $status->getId() !== $ticket->getStatus()->getId()) { ?>
                    <option value="<?=$status->getId()?>"><?=$status->getName()?></option>
                <?php }
                } 
            } ?>
        </select>
        <label for="priority">Priority</label>
        <select name="priority" id="priority">
            <?php if ($ticket->getPriority()) { ?>
            <option value="<?=$ticket->getPriority()->getId()?>"><?=$ticket->getPriority()->getName()?></option>
            <?php } if ($session->isAgent()) {
                foreach ($priorities as $priority) {
                    if ($ticket->getPriority() && $priority->getId() !== $ticket->getPriority()->getId()) { ?>
                    <option value="<?=$priority->getId()?>"><?=$priority->getName()?></option>
                <?php }
                } 
            } ?>
        </select>
        <label for="department">Department</label>
        <select name="department" id="department">
            <?php if ($ticket->getDepartment()) { ?>
            <option value="<?=$ticket->getDepartment()->getId()?>"><?=$ticket->getDepartment()->getName()?></option>
            <?php } if ($session->isAgent()) {
                foreach ($departments as $department) {
                    if ($ticket->getDepartment() && $department->getId() !== $ticket->getDepartment()->getId()) { ?>
                    <option value="<?=$department->getId()?>"><?=$department->getName()?></option>
                <?php }
                } 
            } ?>
        </select>
        <label for="agent">Agent</label>
        <select name="agent" id="agent">
            <?php if ($ticket->getAgent()) { ?>
            <option value="<?=$ticket->getAgent()->getId()?>"><?=$ticket->getAgent()->getName()?></option>
            <?php } ?>
            <?php if ($session->isAgent()) {
                foreach ($agents as $agent) { 
                    if ($ticket->getAgent() && $agent->getId() !== $ticket->getAgent()->getId()) {?>
                    <option value="<?=$agent->getId()?>"><?=$agent->getName()?></option>
                <?php }
                }
            } ?>
        </select>
        <?php /* ?>
        <h4>Tags</h4>
        <?php foreach ($ticket->getTags() as $tag) { ?>
            <p><?=$tag->getName()?></p>
        <?php } */ ?>
        <input type="hidden" name="id" value="<?=$ticket->getId()?>">
        <button type="submit" id="apply">Apply</button>
    </form>
    <aside class="changes">
        <h3>Changes</h3><!--
        <?php /* foreach ($ticket->getChanges() as $change) { ?>
            <p><?=$change->getDate()?> - <?=$change->getDescription()?></p>
        <?php } */ ?>-->
    </aside>
<?php } ?>

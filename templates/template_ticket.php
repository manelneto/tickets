<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawTicket(Session $session, Ticket $ticket, array $statuses, array $priorities, array $departments) { ?>
    <article id="ticket">
        <header>    
            <h2><?=$ticket->getTitle()?></h2>
        </header>
        <?php $paragraphs = explode('\n', $ticket->getContent());
        foreach ($paragraphs as $paragraph) {?>
        <p><?=$paragraph?></p>
        <?php } ?>
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
    <form class="properties">
        <h3>Properties</h3>
        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="<?=$ticket->getStatus()->getId()?>"><?=$ticket->getStatus()->getName()?></option>
            <?php if ($session->isAgent()) {
                foreach ($statuses as $status) { 
                    if ($status->getId() > $ticket->getStatus()->getId()) { ?>
                    <option value="<?=$ticket->getStatus()->getId()?>"><?=$status->getName()?></option>
                <?php }
                } 
            } ?>
        </select>
        <label for="priority">Priority</label>
        <select name="priority" id="priority">
            <option value="<?=$ticket->getPriority()->getId()?>"><?=$ticket->getPriority()->getName()?></option>
            <?php if ($session->isAgent()) {
                foreach ($priorities as $priority) { ?>
                <option value="<?=$ticket->getPriority()->getId()?>"><?=$priority->getName()?></option>
            <?php }
            } ?>
        </select>
        <label for="department">Department</label>
        <select name="department" id="department">
            <option value="<?=$ticket->getDepartment()->getId()?>"><?=$ticket->getDepartment()->getName()?></option>
            <?php if ($session->isAgent()) {
                foreach ($departments as $department) { ?>
                <option value="<?=$ticket->getDepartment()->getId()?>"><?=$department->getName()?></option>
            <?php }
            } ?>
        </select>
        <?php if ($ticket->getAgent() !== null) { ?>
        <label for="agent">Agent</label>
        <select name="agent" id="agent">
            <option value="<?=$ticket->getAgent()->getId()?>"><?=$ticket->getAgent()->getName()?></option>
            <?php if ($session->isAgent()) {
                foreach ($agents as $agent) { ?>
                <option value="<?=$ticket->getAgent()->getId()?>"><?=$agent->getName()?></option>
            <?php }
            } ?>
        </select>
        <?php } ?><!--
        <h4>Tags</h4>
        <?php foreach ($ticket->getTags() as $tag) { ?>
            <p><?=$tag->getName()?></p>
        <?php } ?>-->
        <button type="submit" id="apply">Apply</button>
    </form>
    <aside class="changes">
        <h3>Changes</h3><!--
        <?php foreach ($ticket->getChanges() as $change) { ?>
            <p><?=$change->getDate()?> - <?=$change->getDescription()?></p>
        <?php } ?>-->
    </aside>
<?php } ?>

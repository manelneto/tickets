<?php
    declare(strict_types = 1);
?>

<?php function drawTicket(Session $session, Ticket $ticket, array $statuses, array $priorities, array $departments, array $agents, array $tags) : void { ?>
    <main id="ticket-page">
        <article id="ticket">
            <?php $paragraphs = explode('\n', $ticket->getDescription()); ?>
            <?php if ($session->getId() === $ticket->getClient()->getId()) { ?>
                <form action="../actions/action_edit_ticket.php" method="post" class="edit-ticket">
                    <header id="ticket-header">
                        <img src="../assets/ticket.jpg" alt="Ticket Icon">
                        <h2><input type="text" name="title" required value="<?=$ticket->getTitle()?>"></h2>
                    </header>
                    <div id="author-edit">
                        <div id="author-information">
                            <img src="../assets/profile.png" alt="Profile Icon">
                            <h3><?=$ticket->getClient()->getName()?></h3>
                        </div>
                        <button type="submit">Edit</button>
                    </div>
                    <textarea id="description" name="description"><?php foreach ($paragraphs as $paragraph) echo $paragraph; ?></textarea>
                    <input type="hidden" name="id" value="<?=$ticket->getId()?>">
                </form>
            <?php } else { ?>
                <header id="ticket-header">
                    <img src="../assets/ticket.jpg" alt="Ticket Icon">
                    <h2><?=$ticket->getTitle()?></h2>
                </header>
                <div id="author-edit"><!-- TBC -->
                    <div id="author-information">
                        <img src="../assets/profile.png" alt="Profile Icon">
                        <h3><?=$ticket->getClient()->getName()?></h3>
                    </div>
                </div>
                <?php foreach ($paragraphs as $paragraph) { ?>
                <p><?=$paragraph?></p>
                <?php }
            } ?>
        </article>
        <aside id="information">
            <section id="date-opened">
                <h3>Opened</h3>
                <p><?=$ticket->getDateOpened()?></p>
            </section>
            <form action="../actions/action_edit_ticket_properties.php" method="post" class="properties">
                <details>
                    <summary>Properties</summary>
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <?php if ($ticket->getStatus()) { ?>
                        <option value="<?=$ticket->getStatus()->getId()?>"><?=$ticket->getStatus()->getName()?></option>
                        <?php } if ($session->isAgent()) {
                            foreach ($statuses as $status) { 
                                if (!$ticket->getStatus() || $status->getId() !== $ticket->getStatus()->getId()) { ?>
                                <option value="<?=$status->getId()?>"><?=$status->getName()?></option>
                            <?php }
                            } 
                        } ?>
                    </select>
                    <label for="priority">Priority</label>
                    <select id="priority" name="priority">
                        <?php if ($ticket->getPriority()) { ?>
                        <option value="<?=$ticket->getPriority()->getId()?>"><?=$ticket->getPriority()->getName()?></option>
                        <?php } if ($session->isAgent()) {
                            foreach ($priorities as $priority) {
                                if (!$ticket->getPriority() || $priority->getId() !== $ticket->getPriority()->getId()) { ?>
                                <option value="<?=$priority->getId()?>"><?=$priority->getName()?></option>
                            <?php }
                            } 
                        } ?>
                    </select>
                    <label for="department">Department</label>
                    <select id="department" name="department">
                        <?php if ($ticket->getDepartment()) { ?>
                        <option value="<?=$ticket->getDepartment()->getId()?>"><?=$ticket->getDepartment()->getName()?></option>
                        <?php } if ($session->isAgent()) {
                            foreach ($departments as $department) {
                                if (!$ticket->getDepartment() || $department->getId() !== $ticket->getDepartment()->getId()) { ?>
                                <option value="<?=$department->getId()?>"><?=$department->getName()?></option>
                            <?php }
                            } 
                        } ?>
                    </select>
                    <label for="agent">Agent</label>
                    <select id="agent" name="agent">
                        <?php if ($ticket->getAgent()) { ?>
                        <option value="<?=$ticket->getAgent()->getId()?>"><?=$ticket->getAgent()->getName()?></option>
                        <?php } ?>
                        <?php if ($session->isAgent()) {
                            foreach ($agents as $agent) { 
                                if (!$ticket->getAgent() || $agent->getId() !== $ticket->getAgent()->getId()) {?>
                                <option value="<?=$agent->getId()?>"><?=$agent->getName()?></option>
                            <?php }
                            }
                        } ?>
                    </select>
                    <h4>Tags</h4>
                    <?php foreach ($tags as $tag) { ?>
                        <p><?=$tag->getName()?></p>
                    <?php } ?>
                    <input type="hidden" name="id" value="<?=$ticket->getId()?>">
                    <button type="submit" id="apply">Apply</button>
                </details>
            </form>
            <details id="changes">
                <summary>Changes</summary><!--
                <?php /* foreach ($ticket->getChanges() as $change) { ?>
                    <p><?=$change->getDate()?> - <?=$change->getDescription()?></p>
                <?php } */ ?>-->
                <p>Changes not implemented yet</p>
                <p>Changes not implemented yet</p>
            </details>
        </aside>
    </main>
<?php } ?>

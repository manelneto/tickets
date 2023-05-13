<?php
    declare(strict_types = 1);
?>

<?php function drawTicket(Session $session, Ticket $ticket, array $statuses, array $priorities, array $departments, array $agents, array $tags, array $changes) : void { ?>
    <main id="ticket-page">
        <article id="ticket">
            <?php $paragraphs = explode('\n', $ticket->getDescription()); ?>
            <?php if ($session->getId() === $ticket->getAuthor()->getId()) { ?>
                <form action="../actions/action_edit_ticket.php" method="post" class="edit-ticket">
                    <header id="ticket-header">
                        <img src="../assets/ticket.jpg" alt="Ticket Icon">
                        <h2><input type="text" name="title" required value="<?=$ticket->getTitle()?>"></h2>
                    </header>
                    <div id="author-edit"><!--odeio estes div!-->
                        <div id="author">
                            <img src="../assets/profile.png" alt="Profile Icon">
                            <h3><?=$ticket->getAuthor()->getName()?></h3>
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
                <div id="author"><!--odeio estes div!-->
                    <img src="../assets/profile.png" alt="Profile Icon">
                    <h3><?=$ticket->getAuthor()->getName()?></h3>
                </div>
                <?php foreach ($paragraphs as $paragraph) { ?>
                <p><?=$paragraph?></p>
                <?php }
            } ?>
        </article>
        <aside id="information">
            <section id="date-opened" class="date">
                <h3>Opened</h3>
                <p><?=$ticket->getDateOpened()?></p>
            </section>
            <?php if ($ticket->getStatus()->getName() === 'Closed') { ?>
            <section id="date-closed" class="date">
                <h3>Closed</h3>
                <p><?=$ticket->getDateClosed()?></p>
            </section>
            <?php } ?>
            <form action="../actions/action_edit_ticket_properties.php" method="post" class="properties">
                <details>
                    <summary>Properties</summary>
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <?php if ($ticket->getStatus()) { ?>
                        <option value="<?=$ticket->getStatus()->getId()?>"><?=$ticket->getStatus()->getName()?></option>
                        <?php } else { ?>
                        <option value="0"></option>
                        <?php } ?>
                        <?php if ($session->isAgent()) {
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
                        <?php } else { ?>
                        <option value="0"></option>
                        <?php } ?>
                        <?php if ($session->isAgent()) {
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
                        <?php } else { ?>
                        <option value="0"></option>
                        <?php } ?>
                        <?php if ($session->isAgent()) {
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
                        <?php } else { ?>
                        <option value="0"></option>
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
                    <?php if ($session->isAgent()) { ?>
                    <button type="submit" id="apply">Apply</button>
                    <?php } ?>
                </details>
            </form>
            <details id="changes">
                <summary>Changes</summary>
                <?php foreach ($changes as $change) { ?>
                    
                    <p><?=$change->getDate()?> - <?=$change->getDescription()?></p>
                <?php } ?>
            </details>
        </aside>
    </main>
<?php } ?>

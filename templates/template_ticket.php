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
            <form action="../actions/action_edit_ticket_properties.php" method="post" class="properties" novalidate>
                <details>
                    <summary>Properties</summary>
                    <?php drawProperty($session->isAgent(), 'Status', $ticket->getStatus(), $statuses); ?>
                    <?php drawProperty($session->isAgent(), 'Priority', $ticket->getPriority(), $priorities); ?>
                    <?php drawProperty($session->isAgent(), 'Department', $ticket->getDepartment(), $departments); ?>
                    <?php drawProperty($session->isAgent(), 'Agent', $ticket->getAgent(), $agents); ?>
                    <section>
                        <h4>Tags</h4>
                        <?php foreach ($tags as $tag) { ?>
                            <?php if ($session->isAgent()) { ?>
                            <input type="hidden" name="tag" value="<?=$tag->getId()?>">
                            <button formaction="../actions/action_delete_ticket_tag.php" formmethod="post" type="submit"><?=$tag->getName()?></button>
                            <?php } else { ?>
                            <p><?=$tag->getName()?></p>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($session->isAgent()) { ?>
                        <input id="tags" type="email" name="tags" placeholder="#tags" list="tags-list" multiple autocomplete>
                        <datalist id="tags-list">
                            <?php foreach ($tags as $tag) { ?>
                            <option value="<?=$tag->getName()?>"><?=$tag->getName()?></option>
                            <?php } ?>
                        </datalist>
                        <?php } ?>
                    </section>
                    <input type="hidden" name="id" value="<?=$ticket->getId()?>">
                    <?php if ($session->isAgent()) { ?>
                    <button type="submit" id="apply">Apply</button>
                    <?php } ?>
                </details>
            </form>
            <details id="changes">
                <summary>Changes</summary>
                <?php foreach ($changes as $change) { ?>
                    <h5><?=$change->getDate()?></h5>
                    <p><?=$change->getDescription()?></p>
                <?php } ?>
            </details>
        </aside>
    </main>
<?php } ?>

<?php function drawProperty(bool $isAgent, string $name, $entity, array $entities) : void { ?>
    <label for="<?=strtolower($name)?>"><?=$name?></label>
    <select id="<?=strtolower($name)?>" name="<?=strtolower($name)?>">
        <?php if ($entity) { ?>
        <option value="<?=$entity->getId()?>"><?=$entity->getName()?></option>
        <?php } else { ?>
        <option value="0"></option>
        <?php } ?>
        <?php if ($isAgent) {
            foreach ($entities as $e) {
                if (!$entity || $e->getId() !== $entity->getId()) { ?>
                <option value="<?=$e->getId()?>"><?=$e->getname()?></option>
            <?php }
            }
        } ?>
    </select>
<?php } ?>

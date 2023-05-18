<?php
    declare(strict_types = 1);
?>

<?php function drawTicket(Session $session, Ticket $ticket, array $statuses, array $priorities, array $departments, array $agents, array $tags, array $changes, array $messages, array $faqs) : void { ?>
    <main id="ticket-page">
        <article id="ticket-info">
            <?php $paragraphs = explode('\n', $ticket->getDescription()); ?>
            <?php if ($session->getId() === $ticket->getAuthor()->getId()) { ?>
                <form action="../actions/action_edit_ticket.php" method="post" class="edit-ticket">
                    <input type="hidden" name="id" value="<?=$ticket->getId()?>">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <header id="ticket-header">
                        <img src="../assets/ticket.jpg" alt="Ticket Icon">
                        <h2><input type="text" name="title" required value="<?=htmlentities($ticket->getTitle())?>"></h2>
                    </header>
                    <div id="author-edit"><!--odeio estes div!-->
                        <div id="author">
                            <img src="../profile_photos/profile_default.png" alt="Profile Icon">
                            <h3><?=htmlentities($ticket->getAuthor()->getName())?></h3>
                        </div>
                        <button type="submit">Edit</button>
                    </div>
                    <textarea id="description" name="description"><?php foreach ($paragraphs as $paragraph) echo htmlentities($paragraph); ?></textarea>
                </form>
            <?php } else { ?>
                <header id="ticket-header">
                    <img src="../assets/ticket.jpg" alt="Ticket Icon">
                    <h2><?=htmlentities($ticket->getTitle())?></h2>
                </header>
                <div id="author"><!--odeio estes div!-->
                    <img src="../profile_photos/profile_default.png" alt="Profile Icon">
                    <h3><?=htmlentities($ticket->getAuthor()->getName())?></h3>
                </div>
                <?php foreach ($paragraphs as $paragraph) { ?>
                <p><?=htmlentities($paragraph)?></p>
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
                <input type="hidden" name="id" value="<?=$ticket->getId()?>">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
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
                            <button formaction="../actions/action_delete_ticket_tag.php" formmethod="post" value="<?=$tag->getId()?>" name="tag"><?=htmlentities($tag->getName())?></button>
                            <?php } else { ?>
                            <p><?=htmlentities($tag->getName())?></p>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($session->isAgent()) { ?>
                        <input id="tags" type="email" name="tags" placeholder="#tags" list="tags-list" multiple autocomplete>
                        <datalist id="tags-list">
                            <?php foreach ($tags as $tag) { ?>
                            <option value="<?=$tag->getName()?>"><?=htmlentities($tag->getName())?></option>
                            <?php } ?>
                        </datalist>
                        <?php } ?>
                    </section>
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
    <!--  ..............MESSAGE_BOARD.............   -->
        <section id="MessageBoard">
            <h3>Message Board <span class="material-symbols-outlined">chat_bubble</span> </h3>
            <hr>
        <!--notes: o forearch vai gerar um article por cada message; o class=<php if..echo client vai fazer com que a class mude
        consoante o autor da mensagem é o autor do ticket ou é o agent a responder  -->
            <?php foreach ($messages as $message) { ?>
            <article class="<?php if ($message->getAuthor()->getId() === $ticket->getAuthor()->getId()) echo 'client'; else echo 'agent'; ?>">
                <header>
                    <h4><?=$message->getAuthor()->getName()?></h4>
                </header>
                <p><?=$message->getContent()?></p>
                <footer> <?=$message->getDate()?> </footer>
            </article>
            <?php } ?>
            <form action="../actions/action_add_message.php" method="post" class="MessageBoard">
                <input type="hidden" name="id" value="<?=$ticket->getId()?>">
                <label for="new-message">Add New Message:</label>       
                <textarea id="new-message" name="content" placeholder="Type a New Message" ></textarea>
                <select id="FAQ-reply" name="FAQ-reply">
                    <option value="default" hidden>Reply with FAQ</option>
                    <?php foreach ($faqs as $faq) { ?>
                    <option value="<?=$faq->getId()?>"><?=$faq->getQuestion()?></option>
                    <?php } ?>
                </select>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
<?php } ?>

<?php function drawProperty(bool $isAgent, string $name, $entity, array $entities) : void { ?>
    <label for="<?=strtolower($name)?>"><?=$name?></label>
    <select id="<?=strtolower($name)?>" name="<?=strtolower($name)?>">
        <?php if ($entity) { ?>
        <option value="<?=$entity->getId()?>"><?=htmlentities($entity->getName())?></option>
        <?php } else { ?>
        <option value="0"></option>
        <?php } ?>
        <?php if ($isAgent) {
            foreach ($entities as $e) {
                if (!$entity || $e->getId() !== $entity->getId()) { ?>
                <option value="<?=$e->getId()?>"><?=htmlentities($e->getname())?></option>
            <?php }
            }
        } ?>
    </select>
<?php } ?>

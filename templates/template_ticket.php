<?php
    declare(strict_types = 1);
?>

<?php function drawTicket(Session $session, Ticket $ticket, array $statuses, array $priorities, array $departments, array $agents, array $tags, array $changes, array $messages, array $faqs) : void { ?>
    <main id="ticket-page">
        <section id="ticket-main">
            <article id="ticket-info">
                <?php $paragraphs = explode('\n', $ticket->description); ?>
                <?php if ($session->getId() === $ticket->author->id) { ?>
                    <form action="../actions/action_edit_ticket.php" method="post" class="edit-ticket">
                        <input type="hidden" name="id" value="<?=$ticket->id?>">
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                        <header id="ticket-header">
                            <img src="../assets/message.png" alt="Ticket Icon">
                            <h2><input type="text" name="title" required value="<?=htmlentities($ticket->title)?>"></h2>
                        </header>
                        <div id="author-edit">
                            <div id="author">
                                <img class="upload-photo-ticket" src="<?='../profile_photos/' . $ticket->author->photo?>" alt="Profile Photo">
                                <h3><?=htmlentities($ticket->author->getName())?></h3>
                            </div>
                            <button type="submit" id="author-edit-button">Edit</button>
                        </div>
                        <textarea id="description" name="description"><?php foreach ($paragraphs as $paragraph) echo htmlentities($paragraph); ?></textarea>
                        <?php if ($ticket->filename !== ''){ ?>
                        <p>This ticket has an attachment. <a href="<?= '../ticket_files/' . $ticket->filename ?>" download>Download the file here</a></p>
                        <?php } ?>
                    </form>
                <?php } else { ?>
                    <form action="../actions/action_delete_ticket.php" method="post" class="delete-ticket">
                        <input type="hidden" name="id" value="<?=$ticket->id?>">
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                        <header id="ticket-header">
                            <img src="../assets/message.png" alt="Ticket Icon">
                            <h2><?=htmlentities($ticket->title)?></h2>
                        </header>
                        <div id="author-delete">
                            <div id="author">
                                <img class="upload-photo-ticket" src="<?='../profile_photos/' . $ticket->author->photo?>" alt="Profile Photo">
                                <h3><?=htmlentities($ticket->author->getName())?></h3>
                            </div>
                            <button type="submit" id="author-delete-button">Delete</button>
                        </div>
                    </form>
                    <?php foreach ($paragraphs as $paragraph) { ?>
                    <p><?=htmlentities($paragraph)?></p>
                    <?php } ?>
                    <?php if ($ticket->filename !== ''){ ?>
                    <p>This ticket has an attachment. <a href="<?= '../ticket_files/' . $ticket->filename ?>" download>Download the file here</a></p>
                    <?php } ?>
                <?php } ?>
            </article>
            <details id="message-board">
                <summary>Message Board<button id="show-button">Show</button></summary>
                <hr>
                <section id="all-messages">
                    <?php foreach ($messages as $message) { ?>
                    <article class="<?php if ($message->author->id === $session->getId()) echo 'self'; else echo 'other'; ?>">
                        <header>
                            <img class="message-photo" src="<?='../profile_photos/' . $message->author->photo ?>" alt="Profile Photo">
                            <p><?=$message->author->getName()?></p>
                            <p class="message-date"> <?=$message->date?> </p>
                        </header>
                        <p class="message-content"><?=$message->content?></p>
                        <?php if ($session->isAdmin()) { ?>
                            <form action="../actions/action_delete_message.php" method="post" class="delete-message">
                                <input type="hidden" name="id" value="<?=$message->id?>">
                                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                                <button type="submit">Delete</button>
                            </form>
                        <?php } ?>
                    </article>
                    <?php } ?>
                    <form action="../actions/action_add_message.php" method="post" class="add-message">
                        <input type="hidden" name="id" value="<?=$ticket->id?>">
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                        <input id="message-author" type="hidden" value="<?=$session->getId()?>">
                        <?php if ($session->isAgent()) { ?>
                        <select id="faq-reply" name="faq-reply">
                            <option value="0">Reply with FAQ</option>
                            <?php foreach ($faqs as $faq) { ?>
                            <option value="<?=$faq->id?>"><?=$faq->question?></option>
                            <?php } ?>
                        </select>
                        <?php } ?>
                        <textarea id="new-message" name="content" placeholder="Type a New Message"></textarea>
                        <button id="send" type="submit">Send</button>
                    </form>
                </section>
            </details>
        </section>
        <img id="tools" src="../assets/tools.png" alt="Tools Icon">
        <aside id="information">
            <section id="date-opened" class="date">
                <h3>Opened</h3>
                <p><?=$ticket->dateOpened?></p>
            </section>
            <?php if ($ticket->status && $ticket->status->name === 'Closed') { ?>
            <section id="date-closed" class="date">
                <h3>Closed</h3>
                <p><?=$ticket->dateClosed?></p>
            </section>
            <?php } ?>
            <form action="../actions/action_edit_ticket_properties.php" method="post" class="properties">
                <input id="id" type="hidden" name="id" value="<?=$ticket->id?>">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <details>
                    <summary>Properties</summary>
                    <?php drawProperty($session->isAgent() && $session->getId() !== $ticket->author->id, 'Status', $ticket->status, $statuses); ?>
                    <?php drawProperty($session->isAgent() && $session->getId() !== $ticket->author->id, 'Priority', $ticket->priority, $priorities); ?>
                    <?php drawProperty($session->isAgent() && $session->getId() !== $ticket->author->id, 'Department', $ticket->department, $departments); ?>
                    <?php drawProperty($session->isAgent() && $session->getId() !== $ticket->author->id, 'Agent', $ticket->agent, $agents); ?>
                    <section id="property-tag">
                        <h4><label for="tags">Tags</label></h4>
                        <?php foreach ($tags as $tag) { ?>
                            <?php if ($session->isAgent() && $session->getId() !== $ticket->author->id) { ?>
                            <button formaction="../actions/action_delete_ticket_tag.php" formmethod="post" class="all-tags" value="<?=$tag->id?>" name="tag" id="<?=$tag->name?>"><?=htmlentities($tag->name)?></button>
                            <?php } else { ?>
                            <p><?=htmlentities($tag->name)?></p>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($session->isAgent() && $session->getId() !== $ticket->author->id) { ?>
                        <input type="text" id="tags" name="tags">
                        <?php } ?>
                    </section>
                    <?php if ($session->isAgent() && $session->getId() !== $ticket->author->id) { ?>
                    <button type="submit" id="apply">Apply</button>
                    <?php } ?>
                </details>
            </form>
            <details id="changes">
                <summary>Changes</summary>
                <?php foreach ($changes as $change) { ?>
                    <h5><?=$change->date?></h5>
                    <p><?=$change->description?></p>
                <?php } ?>
            </details>
        </aside>
    </main>
<?php } ?>

<?php function drawProperty(bool $canEdit, string $name, $entity, array $entities) : void { ?>
    <label for="<?=strtolower($name)?>"><?=$name?></label>
    <select id="<?=strtolower($name)?>" name="<?=strtolower($name)?>">
        <?php if ($entity) { ?>
        <option value="<?=$entity->id?>"><?=htmlentities($entity->getName())?></option>
        <?php } else { ?>
        <option value="0"></option>
        <?php } ?>
        <?php if ($canEdit) {
            foreach ($entities as $e) {
                if (!$entity || $e->id !== $entity->id) { ?>
                <option value="<?=$e->id?>"><?=htmlentities($e->getname())?></option>
            <?php }
            }
        } ?>
    </select>
<?php } ?>

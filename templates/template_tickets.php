<?php
    declare(strict_types = 1);
?>

<?php function drawTickets(array $tickets) { ?>
    <section id="tickets">
        <h2>My Tickets</h2>
        <?php foreach ($tickets as $ticket) { ?>
        <article class="ticket">

        </article>
        <?php } ?>
    </section>
<?php } ?>

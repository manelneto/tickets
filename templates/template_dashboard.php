<?php
    declare(strict_types = 1);
?>

<?php function drawDashboard(int $opened, int $assigned, int $closed, int $overdue) { ?>
    <section class="opened">
        <h2>Opened</h2>
        <p><?=$opened?></p>
    </section>
    <section class="assigned">
        <h2>Assigned</h2>
        <p><?=$assigned?></p>
    </section>
    <section class="closed">
        <h2>Closed</h2>
        <p><?=$closed?></p>
    </section>
    <section class="overdue">
        <h2>Overdue</h2>
        <p><?=$overdue?></p>
    </section>
<?php } ?>

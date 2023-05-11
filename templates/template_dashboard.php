<?php
    declare(strict_types = 1);
?>

<?php function drawDashboard(int $opened, int $assigned, int $closed, int $overdue) { ?>
    <main class="dashboard-tickets">
        <section class="opened">
            <h2> Opened </h2>
            <p>You have <?=$opened?> tickets opened!</p>
        </section>
        <section class="assigned">
            <h2>Assigned</h2>
            <p>You have <?=$assigned?> tickets assigned!</p>
        </section>
        <section class="closed">
            <h2> Closed </h2>
            <p>You have <?=$closed?> tickets closed!</p>
        </section>
        <section class="overdue">
            <h2>Overdue</h2>
            <p>You have <?=$overdue?> tickets overdue!</p>
        </section>
    </main>
<?php } ?>

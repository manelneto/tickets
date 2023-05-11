<?php
    declare(strict_types = 1);
?>

<?php function drawDashboard(int $opened, int $assigned, int $closed) : void { ?>
    <main id="dashboard">
        <section class="card">
            <h2>Opened</h2>
            <p>You have <?=$opened?> tickets opened!</p>
        </section>
        <section class="card">
            <h2>Assigned</h2>
            <p>You have <?=$assigned?> tickets assigned!</p>
        </section>
        <section class="card">
            <h2>Closed</h2>
            <p>You have <?=$closed?> tickets closed!</p>
        </section>
    </main>
<?php } ?>

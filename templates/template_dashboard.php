<?php
    declare(strict_types = 1);
?>

<?php function drawDashboard(int $opened, int $assigned, int $closed) : void { ?>
    <main>
        <section id="dashboard">
            <h2>Dashboard</h2>
            <article class="card">
                <h3>Opened</h3>
                <p>You have <?=$opened?> tickets opened!</p>
            </article>
            <article class="card">
                <h3>Assigned</h3>
                <p>You have <?=$assigned?> tickets assigned!</p>
            </article>
            <article class="card">
                <h3>Closed</h3>
                <p>You have <?=$closed?> tickets closed!</p>
            </article>
        </section>
    </main>
<?php } ?>

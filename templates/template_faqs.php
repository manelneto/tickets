<?php
    declare(strict_types = 1);
?>

<?php function drawFAQs(array $faqs) { ?>
    <section id="faqs">
        <h2>FAQ</h2>
        <?php foreach($faqs as $faq) { ?>
        <details class="faq">
            <summary class="question"><?=$faq->getQuestion()?></summary>
            <p class="answer"><?=$faq->getAnswer()?></p>
        </details>
        <?php } ?>
    </section>
<?php } ?>

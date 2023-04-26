<?php
    declare(strict_types = 1);
?>

<?php function drawFAQs(array $faqs) { ?>
    <section id="faqs">
        <?php foreach($faqs as $faq) { ?>
        <details class="faq">
            <summary class="question"><?=$faq->getQuestion()?></summary>
            <p class="answer"><?=$faq->getAnswer()?></p>
        </details>
        <?php } ?>
    </section>
<?php } ?>

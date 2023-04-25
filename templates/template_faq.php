<?php
    declare(strict_types = 1);
?>

<?php function drawFAQ($faqs) { ?>
    <section id="faq">
    <?php foreach($faqs as $faq) { ?>
    <details>
        <summary><?=$faq->getQuestion()?></summary>
        <?php 
        $paragraphs = explode('.', $faq->getAnswer());
        foreach ($paragraphs as $paragraph) { ?>
            <p><?=$paragraph?></p>
        <?php } ?>
    </details>
    <?php } ?>
<?php } ?>

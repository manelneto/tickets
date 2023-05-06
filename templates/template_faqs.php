<?php
    declare(strict_types = 1);
?>

<?php function drawFAQsClient(array $faqs) { ?>
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

<?php function drawFAQsAgent(array $faqs) { ?>
    <section id="faqs">
        <h2>FAQ</h2>
        <?php foreach($faqs as $faq) { ?>
        <form method="post">
            <input type="hidden" name="id" value="<?=$faq->getId()?>">
            <details class="faq">
                <summary class="question">
                    <input type="text" name="question" value="<?=$faq->getQuestion()?>">
                </summary>
                <textarea class="answer" name="answer"><?=$faq->getAnswer()?></textarea>
                <button formaction="../actions/action_edit_faq.php">Edit</button>
                <button formaction="../actions/action_delete_faq.php">Delete</button>
            </details>
        </form>
        <?php } ?>
        <form action="../actions/action_add_faq.php" method="post">
            <details class="faq">
                <summary>Add a new FAQ</summary>
                <label for="question">Question</label>
                <input type="text" name="question" placeholder="question">
                <label for="answer">Answer</label>
                <textarea name="answer" placeholder="answer"></textarea>
                <button type="submit">Add</button>
            </details>
        </form>
    </section>
<?php } ?>

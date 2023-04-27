<?php
    declare(strict_types = 1);
?>

<?php function drawManagemnt() { ?>
    <section id="management">
        <h2>Management</h2>
        <form class="upgrade">
            <h3>Upgrade a client</h3>
            <label for="client">Select a client</label>
            <!-- LISTA COM HIPÓTESE DE ESCREVER ???? -->
            <button type="submit" id="add">Upgrade</button>
        </form>
        <form class="entity">
            <h3>Add a new entity</h3>
            <label for="entity">Select a entity</label>
            <select id="entity" name="entity">
                <option value="department">Department</option>
                <option value="status">Status</option>
                <option value="priority">Priority</option>
                <option value="tag">Tag</option>
            </select>
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
            <button type="submit" id="add">Add</button>
        </form>
        <form class="assign">
            <h3>Assign agent to department</h3>
            <label for="departmnt">Select a department</label>
            <select id="department" name="department">
                <?php for ($departments as $department) { ?>
                <option value="<?=$department->getName()?>"><?=$department->getName()?></option>
                <?php } ?>
            </select>
            <label for="agent">Select a agent</label>
            <!-- LISTA COM HIPÓTESE DE ESCREVER ???? -->
            <button type="submit" id="add">Assign</button>
        </form>
    </section>
<?php } ?>

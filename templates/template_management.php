<?php
    declare(strict_types = 1);
?>

<?php function drawManagemnt(array $clients, array $departments, array $agents) { ?>
    <section id="management">
        <h2>Management</h2>
        <form action="../actions/action_upgrade_client.php" method="post" class="upgrade">
            <h3>Upgrade a client</h3>
            <label for="client">Select a client</label>
            <select id="client" name="client">
                <?php for ($clients as $client) { ?>
                <option value="<?=$client->getId()?>"><?=$client->getUsername()?></option>
                <?php } ?>
            </select>
            <label>To agent
                <input type="radio" name="agent" value="agent">
            </label>
            <label>To admin
                <input type="radio" name="admin" value="admin">
            </label>
            <button type="submit" id="add">Upgrade</button>
        </form>
        <form action="../actions/action_add_entity.php" method="post"class="entity">
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
        <form action="../actions/action_assign_agent.php" method="post" class="assign">
            <h3>Assign agent to department</h3>
            <label for="departmnt">Select a department</label>
            <select id="department" name="department">
                <?php for ($departments as $department) { ?>
                <option value="<?=$department->getId()?>"><?=$department->getName()?></option>
                <?php } ?>
            </select>
            <label for="agent">Select an agent</label>
            <select id="agent" name="agent">
                <?php for ($agents as $agent) { ?>
                <option value="<?=$agent->getId()?>"><?=$agent->getUsername()?></option>
                <?php } ?>
            </select>
            <button type="submit" id="add">Assign</button>
        </form>
    </section>
<?php } ?>

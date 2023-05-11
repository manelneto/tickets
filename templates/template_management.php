<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/class_user.php');
    require_once(__DIR__ . '/../database/class_department.php');
?>

<?php function drawManagement(array $clients, array $departments, array $agents) : void { ?>
    <main>
        <section id="management">
            <h2>Management</h2>
            <details class="management">
                <summary class="action">Upgrade a client</summary>
                <form action="../actions/action_upgrade_client.php" method="post" class="upgrade">
                    <label for="client">Select a client</label>
                    <select id="client" name="client" required>
                        <?php foreach ($clients as $client) { ?>
                        <option value="<?=$client->getId()?>"><?=$client->getUsername()?></option>
                        <?php } ?>
                    </select>
                    <div id="upgrade-role">
                        <label for="agent">To agent</label>
                        <input id="agent" type="radio" name="role" value="agent">
                        <label for="admin">To admin</label>
                        <input id=admin" type="radio" name="role" value="admin">
                    </div>
                    <button type="submit">Upgrade</button>
                </form>
            </details>
            <details class="management">
                <summary class="action">Add a new entity</summary>
                <form action="../actions/action_add_entity.php" method="post" class="entity">
                    <label for="entity">Select an entity</label>
                    <select id="entity" name="entity">
                        <option value="department">Department</option>
                        <option value="status">Status</option>
                        <option value="priority">Priority</option>
                        <option value="tag">Tag</option>
                    </select>
                    <div class="field"><!--não gosto desta div mas desisti de tentar-->
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <button type="submit">Add</button>
                </form>
            </details>
            <details class="management">
                <summary class="action">Assign agent to department</summary>
                <form action="../actions/action_assign_agent.php" method="post" class="assign">
                    <label for="department">Select a department</label>
                    <select id="department" name="department">
                        <?php foreach ($departments as $department) { ?>
                        <option value="<?=$department->getId()?>"><?=$department->getName()?></option>
                        <?php } ?>
                    </select>
                    <div class="field"><!--não gosto desta div mas desisti de tentar-->
                        <label for="agent">Select an agent</label>
                        <select id="agent" name="agent">
                            <?php foreach ($agents as $agent) { ?>
                            <option value="<?=$agent->getId()?>"><?=$agent->getUsername()?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit">Assign</button>
                </form>
            </details>
        </section>
    </main>
<?php } ?>

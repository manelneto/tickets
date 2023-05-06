<?php
    declare(strict_types = 1);
?>

<?php function drawManagement(array $clients, array $departments, array $agents) { ?>
    <section id="management">
        <h2>Management</h2>
        <form action="../actions/action_upgrade_client.php" method="post" >
            <details class="upgrade">
                <summary class="question">Upgrade a client</summary>
                <div class="upgradeInfo">
                    <label for="client">Select a client</label>
                    <select id="client" name="client">
                        <?php foreach ($clients as $client) { ?>
                        <option value="<?=$client->getId()?>"><?=$client->getUsername()?></option>
                        <?php } ?>
                    </select>
                    <div class="updateRole">
                        <label>To agent
                            <input type="radio" name="role" value="agent">
                        </label>
                        <label>To admin
                            <input type="radio" name="role" value="admin">
                        </label>
                    </div>
                    <button type="submit" id="add">Upgrade</button>
                </div>
            </details>
        </form>
        <form action="../actions/action_add_entity.php" method="post"> <!--forms tem que ter class?-->
            <details class="entity">
                <summary class="question">Add a new entity</summary>
                <div class="entityInfo">
                    <label for="entity">Select a entity</label>
                    <select id="entity" name="entity">
                        <option value="department">Department</option>
                        <option value="status">Status</option>
                        <option value="priority">Priority</option>
                        <option value="tag">Tag</option>
                    </select>
                    <div class="entityName">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <button type="submit" id="add">Add</button>
                </div>
            </details>
        </form>
        <form action="../actions/action_assign_agent.php" method="post">
            <details class="assign">
                <summary class="question">Assign agent to department</summary>
                <div class="assignInfo">
                    <label for="department">Select a department</label>
                    <select id="assignDepartment" name="department">
                        <?php foreach ($departments as $department){ ?>
                        <option value="<?=$department->getId()?>"><?=$department->getName()?></option>
                        <?php } ?>
                    </select>
                    <div class="assignAgent">
                        <label for="agent">Select an agent</label>
                        <select id="agent" name="agent">
                            <?php foreach ($agents as $agent) { ?>
                            <option value="<?=$agent->getId()?>"><?=$agent->getUsername()?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" id="add">Assign</button>
                </div>
            </details>
        </form>
    </section>
<?php } ?>

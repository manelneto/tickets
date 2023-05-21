<?php
    declare(strict_types = 1);
?>

<?php function drawManagement(array $notAdmins, array $departments, array $agents) : void { ?>
    <main>
        <section id="management">
            <h2>Management</h2>
            <details class="management">
                <summary class="action">Upgrade a client</summary>
                <form action="../actions/action_upgrade_client.php" method="post" class="upgrade">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <label for="client">Select a client</label>
                    <select id="client" name="client" required>
                        <?php foreach ($notAdmins as $client) { ?>
                        <option value="<?=$client->id?>"><?=htmlentities($client->username)?></option>
                        <?php } ?>
                    </select>
                    <div id="upgrade-role">
                        <label for="agent">To agent</label>
                        <input id="agent" type="radio" name="role" value="agent" required>
                        <label for="admin">To admin</label>
                        <input id="admin" type="radio" name="role" value="admin" required>
                    </div>
                    <button type="submit">Upgrade</button>
                </form>
            </details>
            <details class="management">
                <summary class="action">Add a new entity</summary>
                <form action="../actions/action_add_entity.php" method="post" class="entity">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <label for="entity">Select an entity</label>
                    <select id="entity" name="entity" required>
                        <option value="department">Department</option>
                        <option value="status">Status</option>
                        <option value="priority">Priority</option>
                        <option value="tag">Tag</option>
                    </select>
                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <button type="submit">Add</button>
                </form>
            </details>
            <details class="management">
                <summary class="action">Assign agent to department</summary>
                <form action="../actions/action_assign_agent.php" method="post" class="assign">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <label for="department">Select a department</label>
                    <select id="department" name="department" required>
                        <?php foreach ($departments as $department) { ?>
                        <option value="<?=$department->id?>"><?=htmlentities($department->name)?></option>
                        <?php } ?>
                    </select>
                    <div class="field">
                        <label for="agent">Select an agent</label>
                        <select id="agent" name="agent" required>
                            <?php foreach ($agents as $agent) { ?>
                            <option value="<?=$agent->id?>"><?=htmlentities($agent->username)?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit">Assign</button>
                </form>
            </details>
            <details class="management">
                <summary class="action">Delete an entity</summary>
                <form action="../actions/action_delete_entity.php" method="post" class="delete-entity">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <label for="entity-delete">Select an entity</label>
                    <select id="entity-delete" name="entity" required>
                        <option value="department">Department</option>
                        <option value="status">Status</option>
                        <option value="priority">Priority</option>
                        <option value="tag">Tag</option>
                    </select>
                    <div class="field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <button type="submit">Delete</button>
                </form>
            </details>
            <details class="management">
                <summary class="action">Delete a user</summary>
                <form action="../actions/action_delete_user.php" method="post" class="delete-user">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    <label for="user">Select a user</label>
                    <select id="user" name="user" required>
                        <?php foreach ($notAdmins as $user) { ?>
                            <option value="<?=$user->id?>"><?=htmlentities($user->username)?></option>
                        <?php } ?>
                    </select>
                    <button type="submit">Delete</button>
                </form>
            </details>
        </section>
    </main>
<?php } ?>

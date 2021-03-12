<?php

require_once ("userListsAndTasks.php");

/* Page Title */
$pageTitle = "ToDo Lists";

?>


<!-- Header -->
<?php include ("header.php"); ?>
<!---->


<section id="toDoListsSection">

    <?php if (!$lists): ?>

        <p>No TODO lists here yet</p>

    <?php else: ?>


    <!-- ToDoLists UL -->
    <ul id="todoListUl">

        <?php foreach ($lists as $list):  ?>

        <li>
                <!-- ToDoList Title -->

                <a class="btn btn-primary" data-toggle="collapse" href="#<?= 'collapse' . $list['id'] ?>" role="button" aria-expanded="<?= ($_SESSION['listId'] == $list['id']) ? 'true' : 'false'?>" aria-controls="<?= 'collapse' . $list['id'] ?>">
                    <?= $list['title'] ?>
                </a>
                <div class="tasksDiv bg-light collapse <?= ($_SESSION['listId'] == $list['id']) ? 'show' : ''?>" id="<?= 'collapse' . $list['id'] ?>">

                    <?php if (!$list['tasks']): ?>
                        <p>No tasks here yet</p>
                    <?php endif ?>


                    <!-- Form to add new task in TODOlist -->

                    <form method="POST" action="forms.php">
                        <input class="taskTitle" name="taskTitle" placeholder = "New Task" type="text">
                        <input type="hidden" name="listId" value="<?= $list['id'] ?>">
                        <input class="submitNewTask" name="submitNewTask" type="submit" value="Add new task">
                    </form>


                    <!-- Tasks in TODOlist -->

                    <table class="tasksTable mt-3">
                        <?php

                        ?>
                        <?php foreach ($list['tasks'] as $task): ?>

                            <tr>
                                <td><?= $task['title'] ?></td>
                                <td>

                                    <!-- Form to mark if task is done -->

                                    <form method="POST" action="forms.php">
                                        <input type="checkbox" value="" name="checkIsDone" onChange="this.form.submit()" <?= $task['done'] ? 'checked' : '' ?> title="Mark if task is done">
                                        <input type="hidden" name="taskIdForCheck" value="<?= $task['id'] ?>">
                                        <input type="hidden" name="listId" value="<?= $list['id'] ?>">
                                    </form>
                                </td>
                                <td>

                                    <!-- Form to delete task in TODOlist -->

                                    <form method="POST" action="forms.php">
                                        <button type="submit" class="close" name="delete" title="Delete task">&times;</button>
                                        <input type="hidden" name="listId" value="<?= $list['id'] ?>">
                                        <input type="hidden" name="taskId" value="<?= $task['id'] ?>">
                                    </form>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </table>

                </div>
        </li>

        <?php endforeach; ?>

    </ul>
    <?php endif ?>

    <hr>

    <!-- Form to add new TODOlist -->

    <form method="POST" action="forms.php">
        <input id="listTitle" name="listTitle" placeholder = "Enter New List Title" type="text">
        <input type="hidden" name="userId" value="<?= $authorizedUserId ?>">
        <input id="submitNewList" name="submitNewList" type="submit" value="Add new TODO list">
    </form>

</section>


<!-- Footer -->
<?php require_once "footer.php"; ?>
<!---->

<div class="task-list">
    <div class="task-block">
        <?php if(count($tasks)) { ?>
            <?php foreach($tasks as $task) { ?>
                <div class="task-block-cnt">
                    <div class="task-title-desc">
                        <h3 class="title"><?php echo $task['title'] ?></h3>
                        <p class="description"><?php echo $task['description'] ?></p>
                    </div>
                    <div class="task-other-desc">
                        <button class="priority-status"><?php echo $task['priority'] ?></button>
                        <button class="priority-status status"><?php echo $task['status'] ?></button>
                    </div>
                    <div class="edit-delete">
                        <span class="task-edit"><a href="<?php echo '/tasks/' . $task['id'] . '/delete' ?>"><img src="<?php echo App::baseUrl('/assets/delete.svg') ?>" alt="delete"></a></span>
                        <span class="task-edit"><a href="<?php echo '/tasks/' . $task['id'] . '/update' ?>"><img src="<?php echo App::baseUrl('/assets/edit.svg') ?>" alt="edit"></a></span>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            empty content!!
        <?php } ?>
    </div>
</div>
<div class="sign-page">
    <div class="sign sign-in d_flex a_items_center j_content_center">
        <div class="sign-block">
            <div class="logo">
                <a href="#"><img src="<?php echo App::baseUrl('/assets/logo.png') ?>" alt="logo" /></a>
            </div>
            <div class="form">
                <form name="basic" action="/tasks/<?php echo $create ? 'create' : $task['id'] . '/update' ?>" method="POST">
                    <div class="form-item">
                        <input type="text" name="title" value="<?php echo isset($old['title']) ? $old['title'] : (isset($task['title']) ? $task['title'] : '') ?>">
                        <span class="input-area-placeholder">Title</span>
                        <span class="error"><?php echo isset($error["title"]) ? $error["title"] : "" ?></span>
                    </div>
                    <div class="form-item">
                        <input type="text" name="description" value="<?php echo isset($old['description']) ? $old['description'] : (isset($task['description']) ? $task['description'] : '') ?>">
                        <span class="input-area-placeholder">Description</span>
                        <span class="error"><?php echo isset($error["description"]) ? $error["description"] : "" ?></span>
                    </div>
                    <?php
                        $priority = isset($old['priority']) ? $old['priority'] : (isset($task['priority']) ? $task['priority'] : '');
                        $status = isset($old['status']) ? $old['status'] : (isset($task['status']) ? $task['status'] : '');
                    ?>
                    <div class="form-item">
                        <select name="priority" class="priority-status">
                        <option value="low" <?php echo $priority === 'normal' ? 'selected' : '' ?>>Low</option>
                            <option value="normal" <?php echo $priority === 'low' ? 'selected' : '' ?>>Normal</option>
                            <option value="high" <?php echo $priority === 'high' ? 'selected' : '' ?>>High</option>
                        </select>
                    </div>
                    <?php if(!$create) { ?>
                        <div class="form-item">
                            <select name="status" class="priority-status status">
                                <option value="pending" <?php echo $status === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="in-process" <?php echo $status === 'in-process' ? 'selected' : '' ?>>In process</option>
                                <option value="done" <?php echo $status === 'done' ? 'selected' : '' ?>>Done</option>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="form-item">
                        <div class="submit-btn">
                            <button type="submit"><span>Submit</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
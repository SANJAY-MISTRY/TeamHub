<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page">
    <div class="breadcrumbs">
        <a href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
        &raquo;
        <?php echo htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8'); ?>
        &raquo;
        <?php echo htmlspecialchars($project['name'], ENT_QUOTES, 'UTF-8'); ?>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="flash flash-error">
            <?php echo htmlspecialchars($this->session->flashdata('error'), ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
        <div class="flash flash-success">
            <?php echo htmlspecialchars($this->session->flashdata('success'), ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <div class="top">
        <section class="summary">
            <h1><?php echo htmlspecialchars($project['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <?php if (! empty($project['description'])): ?>
                <p><?php echo htmlspecialchars($project['description'], ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <p>Team: <strong><?php echo htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8'); ?></strong></p>
            <?php if (! empty($project['due_date'])): ?>
                <p>Due: <?php echo htmlspecialchars($project['due_date'], ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
        </section>

        <section class="new-task">
            <h2>New Task</h2>
            <form method="post" action="<?php echo site_url('tasks/create'); ?>">
                <input type="hidden" name="project_id" value="<?php echo (int) $project['id']; ?>">
                <div class="field">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="field">
                    <label for="description">Description (optional)</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <div class="field">
                    <label for="assigned_user_id">Assign to (optional)</label>
                    <select id="assigned_user_id" name="assigned_user_id">
                        <option value="">Unassigned</option>
                        <?php foreach ($members as $member): ?>
                            <option value="<?php echo (int) $member['user_id']; ?>"><?php echo htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label for="due_date">Due date (optional)</label>
                    <input type="date" id="due_date" name="due_date">
                </div>
                <button class="btn" type="submit">Add task</button>
            </form>
        </section>
    </div>

    <section class="board">
        <?php
        $columns = array(
            'todo' => 'To Do',
            'in_progress' => 'In Progress',
            'done' => 'Done',
        );
        ?>
        <?php foreach ($columns as $key => $label): ?>
            <div class="column">
                <h3><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></h3>
                <?php $columnTasks = isset($tasksByStatus[$key]) ? $tasksByStatus[$key] : array(); ?>
                <?php if (empty($columnTasks)): ?>
                    <p class="task-meta">No tasks.</p>
                <?php else: ?>
                    <?php foreach ($columnTasks as $task): ?>
                        <div class="task">
                            <div class="task-title"><?php echo htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php if (! empty($task['description'])): ?>
                                <div class="task-meta"><?php echo htmlspecialchars($task['description'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                            <div class="task-meta">
                                Status: <?php echo htmlspecialchars(str_replace('_', ' ', $task['status']), ENT_QUOTES, 'UTF-8'); ?>
                                <?php if (! empty($task['due_date'])): ?>
                                    &middot; Due <?php echo htmlspecialchars($task['due_date'], ENT_QUOTES, 'UTF-8'); ?>
                                <?php endif; ?>
                            </div>
                            <form method="post" action="<?php echo site_url('tasks/' . (int) $task['id'] . '/update'); ?>">
                                <div class="field">
                                    <label>Status</label>
                                    <select name="status">
                                        <option value="todo" <?php echo $task['status'] === 'todo' ? 'selected' : ''; ?>>To Do</option>
                                        <option value="in_progress" <?php echo $task['status'] === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="done" <?php echo $task['status'] === 'done' ? 'selected' : ''; ?>>Done</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label>Assignee</label>
                                    <select name="assigned_user_id">
                                        <option value="">Unassigned</option>
                                        <?php foreach ($members as $member): ?>
                                            <option value="<?php echo (int) $member['user_id']; ?>" <?php echo $task['assigned_user_id'] == $member['user_id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button class="btn" type="submit">Update</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>
</div>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-header" style="display:flex;align-items:center;justify-content:space-between;gap:0.5rem;">
            <h2 style="margin:0;">Your Teams</h2>
            <?php if (! empty($currentTeam)): ?>
                <a class="btn" style="padding:0.2rem 0.6rem;font-size:0.75rem;" href="<?php echo site_url('teams/' . (int) $currentTeam['id'] . '/members'); ?>">
                    Members
                </a>
            <?php endif; ?>
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

        <div class="teams-list" style="margin-top:0.75rem;">
            <?php if (! empty($teams)): ?>
                <form method="post" action="<?php echo site_url('teams/switch'); ?>">
                    <div class="field">
                        <label for="team_id">Current team</label>
                        <select id="team_id" name="team_id" onchange="this.form.submit()">
                            <?php foreach ($teams as $team): ?>
                                <option value="<?php echo (int) $team['id']; ?>" <?php echo (isset($currentTeam) && $currentTeam && $currentTeam['id'] == $team['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            <?php else: ?>
                <p class="empty">You are not part of any team yet.</p>
            <?php endif; ?>
        </div>

        <h2>Create Team</h2>
        <form method="post" action="<?php echo site_url('teams/create'); ?>">
            <div class="field">
                <label for="team_name">Team name</label>
                <input type="text" id="team_name" name="name" required>
            </div>
            <div class="field">
                <label for="team_description">Description (optional)</label>
                <input type="text" id="team_description" name="description">
            </div>
            <button class="btn" type="submit">Create team</button>
        </form>
    </aside>

    <main class="content">
        <div class="projects-card">
            <?php if (! $currentTeam): ?>
                <h2>No team selected</h2>
                <p class="empty">Create a team or join one to start creating projects and tasks.</p>
            <?php else: ?>
                <h2>Projects &ndash; <?php echo htmlspecialchars($currentTeam['name'], ENT_QUOTES, 'UTF-8'); ?></h2>

                <form method="post" action="<?php echo site_url('projects/create'); ?>">
                    <input type="hidden" name="team_id" value="<?php echo (int) $currentTeam['id']; ?>">
                    <div class="field">
                        <label for="project_name">Project name</label>
                        <input type="text" id="project_name" name="name" required>
                    </div>
                    <div class="field">
                        <label for="project_description">Description (optional)</label>
                        <input type="text" id="project_description" name="description">
                    </div>
                    <div class="field">
                        <label for="project_due">Due date (optional)</label>
                        <input type="date" id="project_due" name="due_date">
                    </div>
                    <button class="btn" type="submit">Add project</button>
                </form>

                <div class="projects-grid">
                    <?php if (! empty($projects)): ?>
                        <?php foreach ($projects as $project): ?>
                            <div class="project">
                                <h3><?php echo htmlspecialchars($project['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <?php if (! empty($project['description'])): ?>
                                    <p><?php echo htmlspecialchars($project['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php endif; ?>
                                <?php if (! empty($project['due_date'])): ?>
                                    <p>Due: <?php echo htmlspecialchars($project['due_date'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php endif; ?>
                                <a href="<?php echo site_url('projects/' . (int) $project['id']); ?>">View tasks</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty">No projects yet for this team.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

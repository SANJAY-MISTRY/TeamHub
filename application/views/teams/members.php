<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page page-narrow">
    <div class="breadcrumbs">
        <a href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
        &raquo;
        <?php echo htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8'); ?>
        &raquo;
        Members
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

    <h1><?php echo htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8'); ?> &ndash; Members</h1>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        </thead>
        <tbody>
        <?php if (! empty($members)): ?>
            <?php foreach ($members as $member): ?>
                <tr>
                    <td><?php echo htmlspecialchars($member['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($member['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($member['role'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No members yet.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="invite-card">
        <h2 style="margin-top:0;font-size:1rem;">Invite member (mock)</h2>
        <p style="margin:0 0 0.5rem;font-size:0.8rem;color:#6b7280;">Enter an email to add a user to this team. If the email does not exist, a mock user will be created.</p>
        <form method="post" action="<?php echo site_url('teams/' . (int) $team['id'] . '/invite'); ?>">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button class="btn" type="submit">Send invite</button>
        </form>
    </div>
</div>

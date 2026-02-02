<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TeamHub - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif; background:#f4f4f5; margin:0; }
        .auth-wrapper { min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1rem; }
        .card { background:#fff; max-width:400px; width:100%; border-radius:8px; padding:1.5rem 2rem; box-shadow:0 10px 25px rgba(15,23,42,0.10); }
        h1 { margin:0 0 0.25rem; font-size:1.6rem; }
        p.subtitle { margin:0 0 1.5rem; color:#6b7280; font-size:0.9rem; }
        label { display:block; font-size:0.85rem; margin-bottom:0.25rem; color:#374151; }
        input { width:100%; padding:0.55rem 0.7rem; border-radius:6px; border:1px solid #d1d5db; font-size:0.9rem; box-sizing:border-box; }
        input:focus { outline:none; border-color:#2563eb; box-shadow:0 0 0 1px rgba(37,99,235,0.2); }
        .field { margin-bottom:0.9rem; }
        .btn { width:100%; border:none; border-radius:6px; padding:0.6rem 0.75rem; background:#2563eb; color:#fff; font-weight:500; cursor:pointer; font-size:0.95rem; }
        .btn:hover { background:#1d4ed8; }
        .muted { margin-top:0.75rem; font-size:0.85rem; color:#6b7280; text-align:center; }
        a { color:#2563eb; text-decoration:none; }
        a:hover { text-decoration:underline; }
        .flash { padding:0.6rem 0.75rem; border-radius:6px; font-size:0.85rem; margin-bottom:0.9rem; }
        .flash-error { background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="card">
        <h1>TeamHub</h1>
        <p class="subtitle">Sign in to manage your teams, projects &amp; tasks.</p>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="flash flash-error">
                <?php echo htmlspecialchars($this->session->flashdata('error'), ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo site_url('login'); ?>">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button class="btn" type="submit">Login</button>
        </form>

        <p class="muted">
            New here?
            <a href="<?php echo site_url('register'); ?>">Create an account</a>
        </p>
    </div>
</div>
</body>
</html>

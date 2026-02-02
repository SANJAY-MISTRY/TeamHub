<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') : 'TeamHub'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif; background:#f3f4f6; margin:0; }
        header { background:#111827; color:#e5e7eb; padding:0.75rem 1.5rem; display:flex; align-items:center; justify-content:space-between; }
        header .brand { font-weight:600; letter-spacing:0.03em; }
        header .user { font-size:0.9rem; }
        header a { color:#e5e7eb; text-decoration:none; font-size:0.85rem; }
        header a:hover { text-decoration:underline; }

        .layout { display:flex; gap:1.5rem; padding:1.5rem; flex-wrap:wrap; }
        .sidebar { flex:0 0 260px; max-width:100%; background:#fff; border-radius:8px; padding:1rem 1.2rem; box-shadow:0 6px 18px rgba(15,23,42,0.08); }
        .content { flex:1 1 320px; min-width:0; }

        h1 { margin-top:0; font-size:1.25rem; }
        h2 { margin-top:0; font-size:1.1rem; margin-bottom:0.75rem; }
        form { margin:0; }
        label { display:block; font-size:0.8rem; margin-bottom:0.25rem; color:#374151; }
        input, select, textarea { width:100%; padding:0.45rem 0.6rem; border-radius:6px; border:1px solid #d1d5db; box-sizing:border-box; font-size:0.85rem; }
        textarea { resize:vertical; min-height:60px; }
        input:focus, select:focus, textarea:focus { outline:none; border-color:#2563eb; box-shadow:0 0 0 1px rgba(37,99,235,0.2); }
        .field { margin-bottom:0.75rem; }
        .btn { border:none; border-radius:6px; padding:0.5rem 0.9rem; background:#2563eb; color:#fff; font-size:0.85rem; cursor:pointer; }
        .btn:hover { background:#1d4ed8; }

        .teams-list { margin-bottom:1rem; }
        .projects-card { background:#fff; border-radius:8px; padding:1rem 1.2rem; box-shadow:0 6px 18px rgba(15,23,42,0.08); }
        .projects-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:0.9rem; margin-top:0.75rem; }
        .project { border:1px solid #e5e7eb; border-radius:8px; padding:0.75rem 0.8rem; background:#fafafa; }
        .project h3 { margin:0 0 0.35rem; font-size:0.98rem; }
        .project p { margin:0 0 0.25rem; font-size:0.8rem; color:#4b5563; }
        .project a { font-size:0.8rem; color:#2563eb; text-decoration:none; }
        .project a:hover { text-decoration:underline; }
        .empty { font-size:0.85rem; color:#6b7280; }

        .page { padding:1.25rem 1.5rem 1.75rem; }
        .page-narrow { max-width:800px; margin:0 auto; }

        .breadcrumbs { font-size:0.8rem; margin-bottom:0.5rem; color:#6b7280; }
        .breadcrumbs a { color:#2563eb; text-decoration:none; }
        .breadcrumbs a:hover { text-decoration:underline; }

        .top { display:flex; flex-wrap:wrap; gap:1rem; align-items:flex-start; margin-bottom:1rem; }
        .summary { background:#fff; padding:0.9rem 1rem; border-radius:8px; box-shadow:0 5px 16px rgba(15,23,42,0.08); flex:1 1 260px; }
        .summary h1 { margin:0 0 0.35rem; font-size:1.2rem; }
        .summary p { margin:0.15rem 0; font-size:0.85rem; color:#4b5563; }
        .new-task { background:#fff; padding:0.9rem 1rem; border-radius:8px; box-shadow:0 5px 16px rgba(15,23,42,0.08); flex:1 1 260px; }

        .board { display:grid; grid-template-columns:repeat(auto-fit,minmax(230px,1fr)); gap:0.9rem; margin-top:1rem; }
        .column { background:#f9fafb; border-radius:8px; padding:0.75rem 0.8rem; border:1px solid #e5e7eb; }
        .column h3 { margin:0 0 0.5rem; font-size:0.95rem; }
        .task { background:#fff; border-radius:6px; padding:0.5rem 0.6rem; margin-bottom:0.5rem; border:1px solid #e5e7eb; }
        .task-title { font-size:0.9rem; font-weight:500; margin-bottom:0.15rem; }
        .task-meta { font-size:0.75rem; color:#6b7280; margin-bottom:0.35rem; }
        .task form { font-size:0.75rem; }
        .task label { font-size:0.72rem; }
        .task select, .task input { font-size:0.75rem; padding:0.3rem 0.4rem; }
        .task .btn { margin-top:0.25rem; padding:0.32rem 0.6rem; font-size:0.75rem; }

        table { width:100%; border-collapse:collapse; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 4px 14px rgba(15,23,42,0.06); margin-bottom:1rem; }
        th, td { padding:0.6rem 0.75rem; font-size:0.85rem; text-align:left; }
        th { background:#f9fafb; border-bottom:1px solid #e5e7eb; }
        tr:nth-child(even) td { background:#f9fafb; }

        .invite-card { background:#fff; border-radius:8px; padding:0.9rem 1rem; box-shadow:0 4px 14px rgba(15,23,42,0.06); }

        .flash { padding:0.6rem 0.75rem; border-radius:6px; font-size:0.85rem; margin-bottom:0.9rem; }
        .flash-error { background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }
        .flash-success { background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; }

        @media (max-width:800px) {
            .layout { flex-direction:column; }
            .sidebar { flex:1 1 auto; }
        }
    </style>
</head>
<body>
<header>
    <div class="brand">TeamHub</div>
    <div class="user">
        <?php if (isset($user['name'])): ?>
            <?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?>
            &middot;
            <a href="<?php echo site_url('logout'); ?>">Logout</a>
        <?php endif; ?>
    </div>
</header>

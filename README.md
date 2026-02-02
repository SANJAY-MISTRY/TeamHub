# TeamHub – Collaborative Project Tracker (CodeIgniter 3)

I built with **CodeIgniter 3** and **MySQL**.

---

## 1. Setup Instructions

### Prerequisites

- PHP 8.1+
- Composer
- MySQL (or XAMPP/MAMP with MySQL enabled)

### 1.1 Install dependencies

If you ever need to reinstall:

```bash
composer install
```

### 1.2 Configure base URL & sessions

File: `application/config/config.php`

Already set for local dev:

```php
$config['base_url'] = 'http://localhost:8081/';
$config['encryption_key'] = 'teamhub_ci3_secret_key_2026';
```

### 1.3 Configure database connection

File: `application/config/database.php`

```php
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'      => '',
    'hostname' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'database' => 'teamhub',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE,
);
```

### 1.4 Create database & tables

1. Start MySQL (e.g. XAMPP → MySQL **Start**).
2. Create a database `teamhub` if it does not exist:

```sql
CREATE DATABASE teamhub CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

3. Import schema from `database.sql` into the `teamhub` database.
   - Using phpMyAdmin: select `teamhub` → **Import** → choose `database.sql` → Go.
   - Or MySQL CLI:

```bash
mysql -u root -p teamhub < database.sql
```

This will create the tables:

- `users`
- `teams`
- `team_members`
- `projects`
- `tasks`

### 1.5 Run the app (built-in PHP server)

From the project root (`TeamHub`):

```bash
php -S localhost:8081
```

Then open in your browser:

```text
http://localhost:8081/index.php
```

The default controller is `Auth`, so you will see the **login** page.

### 1.6 Basic usage flow

1. Go to `http://localhost:8081/index.php/register` and create a user account.
2. After registering you are logged in and redirected to `index.php/dashboard`.
3. On the dashboard:
   - Create a **Team** on the left sidebar.
   - Select current team from the dropdown.
4. With a team selected:
   - Create **Projects** for that team.
   - Each project card has a **View tasks** link.
5. In a project page (`index.php/projects/{id}`):
   - Add tasks (title, description, assignee, due date).
   - Tasks are shown in columns: **To Do**, **In Progress**, **Done**.
   - Change status and assignee from the task card and click **Update**.
6. Team members page (`index.php/teams/{id}/members`):
   - View team members.
   - Invite a user by email (mock): if the email does not exist, a user is auto-created and added to the team.

---

## 2. Short architecture overview

- Controllers in `application/controllers` handle the HTTP requests:
  - `Auth` – signup, login, logout.
  - `Dashboard` – lists teams and projects for the selected team.
  - `Teams` – create/switch teams, list members, invite by email (mock).
  - `Projects` – create projects and show a project with its tasks.
  - `Tasks` – create and update tasks.

- Reusable logic sits in small service classes in `application/libraries`:
  - `Auth_service`, `Team_service`, `Project_service`, `Task_service`.

- Database access is grouped in models in `application/models`:
  - `User_model`, `Team_model`, `Project_model`, `Task_model`.

- Logged‑in pages extend `MY_Controller` (`application/core/MY_Controller.php`),
  which reads the current user from the session and redirects to `login` if needed.

- Views in `application/views` render the pages:
  - Auth screens, dashboard, project board and team members.

## 3. Database schema (simple view)

The schema is defined in `database.sql`. Main tables:

- `users` – basic user info and password hash.
- `teams` – team name, description and owner.
- `team_members` – link between users and teams, with a role.
- `projects` – projects that belong to a team.
- `tasks` – tasks that belong to a project, with status/assignee/due date.

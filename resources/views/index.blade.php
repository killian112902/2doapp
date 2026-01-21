<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do HQ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0b1021;
            --panel: rgba(17, 25, 52, 0.72);
            --glass: rgba(255, 255, 255, 0.04);
            --text: #e7ecff;
            --muted: #9db0d9;
            --accent: #7cf3c2;
            --accent-2: #5bc8ff;
            --danger: #ff7b7b;
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
            --radius: 18px;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Space Grotesk', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text);
            background: radial-gradient(circle at 20% 20%, rgba(123, 243, 194, 0.12), transparent 35%),
                        radial-gradient(circle at 80% 10%, rgba(91, 200, 255, 0.18), transparent 40%),
                        linear-gradient(180deg, #050712 0%, #0b1021 60%, #050712 100%);
            padding: 32px;
        }

        .shell {
            width: 100%;
            max-width: 100%;
            margin: 0;
            background: var(--panel);
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: var(--shadow);
            border-radius: 24px;
            overflow: hidden;
            position: relative;
            backdrop-filter: blur(12px);
        }

        .glow {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(circle at 20% 50%, rgba(124, 243, 194, 0.12), transparent 45%),
                        radial-gradient(circle at 80% 30%, rgba(91, 200, 255, 0.12), transparent 45%);
        }

        header {
            padding: 32px 32px 12px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 18px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 999px;
            background: var(--glass);
            color: var(--muted);
            font-size: 12px;
            letter-spacing: 0.3px;
        }

        h1 {
            margin: 8px 0 6px;
            font-size: 32px;
            letter-spacing: -0.6px;
        }

        .lede {
            margin: 0;
            color: var(--muted);
            max-width: 620px;
            line-height: 1.6;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 12px;
            padding: 0 32px 24px;
            position: relative;
            z-index: 1;
        }

        .stat {
            background: var(--glass);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 14px;
            padding: 14px 16px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 12px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .stat-value {
            margin: 6px 0 0;
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .stat-pill {
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 11px;
            background: rgba(124, 243, 194, 0.15);
            color: var(--accent);
            border: 1px solid rgba(124, 243, 194, 0.35);
        }

        main {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 18px;
            padding: 0 32px 32px;
            position: relative;
            z-index: 1;
        }

        .panel {
            background: var(--glass);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: var(--radius);
            padding: 20px;
        }

        form.new-task {
            display: grid;
            gap: 12px;
        }

        label {
            font-size: 13px;
            color: var(--muted);
            letter-spacing: 0.2px;
        }

        input[type="text"], input[type="email"], input[type="password"], input[type="date"], textarea {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.04);
            color: var(--text);
            font-size: 16px;
            transition: border 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        input::placeholder, textarea::placeholder {
            color: var(--muted);
            font-family: 'Space Grotesk', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 15px;
            letter-spacing: 0.1px;
        }

        textarea { min-height: 110px; resize: vertical; }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, input[type="date"]:focus, textarea:focus {
            outline: none;
            border-color: rgba(124, 243, 194, 0.6);
            box-shadow: 0 0 0 4px rgba(124, 243, 194, 0.12);
            transform: translateY(-1px);
        }

        .button {
            padding: 12px 16px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            color: #031017;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
            box-shadow: 0 12px 24px rgba(124, 243, 194, 0.22);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .button:hover { transform: translateY(-1px); box-shadow: 0 14px 26px rgba(124, 243, 194, 0.28); }
        .button:active { transform: translateY(0); box-shadow: 0 10px 18px rgba(124, 243, 194, 0.2); }

        .tasks-panel { display: flex; flex-direction: column; gap: 16px; }

        .task-card {
            border: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(255, 255, 255, 0.02);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 14px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            align-items: flex-start;
            width: 100%;
        }

        .task-title { font-size: 16px; letter-spacing: 0.1px; }
        .task-title.done { color: var(--muted); text-decoration: line-through; text-decoration-thickness: 2px; }

        .task-meta { display: flex; gap: 8px; align-items: center; color: var(--muted); font-size: 12px; }

        .task-details-snippet {
            margin-top: 6px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.4;
            max-height: 3.6em;
            overflow: hidden;
        }

        .pill {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            letter-spacing: 0.2px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .pill-success { background: rgba(124, 243, 194, 0.14); color: var(--accent); border-color: rgba(124, 243, 194, 0.3); }
        .pill-muted { background: rgba(255, 255, 255, 0.05); color: var(--muted); }
        .pill-danger { background: rgba(255, 123, 123, 0.1); color: #ffc0c0; border-color: rgba(255, 123, 123, 0.35); }

        .task-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; justify-content: flex-end; }

        .task-btn {
            border: none;
            border-radius: 12px;
            padding: 10px 12px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
            color: #031017;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
            box-shadow: 0 8px 18px rgba(124, 243, 194, 0.2);
        }

        .task-btn.secondary {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.12);
        }

        .task-btn.danger {
            background: linear-gradient(135deg, #ffb3b3 0%, #ff6b6b 100%);
            color: #2b0c0c;
            box-shadow: 0 8px 18px rgba(255, 107, 107, 0.25);
        }

        .task-btn:hover { transform: translateY(-1px); opacity: 0.95; }
        .task-btn:active { transform: translateY(0); opacity: 1; box-shadow: none; }

        .task-btn .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            margin-right: 0;
        }

        .empty {
            text-align: center;
            padding: 26px;
            color: var(--muted);
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed rgba(255, 255, 255, 0.12);
            border-radius: 14px;
        }

        .progress-bar {
            height: 8px;
            width: 100%;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 999px;
            overflow: hidden;
            margin-top: 8px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent) 0%, var(--accent-2) 100%);
            width: 0;
            transition: width 0.35s ease;
        }

        @media (max-width: 900px) {
            main { grid-template-columns: 1fr; }
            header { grid-template-columns: 1fr; }
            .shell { margin: 0 8px; }
        }

        @media (max-width: 720px) {
            body { padding: 18px; }
            header, .stats, main { padding-left: 16px; padding-right: 16px; }
            h1 { font-size: 26px; }
            .lede { font-size: 15px; }
            .task-card { grid-template-columns: 1fr; }
            .task-actions { width: 100%; justify-content: flex-start; flex-wrap: wrap; }
            .task-actions form { width: 100%; }
            .task-actions .task-btn { width: 100%; text-align: center; }
            .stats { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); }
        }

        @media (max-width: 480px) {
            body { padding: 14px; }
            header, .stats, main { padding-left: 12px; padding-right: 12px; }
            .shell { border-radius: 18px; }
            .panel { padding: 16px; }
            input[type="text"], input[type="email"], input[type="password"], input[type="date"] { font-size: 15px; }
            .button { width: 100%; text-align: center; }
            .task-meta { flex-wrap: wrap; }
            .task-card { padding: 12px; }
        }

        .toast-stack { position: fixed; top: 16px; right: 16px; display: grid; gap: 10px; z-index: 9999; }
        .toast { min-width: 260px; padding: 12px 14px; border-radius: 12px; border: 1px solid rgba(124, 243, 194, 0.4); background: rgba(17, 25, 52, 0.9); color: var(--text); box-shadow: var(--shadow); opacity: 0; transform: translateY(-8px); transition: opacity 0.25s ease, transform 0.25s ease; }
        .toast.show { opacity: 1; transform: translateY(0); }
        .avatar-small { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.1); }

        .modal-shell {
            position: fixed;
            inset: 0;
            background: rgba(5, 7, 18, 0.72);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            padding: 16px;
        }

        .modal-shell.active { display: flex; }

        .modal-card {
            background: var(--panel);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            box-shadow: var(--shadow);
            max-width: 560px;
            width: min(560px, 100%);
            padding: 20px;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 12px;
            right: 12px;
            border: none;
            background: rgba(255, 255, 255, 0.06);
            color: var(--text);
            padding: 8px 10px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
        }

        .modal-title { margin: 0 0 8px; font-size: 20px; letter-spacing: -0.2px; }
        .modal-meta { color: var(--muted); font-size: 13px; display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 12px; }
        .modal-body { color: var(--text); line-height: 1.6; white-space: pre-wrap; }

        .modal-form { display: grid; gap: 12px; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 6px; }
        .ghost-btn.secondary { background: rgba(255,255,255,0.06); }

        .header-actions { display: flex; align-items: center; gap: 10px; }

        .nav-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            color: #031017;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
            box-shadow: 0 10px 22px rgba(124, 243, 194, 0.22);
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
        }

        .nav-btn.secondary {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: none;
        }

        .nav-btn.danger {
            background: linear-gradient(135deg, #ffb3b3 0%, #ff6b6b 100%);
            color: #2b0c0c;
            box-shadow: 0 10px 22px rgba(255, 107, 107, 0.28);
        }

        .nav-btn:hover { transform: translateY(-1px); opacity: 0.95; }
        .nav-btn:active { transform: translateY(0); opacity: 1; box-shadow: none; }
    </style>
</head>
<body>

<div class="toast-stack" id="toast-stack">
    @if (session('status'))
        <div class="toast show">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="toast show" style="border-color: rgba(255,123,123,0.6);">{{ $errors->first() }}</div>
    @endif
</div>

@php
    $total = $tasks->count();
    $done = $tasks->where('is_done', true)->count();
    $active = $total - $done;
    $progress = $total ? round(($done / $total) * 100) : 0;
    $compliment = $done >= 3 ? 'You are productive' : 'You are having a good time';
@endphp

<div class="shell">
    <div class="glow"></div>

    <header>
        <div>
            <div class="eyebrow">Focus board · Crafted</div>
            <h1>Plan, act, and finish beautifully.</h1>
            <p class="lede">Stay on top of the work that matters. Capture tasks fast, celebrate progress, and keep momentum with a clear, confident dashboard.</p>
        </div>
        <div class="header-actions">
            <img class="avatar-small" src="{{ $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : 'https://api.dicebear.com/7.x/identicon/svg?seed='.urlencode($user->email) }}" alt="Avatar">
            <a class="nav-btn secondary" href="/settings">Profile</a>
            <form method="POST" action="/logout">
                @csrf
                <button class="nav-btn danger" type="submit">Logout</button>
            </form>
        </div>
    </header>

    <section class="stats">
        <div class="stat">
            <div class="stat-label">Progress</div>
            <div class="stat-value"><span id="stat-progress">{{ $progress }}</span>% <span class="stat-pill"><span id="stat-done">{{ $done }}</span> done</span></div>
            <div class="progress-bar"><div class="progress-fill" id="stat-progress-fill" style="width: {{ $progress }}%"></div></div>
        </div>
        <div class="stat">
            <div class="stat-label">Open tasks</div>
            <div class="stat-value"><span id="stat-active">{{ $active }}</span> <span class="stat-pill">Now</span></div>
        </div>
        <div class="stat">
            <div class="stat-label">All tasks</div>
            <div class="stat-value"><span id="stat-total">{{ $total }}</span> <span class="stat-pill">Total</span></div>
        </div>
        <div class="stat">
            <div class="stat-label">Today</div>
            <div class="stat-value" id="stat-compliment">{{ $compliment }}</div>
            <div class="progress-bar"><div class="progress-fill" id="stat-compliment-fill" style="width: {{ min(100, ($done/3)*100) }}%"></div></div>
        </div>
    </section>

    <main>
        <aside class="panel">
            <h3 style="margin: 0 0 12px; letter-spacing: -0.3px;">Add something new</h3>
            <p style="margin: 0 0 16px; color: var(--muted);">Capture a quick thought and send it to the board.</p>
            <form class="new-task" method="POST" action="/tasks">
                @csrf
                <label for="title">Task title</label>
                <input id="title" type="text" name="title" placeholder="Ship landing page animation" required>
                <label for="details">Details (optional)</label>
                <textarea id="details" name="details" placeholder="Add steps, context, or links"></textarea>
                <label for="deadline">Deadline (optional)</label>
                <input id="deadline" type="date" name="deadline">
                <button class="button" type="submit">Add to board</button>
            </form>
        </aside>

        <section class="panel tasks-panel" id="tasks-container">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px; gap: 10px; flex-wrap: wrap;">
                <h3 style="margin:0; letter-spacing:-0.3px;">Tasks</h3>
                <span class="pill pill-muted" id="tasks-count">{{ $total ? $total : 'No' }} item{{ $total === 1 ? '' : 's' }}</span>
            </div>

            <div id="tasks-list">
                @forelse ($tasks as $task)
                    <article class="task-card task-openable"
                        data-title="{{ e($task->title) }}"
                        data-details="{{ e($task->details ?? '') }}"
                        data-created="{{ $task->created_at?->format('M d, Y') }}"
                        data-deadline="{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('M d, Y') : '' }}"
                        data-deadline-raw="{{ $task->deadline ?? '' }}"
                        data-id="{{ $task->id }}"
                        data-status="{{ $task->is_done ? 'Completed' : 'In progress' }}">
                        <div>
                            <div class="task-title {{ $task->is_done ? 'done' : '' }}">{{ $task->title }}</div>
                            <div class="task-meta">
                                <span class="pill {{ $task->is_done ? 'pill-success' : 'pill-muted' }}">{{ $task->is_done ? 'Completed' : 'In progress' }}</span>
                                <span>Task #{{ $loop->iteration }}</span>
                                <span>{{ $task->created_at?->format('M d, Y') }}</span>
                                @if($task->deadline)
                                      <span class="pill pill-muted">Due {{ \Carbon\Carbon::parse($task->deadline)->format('M d, Y') }}</span>
                                @endif
                            </div>
                            @if($task->details)
                                <div class="task-details-snippet">{{ \Illuminate\Support\Str::limit($task->details, 150) }}</div>
                            @endif
                        </div>
                        <div class="task-actions">
                            <button class="task-btn secondary" type="button" data-edit-id="{{ $task->id }}" title="Edit task" aria-label="Edit task">
                                <span class="icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                    </svg>
                                </span>
                            </button>
                            <form action="/tasks/{{ $task->id }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="task-btn" type="submit" title="{{ $task->is_done ? 'Mark active' : 'Mark done' }}" aria-label="{{ $task->is_done ? 'Mark active' : 'Mark done' }}">
                                    <span class="icon" aria-hidden="true">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m5 13 4 4L19 7" />
                                        </svg>
                                    </span>
                                </button>
                            </form>
                            <form action="/tasks/{{ $task->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="task-btn danger" type="submit" title="Delete" aria-label="Delete">
                                    <span class="icon" aria-hidden="true">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                        </svg>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="empty">No tasks yet. Add your first focus item.</div>
                @endforelse
            </div>
        </section>
    </main>
</div>

<div class="modal-shell" id="task-modal">
    <div class="modal-card">
        <button class="modal-close" id="task-modal-close" aria-label="Close">×</button>
        <div class="modal-title" id="modal-title"></div>
        <div class="modal-meta">
            <span id="modal-status"></span>
            <span id="modal-created"></span>
            <span id="modal-deadline"></span>
        </div>
        <div class="modal-body" id="modal-details"></div>
    </div>
</div>

<div class="modal-shell" id="edit-modal">
    <div class="modal-card">
        <button class="modal-close" id="edit-modal-close" aria-label="Close">×</button>
        <h3 style="margin:0 0 10px;">Edit task</h3>
        <form class="modal-form" id="edit-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="task_id" id="edit-task-id">
            <div>
                <label for="edit-title">Title</label>
                <input id="edit-title" name="title" type="text" required>
            </div>
            <div>
                <label for="edit-details">Details</label>
                <textarea id="edit-details" name="details" placeholder="Add steps, context, or links"></textarea>
            </div>
            <div>
                <label for="edit-deadline">Deadline</label>
                <input id="edit-deadline" name="deadline" type="date">
            </div>
            <div class="modal-actions">
                <button type="button" class="task-btn secondary" id="edit-cancel">
                    <span class="icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m18 6-12 12" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </span>
                    Cancel
                </button>
                <button type="submit" class="button">Save changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach((toast) => {
        setTimeout(() => toast.classList.add('show'), 50);
        setTimeout(() => toast.classList.remove('show'), 3200);
    });

    // Lightweight polling for near real-time updates without websockets
    const tasksListEl = document.getElementById('tasks-list');
    const tasksCountEl = document.getElementById('tasks-count');
    const statProgress = document.getElementById('stat-progress');
    const statDone = document.getElementById('stat-done');
    const statActive = document.getElementById('stat-active');
    const statTotal = document.getElementById('stat-total');
    const statCompliment = document.getElementById('stat-compliment');
    const statProgressFill = document.getElementById('stat-progress-fill');
    const statComplimentFill = document.getElementById('stat-compliment-fill');
    const csrfToken = '{{ csrf_token() }}';

    function escapeHtml(str) {
        return str.replace(/[&<>"']/g, (c) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[c]));
    }

    function renderTasks(tasks) {
        if (!tasks.length) {
            tasksListEl.innerHTML = '<div class="empty">No tasks yet. Add your first focus item.</div>';
            return;
        }

        const html = tasks.map((task, idx) => {
            const statusClass = task.is_done ? 'pill-success' : 'pill-muted';
            const statusText = task.is_done ? 'Completed' : 'In progress';
            const titleClass = task.is_done ? 'task-title done' : 'task-title';
            const deadline = task.deadline ? `<span class="pill pill-muted">Due ${task.deadline}</span>` : '';
            const detailsSnippet = task.details ? `<div class="task-details-snippet">${escapeHtml(task.details).slice(0, 150)}${task.details.length > 150 ? '…' : ''}</div>` : '';
            return `
                <article class="task-card task-openable"
                    data-title="${escapeHtml(task.title)}"
                    data-details="${escapeHtml(task.details || '')}"
                    data-created="${task.created_at || ''}"
                    data-deadline="${task.deadline ? task.deadline : ''}"
                    data-deadline-raw="${task.deadline ? task.deadline : ''}"
                    data-id="${task.id}"
                    data-status="${statusText}">
                    <div>
                        <div class="${titleClass}">${escapeHtml(task.title)}</div>
                        <div class="task-meta">
                            <span class="pill ${statusClass}">${statusText}</span>
                            <span>Task #${idx + 1}</span>
                            <span>${task.created_at || ''}</span>
                            ${deadline}
                        </div>
                        ${detailsSnippet}
                    </div>
                    <div class="task-actions">
                        <button class="task-btn secondary" type="button" data-edit-id="${task.id}" title="Edit task" aria-label="Edit task">
                            <span class="icon" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                </svg>
                            </span>
                        </button>
                        <form action="/tasks/${task.id}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PATCH">
                            <button class="task-btn" type="submit" title="${task.is_done ? 'Mark active' : 'Mark done'}" aria-label="${task.is_done ? 'Mark active' : 'Mark done'}">
                                <span class="icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m5 13 4 4L19 7" />
                                    </svg>
                                </span>
                            </button>
                        </form>
                        <form action="/tasks/${task.id}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="task-btn danger" type="submit" title="Delete" aria-label="Delete">
                                <span class="icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                    </svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </article>
            `;
        }).join('');

        tasksListEl.innerHTML = html;
    }

    async function refreshTasks() {
        try {
            const res = await fetch('/tasks/json', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!res.ok) return;
            const data = await res.json();
            const { tasks, stats } = data;

            renderTasks(tasks || []);
            tasksCountEl.textContent = (stats.total ? stats.total : 'No') + ` item${stats.total === 1 ? '' : 's'}`;
            statProgress.textContent = stats.progress;
            statDone.textContent = stats.done;
            statActive.textContent = stats.active;
            statTotal.textContent = stats.total;
            statCompliment.textContent = stats.compliment;
            statProgressFill.style.width = `${stats.progress}%`;
            const complimentFill = Math.min(100, (stats.done / 3) * 100);
            statComplimentFill.style.width = `${complimentFill}%`;
        } catch (e) {
            console.error('Refresh failed', e);
        }
    }

    const modalEl = document.getElementById('task-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalStatus = document.getElementById('modal-status');
    const modalCreated = document.getElementById('modal-created');
    const modalDeadline = document.getElementById('modal-deadline');
    const modalDetails = document.getElementById('modal-details');
    const modalClose = document.getElementById('task-modal-close');

    function openModalFromCard(card) {
        modalTitle.textContent = card.dataset.title || 'Task';
        modalStatus.textContent = card.dataset.status ? `Status: ${card.dataset.status}` : '';
        modalCreated.textContent = card.dataset.created ? `Created: ${card.dataset.created}` : '';
        modalDeadline.textContent = card.dataset.deadline ? `Deadline: ${card.dataset.deadline}` : '';
        const detailsText = card.dataset.details || 'No details provided.';
        modalDetails.textContent = detailsText;
        modalEl.classList.add('active');
    }

    tasksListEl.addEventListener('click', (event) => {
        const isButton = event.target.closest('button');
        const isForm = event.target.closest('form');
        if (isButton || isForm) return;
        const card = event.target.closest('.task-openable');
        if (!card) return;
        openModalFromCard(card);
    });

    modalClose.addEventListener('click', () => modalEl.classList.remove('active'));
    modalEl.addEventListener('click', (event) => {
        if (event.target === modalEl) modalEl.classList.remove('active');
    });

    // Edit modal controls
    const editModal = document.getElementById('edit-modal');
    const editClose = document.getElementById('edit-modal-close');
    const editCancel = document.getElementById('edit-cancel');
    const editForm = document.getElementById('edit-form');
    const editTitle = document.getElementById('edit-title');
    const editDetails = document.getElementById('edit-details');
    const editDeadline = document.getElementById('edit-deadline');
    const editTaskId = document.getElementById('edit-task-id');

    function openEditModal(card) {
        editTaskId.value = card.dataset.id;
        editTitle.value = card.dataset.title || '';
        editDetails.value = card.dataset.details || '';
        editDeadline.value = card.dataset.deadlineRaw || '';
        editModal.classList.add('active');
    }

    function closeEditModal() {
        editModal.classList.remove('active');
    }

    document.addEventListener('click', (event) => {
        const editBtn = event.target.closest('[data-edit-id]');
        if (editBtn) {
            const card = editBtn.closest('.task-openable');
            if (card) {
                openEditModal(card);
            }
        }
    });

    editClose?.addEventListener('click', closeEditModal);
    editCancel?.addEventListener('click', closeEditModal);
    editModal?.addEventListener('click', (event) => {
        if (event.target === editModal) closeEditModal();
    });

    editForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        const id = editTaskId.value;
        if (!id) return;

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('_method', 'PATCH');
        formData.append('title', editTitle.value || '');
        formData.append('details', editDetails.value || '');
        formData.append('deadline', editDeadline.value || '');

        try {
            const res = await fetch(`/tasks/${id}`, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });
            if (res.ok || res.redirected) {
                closeEditModal();
                await refreshTasks();
                return;
            }
            console.error('Edit failed');
        } catch (err) {
            console.error('Edit failed', err);
        }
    });

    // Poll every 8 seconds for near real-time without websockets
    setInterval(refreshTasks, 8000);
</script>

</body>
</html>

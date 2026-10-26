<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Todo App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 40px 16px;
        }
        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 5px 20px #0001;
        }
        h1 { color: #dc2626; }
        form.add { display: flex; gap: 8px; }
        input {
            flex: 1;
            min-width: 0;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }
        button {
            padding: 10px 14px;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
            background: #dc2626;
            color: white;
        }
        .todo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 14px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .completed { text-decoration: line-through; color: #64748b; }
        .actions { display: flex; gap: 6px; }
        .delete { background: #475569; }
        .error { color: #dc2626; }
    </style>
</head>
<body>
<div class="container">
    <h1>Laravel Todo App</h1>
    <p>Three-tier web application — Presentation, Business Logic and Database.</p>

    @if ($errors->any())
        <ul class="error">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form class="add" method="POST" action="/todos">
        @csrf
        <input type="text" name="title" placeholder="Enter a new task" required>
        <button type="submit">Add Task</button>
    </form>

    <h2>My Tasks</h2>

    @forelse ($todos as $todo)
        <div class="todo">
            <span class="{{ $todo->is_completed ? 'completed' : '' }}">
                {{ $todo->title }}
            </span>

            <div class="actions">
                <form method="POST" action="/todos/{{ $todo->id }}/toggle">
                    @csrf
                    <button type="submit">
                        {{ $todo->is_completed ? 'Undo' : 'Complete' }}
                    </button>
                </form>

                <form method="POST" action="/todos/{{ $todo->id }}">
                    @csrf
                    @method('DELETE')
                    <button class="delete" type="submit">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p>No tasks yet. Add your first task above!</p>
    @endforelse
</div>
</body>
</html>

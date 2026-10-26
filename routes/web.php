<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Todo;

Route::get('/', function () {
    $todos = Todo::latest()->get();

    return view('todos', compact('todos'));
});

Route::post('/todos', function (Request $request) {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
    ]);

    Todo::create($validated);

    return redirect('/');
});

Route::post('/todos/{todo}/toggle', function (Todo $todo) {
    $todo->update([
        'is_completed' => !$todo->is_completed,
    ]);

    return redirect('/');
});

Route::delete('/todos/{todo}', function (Todo $todo) {
    $todo->delete();

    return redirect('/');
});

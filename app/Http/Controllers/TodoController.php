<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Requests\UploadTodoRequest;
use App\Http\Resources\TodoCollection;
use App\Http\Resources\TodoResource;
use App\Jobs\SendTodoCreatedMail;
use App\Models\Todo;
use App\Traits\CustomApiResponser;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    use CustomApiResponser;

    public function index()
    {
        $todos = Todo::paginate(10);
        return new TodoCollection($todos, __('messages.todo.index.success'));
    }

    public function store(StoreTodoRequest $request)
    {
        $todo = Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_url' => $request->file_url,
        ]);
        if (!$todo) {
            return $this->errorResponse([], 'Failed to create Todo');
        }
        dispatch(new SendTodoCreatedMail($todo->title));
        return new TodoResource($todo, "Todo created successfuly.");
    }

    public function destroy(Todo $todo)
    {
        $result = $todo->delete();
        if (!$result) {
            $this->errorResponse([], "Failed to delete Todo");
        }
        return $this->successResponse([], 'Todo deleted successfuly');
    }

    public function show(Todo $todo)
    {
        return new TodoResource($todo, "Todo received successfuly.");
    }

    public function update(Todo $todo, UpdateTodoRequest $request)
    {
        $result = $todo->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        if (!$result) {
            return $this->errorResponse([], "Failed to updated Todo");
        }
        return new TodoResource($todo, "Todo updated successfuly.");
    }

    public function upload(UploadTodoRequest $request)
    {
        $file = $request->file('todo_file');
        $result = $file->store('public/pictures');
        if (!$result) {
            return $this->errorResponse([], "File upload failed.");
        }
        return $this->successResponse([
            'todo_file' => env('APP_URL') . ":" . env('APP_PORT') . Storage::url($result)
        ], 'File uploaded successfully.');
    }
}

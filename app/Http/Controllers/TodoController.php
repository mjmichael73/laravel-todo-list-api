<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Requests\UploadTodoRequest;
use App\Http\Resources\TodoCollection;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Traits\CustomApiResponser;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    use CustomApiResponser;

    public function index()
    {
        $todos = Todo::paginate(10);
        return new TodoCollection($todos, 'Todos received successfuly.');
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
        return new TodoResource($todo, "Todo created successfuly.");
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $result = $todo->delete();
        if (!$result) {
            $this->errorResponse([], "Failed to delete Todo");
        }
        return $this->successResponse([], 'Todo deleted successfuly');
    }

    public function show($id)
    {
        $todo = Todo::findOrFail($id);
        return new TodoResource($todo, "Todo received successfuly.");
    }

    public function update($id, UpdateTodoRequest $request)
    {
        $todo = Todo::findOrFail($id);
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

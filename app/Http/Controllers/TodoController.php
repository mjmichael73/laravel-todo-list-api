<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoCollection;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Traits\CustomApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    use CustomApiResponser;

    public function index()
    {
        $todos = Todo::paginate(10);
        return new TodoCollection($todos, 'Todos received successfuly.');
    }

    public function store(Request $request)
    {
//        $todo = new Todo();
//        $todo->title = $request->title;
//        $todo->description = $request->description;
//        $todo->save();

//        $todo = new Todo();
//        $todo->title = $request->input('title');
//        $todo->description = $request->input('description');
//        $todo->save();
        $todo = Todo::create([
            'title' => $request->title,
            'description' => $request->description
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

    public function update($id, Request $request)
    {
        $todo = Todo::findOrFail($id);
//        $todo->title = $request->title;
//        $todo->description = $request->description;
//        $todo->save();

//        $todo->title = $request->input('title');
//        $todo->description = $request->input('description');
//        $todo->save();

        $result = $todo->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        if (!$result) {
            return $this->errorResponse([], "Failed to updated Todo");
        }
        return new TodoResource($todo, "Todo updated successfuly.");
    }
}

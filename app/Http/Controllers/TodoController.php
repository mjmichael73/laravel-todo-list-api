<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoCollection;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
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
            return response()->json(["message" => "failed"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new TodoResource($todo, "Todo created successfuly.");
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $result = $todo->delete();
        if (!$result) {
            return response()->json(["message" => "failed"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $result = [
            'status' => 'success',
            'message' => 'Todo deleted successfuly'
        ];
        return response()->json($result, Response::HTTP_OK);
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
            return response()->json(["message" => "failed"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new TodoResource($todo, "Todo updated successfuly.");
    }
}

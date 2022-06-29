<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return response()->json($todos, Response::HTTP_OK);
    }
}

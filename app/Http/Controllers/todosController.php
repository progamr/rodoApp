<?php
/**
 * Created by PhpStorm.
 * User: shiftdeveloper
 * Date: 16/12/15
 * Time: 11:01 ص
 */

namespace App\Http\Controllers;

use App\Http\Requests\addTodoRequest;
use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class todosController extends Controller
{
    /**
     * get all todos
     * @return Collection
     */
    public function index(){

        return Todo::all();

    }

    public function show($id){
        try {
            $todo = Todo::findOrFail($id);
            return $todo;
        }
        catch(ModelNotFoundException $e){
            return   Response::json(['flag' => -1]);
        }

    }

    public function store(){
        $validation = Validator::make(Input::all(), [
            'title' =>'required',
            'body'    =>'required',
        ]);
        if($validation->fails()){
        return   Response::json(['flag' => 0, 'message' =>'todo not added', 'errors' => $validation->messages()]);
        }
        else {
            $todo = Todo::create(['title' => Input::get('title'), 'body' => Input::get('body')]);
            return   Response::json(['message' =>'todo added susseccfully']);
        }
    }

    public function update(){
        $validation = Validator::make(Input::all(), [
            'title' =>'required',
            'body'    =>'required',
        ]);
        if($validation->fails()){
            return   Response::json(['flag' => 0, 'message' =>'todo not updated', 'errors' => $validation->messages()]);
        }
        else {
            try {
                $todo = Todo::findOrFail(Input::get('id'));
                $todo->title = Input::get('title');
                $todo->body = Input::get('body');
                $todo->save();
                return   Response::json(['message' =>'todo updated susseccfully']);
            }
            catch(ModelNotFoundException $e){
                return   Response::json(['flag' => -1]);

            }
        }
    }

    public function delete($id){
        try {
            $todo = Todo::findOrFail($id);
            $todo->delete();
            return   Response::json(['message' =>'todo deleted susseccfully']);
        }
        catch(ModelNotFoundException $e){
            return   Response::json(['flag' => -1]);

        }
    }
}
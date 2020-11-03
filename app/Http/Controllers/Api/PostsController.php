<?php

namespace App\Http\Controllers\Api;

use App\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Получение списка постов пользователя
     *
     * @return Response
     */
    public function index()
    {
        $posts = Posts::where("user_id", Auth::user()->id)->get();
        return $posts;
    }

    /**
     * Добавления поста пользователю
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'post' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors()->all(), 452);
        }

        $post_id = Posts::create([
            "name" => $request["name"],
            "post" => $request["post"],
            "user_id" => Auth::user()->id
        ])->id;

        return $post_id;
    }

    /**
     * Получение поста по идентификатору
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors()->all(), 452);
        }

        $post = Posts::where("user_id", Auth::user()->id)->find($request->id);
        return $post;
    }

    /**
     * Изменение поста
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'required',
            'post' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors()->all(), 452);
        }

        Posts::where("id", $request->id)
            ->where("user_id", Auth::user()->id)
            ->update([
                "name" => $request["name"],
                "post" => $request["post"],
            ]);

        return response()->json("success", 200);
    }

    /**
     * Удаление поста
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors()->all(), 452);
        }

        Posts::where("id", $request->id)
            ->where("user_id", Auth::user()->id)
            ->delete();

        return response()->json("success", 200);
    }
}

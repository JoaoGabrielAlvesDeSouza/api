<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Controller {
    public function register (Request $request) {
        try {
            $request->validate ([
                "name"=>"string|required|max:100|min:3",
                "surname"=>"string|required|max:100|min:3",
                "password"=>"string|required|min:8",
                "email"=>"string|required|unique:users",
                "description"=>"string|required|min:10",
                "tags"=>"array",
            ]);
            $usuario = $request->all();
            $usuario["password"]=Hash::make($usuario["password"]);
            User::create($usuario);

            return response()->json([ "message"=>"Usuário Criado"]);
        } catch (Exception $exception) {
            return response()->json($exception->__toString(), 400);
        }
    }

    public function login (Request $request) {
        try {
            $request->validate ([
                "email"=>"string|required",
                "password"=>"required|string|min:8"
            ]);

            if (!Auth::attempt($request->only("email", "password")))
                return response()->json([ "message"=>"Unauthorized" ], 401);

            $token = $request->user()->createToken("auth_token")->plainTextToken;

            return response()->json([ "access_token"=>$token, "token_type"=>"Bearer", "is_admin"=>$request->user()->admin ]);
        } catch (Exception $exception) {
            return response()->json($exception->__toString(), 400);
        }
    }

    public function template (Request $request) {
        try {
            $user = $request->user();
            $request->validate([
                "template"=>"string|required"
            ]);

            if ($request->has("template"))
                $user->template = $request->template;

            $user->save();

            return response()->json([ "message"=>"Template Salvo" ]);

        } catch (Exception $exception) {
            return response()->json($exception->__toString(), 400);
        }
    }

    public function profile (Request $request) {
        try {
            $user = $request->user();
            $request->validate ([
                "name"=>"string|required|min:3|max:100",
                "surname"=>"string|required|min:3|max:100",
                "description"=>"string|required|min:10|max:500",
                "avatar" => "string"
            ]);

            if ($request->has("name"))
                $user->name = $request->name;

            if ($request->has("surname"))
                $user->surname = $request->surname;

            if ($request->has("description"))
                $user->description = $request->description;

            if ($request->has("avatar"))
                $user->avatar = $request->avatar;

            $user->save();

            return response()->json([ "message"=>"Perfil Atualizado" ]);

        } catch (Exception $exception) {
            return response()->json($exception->__toString(), 400);
        }
    }

    public function index () {
        return response()->json(User::all());
    }

    public function updateStatus (Request $request, $id) {
        try {
            $user = User::findOrFail($id);
            $user->status=true;
            $user->save();

            return response()->json([ "message"=>"Status do Usuário Atualizado" ], 200);
        } catch (Exception $exception) {
            return response()->json($exception->__toString(), 400);
        }
    }

    public function getProfile (Request $request) {
        try {
            return response()->json($request->user(), 200);
        } catch (Exception $exception) {
            return response()->json($exception->__toString(), 400);
        }
    }

    public function deleteUser (Request $request, $id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([ "Usuário Deletado" ], 200);
        } catch (Exception $exception) {
            return response()->json($exception->__toString(), 400);
        }
    }

    public function buscarOngs (Request $request) {
        try {
            $query = User::select();
            if ($request->has("search")) {
                $query->select("id", "name", "surname", "description", "template");

                // Agrupar as condições OR
                $query->where("status", "=", true)
                      ->where(function($query) use ($request) {
                          $query->orWhere("name", "like", "%".$request->search."%")
                                ->orWhere("surname", "like", "%".$request->search."%")
                                ->orWhere("description", "like", "%".$request->search."%");
                      });

                $users = $query->get();

                return response()->json($users, 200);
            }
            return response()->json([ "Nenhum Usuário encontrado" ], 404);

        } catch (Exception $exception) {
            return response()->json($exception->__toString(), 400);
        }
    }

    public function buscarPorId (Request $request, $id) {
        try {
            $user = User::findOrFail ($id);

            return response()->json([ "template"=>$user->template], 200);
        } catch (Exception $exception) {
            return response()->json($exception->__toString(), 400);
        }
    }

    public function searchByTag(Request $request)
    {
        $request->validate([
            'tags' => 'required|array',
            'tags.*' => 'string',
        ]);

        $tags = $request->tags;

        $tagsList = "{" . implode(",", $tags) . "}";

        $users = User::whereRaw("EXISTS (
            SELECT 1 FROM jsonb_array_elements_text(tags) as tag
            WHERE tag = ANY(?::text[])
        )", [$tagsList])->get();

        return response()->json($users);
    }

}

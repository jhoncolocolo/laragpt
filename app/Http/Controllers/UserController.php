<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{

    /**
     * Show All Users
     * @OA\Get (
     *     path="/api/users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="current_page",
     *                 type="integer",
     *                 example="1"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Geraldine Chavez"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="geraldinechavez@example.com"
     *                     ),
     *                     @OA\Property(
     *                         property="image_path",
     *                         type="string",
     *                         example="https://randomuser.me/api/portraits/women/23.jpg"
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="first_page_url",
     *                 type="string",
     *                 example="http://127.0.0.1:8000/api/users?page=1"
     *             ),
     *             @OA\Property(
     *                 property="last_page_url",
     *                 type="string",
     *                 example="http://127.0.0.1:8000/api/users?page=3"
     *             ),
     *             @OA\Property(
     *                 property="next_page_url",
     *                 type="string",
     *                 example="http://127.0.0.1:8000/api/users?page=2"
     *             ),
     *             @OA\Property(
     *                 property="prev_page_url",
     *                 type="string",
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="per_page",
     *                 type="integer",
     *                 example="10"
     *             ),
     *             @OA\Property(
     *                 property="total",
     *                 type="integer",
     *                 example="24"
     *             )
     *         )
     *     )
     * )
     */
    public function index(IndexRequest $request)
    {
        $page = $request->query('page', 1);

        $data = \UserService::all($page);

        // Check if a page was requested beyond the limit
        if ($page > $data->lastPage()) {
            return response()->json(['message' => 'The requested page is beyond the limit'], 400);
        }

        if ($data->isEmpty()) {
            return response()->json(['message' => 'Not found Registries'], 404);
        }

        return response()->json($data, 200);
    }


    /**
     * Show Specific User
     * @OA\Get (
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Geraldine Chavez"),
     *              @OA\Property(property="email", type="string", example="geraldinechavez@example.com"),
     *              @OA\Property(property="image_path", type="string", example="https://randomuser.me/api/portraits/women/23.jpg"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No exists user with id : #"),
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        $user = \UserService::find($id);
        if (!$user) {
            return response()->json(['message' => 'No exists user with id : ' . $id], 404);
        }
        return response()->json($user);
    }

    /**
     * Almacena un nuevo usuario en el sistema.
     * @OA\Post (
     *     path="/api/users",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario creado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Record Entered Successfully"),
     *             @OA\Property(property="last_insert_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Validation exception",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Validation exception"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(UserRequest $request)
     {
       //Save users
       $user = \UserService::store($request);
       $data = [];
       if ($user) {
           $data['successful'] = true;
           $data['message'] = 'Record Entered Successfully';
           $data['last_insert_id'] = $user->id;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Entered Successfully';
       }
       return response()->json($data);
  }

    /**
     * Update Exist User in Database
     * @OA\Put (
     *     path="/api/users/{user}",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID del usuario a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Record Update Successfully"),
     *             @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Validation exception",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Validation exception"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function update($user,UserRequest $request)
     {
       //Update users
       $user = \UserService::update($user, $request);
       $data = [];
       if ($user) {
           $data['successful'] = true;
           $data['message'] = 'Record Update Successfully';
           $data['created_at'] = $user;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Update Successfully';
       }
       return response()->json($data);
    }

    /**
     * Remove User From System
     * @OA\Delete (
     *     path="/api/users/{user}",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID del usuario a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Record Delete Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     )
     * )
     */
    public function destroy($user)
     {
       //Delete users
       $user = \UserService::destroy($user);
       $data = [];
       if ($user) {
           $data['successful'] = true;
           $data['message'] = 'Record Delete Successfully';

       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Delete Successfully';
       }
       return response()->json($data);
    }

    /**
     * Generate Massive
     *
     * @return  \Illuminate\Http\Response
     */
    public function massiveGenerator(Request $request)
    {
        $data = [];
        DB::beginTransaction();
        try {

            $jsonData = \GptService::generateSeeders($request['message']);
            foreach ($jsonData as $item) {
                \UserService::store($item);
                $data['message'] = 'Records Created Successfully';
                $data['status'] = 200;
                DB::commit();
            }
        } catch (Exception $e) {
            $data['status'] = 500;
            $data['message'] = 'Error creating data: ' . $e->getMessage();
            DB::rollback();
        }
        return response()->json($data);
    }
}

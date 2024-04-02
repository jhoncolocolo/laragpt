<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\ProgramRequest;


class ProgramController extends Controller
{
     /**
     * Show All Programs
     * @OA\Get (
     *     path="/api/programs",
     *     tags={"Programs"},
     *     @OA\Response(
     *         response=200,
     *         description="List of Programs",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page",type="integer",example="1"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="title",type="string",example="My title"),
     *                     @OA\Property(property="start_date",type="string",example="My Start Date"),
     *                     @OA\Property(property="end_date",type="string", example="My End Date"),
     *                     @OA\Property(property="user_id",type="integer",example="1")
     *                 )
     *             ),
     *             @OA\Property(property="first_page_url", type="string", example="http://127.0.0.1:8000/api/programs?page=1"),
     *             @OA\Property( property="last_page_url",type="string",example="http://127.0.0.1:8000/api/programs?page=3"),
     *             @OA\Property( property="next_page_url",type="string", example="http://127.0.0.1:8000/api/programs?page=2"),
     *             @OA\Property(property="prev_page_url",type="string",example=null),
     *             @OA\Property(property="per_page",type="integer",example="10"),
     *             @OA\Property(property="total",type="integer",example="24")
     *         )
     *     )
     * )
     */
    public function index(IndexRequest $request)
    {
        $page = $request->query('page', 1);

        $data = \ProgramService::all($page);

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
     * Show Specific Program
     * @OA\Get (
     *     path="/api/programs/{id}",
     *     tags={"Programs"},
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
     *            @OA\Property(property="id",type="integer",example="1"),
     *            @OA\Property(property="title",type="string",example="My title"),
     *            @OA\Property(property="description",type="string",example="My Description"),
     *            @OA\Property(property="difficulty",type="integer", example="3"),
     *            @OA\Property(property="user_id",type="integer",example="10")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No exists program with id : #"),
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        $program = \ProgramService::find($id);
        return response()->json($program);
    }

    /**
     * Almacena un nuevo program en el sistema.
     * @OA\Post (
     *     path="/api/programs",
     *     tags={"Programs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title","description","start_date","end_date","user_id"},
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="title",type="string",example="My title"),
     *                     @OA\Property(property="start_date",type="string",example="My Start Date"),
     *                     @OA\Property(property="end_date",type="string", example="My End Date"),
     *                     @OA\Property(property="user_id",type="integer",example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program creado exitosamente",
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
    public function store(ProgramRequest $request)
     {
       //Save programs
       $program = \ProgramService::store($request);
       $data = [];
       if ($program) {
           $data['successful'] = true;
           $data['message'] = 'Record Entered Successfully';
           $data['last_insert_id'] = $program->id;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Entered Successfully';
       }
       return response()->json($data);
  }

    /**
     * Update Exist Program in Database
     * @OA\Put (
     *     path="/api/programs/{program}",
     *     tags={"Programs"},
     *     @OA\Parameter(
     *         name="program",
     *         in="path",
     *         description="ID del program a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title","description","start_date","end_date","user_id"},
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="title",type="string",example="My title"),
     *                     @OA\Property(property="start_date",type="string",example="My Start Date"),
     *                     @OA\Property(property="end_date",type="string", example="My End Date"),
     *                     @OA\Property(property="user_id",type="integer",example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Record Update Successfully"),
     *             @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Program no encontrado"
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
    public function update($program,ProgramRequest $request)
     {
       //Update programs
       $program = \ProgramService::update($program, $request);
       $data = [];
       if ($program) {
           $data['successful'] = true;
           $data['message'] = 'Record Update Successfully';
           $data['created_at'] = $program;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Update Successfully';
       }
       return response()->json($data);
    }

    /**
     * Remove Program From System
     * @OA\Delete (
     *     path="/api/programs/{program}",
     *     tags={"Programs"},
     *     @OA\Parameter(
     *         name="program",
     *         in="path",
     *         description="ID del program a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program eliminado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Record Delete Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Program no encontrado"
     *     )
     * )
     */
    public function destroy($program)
     {
       //Delete programs
       $program = \ProgramService::destroy($program);
       $data = [];
       if ($program) {
           $data['successful'] = true;
           $data['message'] = 'Record Delete Successfully';

       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Delete Successfully';
       }
       return response()->json($data);
    }
}

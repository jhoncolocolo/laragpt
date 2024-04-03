<?php

namespace App\Http\Docs;

use App\Http\Requests\IndexRequest;
use App\Http\Requests\ProgramRequest;
use OpenApi\Attributes as OA;

class ProgramDocs
{
    /**
    * Show All Programs
    * @OA\Get (
    *     path="/api/programs",
    *     tags={"Programs"},
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Número de página",
    *         required=false,
    *         @OA\Schema(type="integer", default=1)
    *     ),
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
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="The requested page is beyond the limit"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Not found Registries"
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
   public function index(IndexRequest $request) {}

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
    public function show($id){}

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
    public function store(ProgramRequest $request){}

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
    public function update($program,ProgramRequest $request) { }

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
    public function destroy($program) {}
}

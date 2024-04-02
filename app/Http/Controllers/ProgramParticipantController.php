<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\ProgramParticipantRequest;

class ProgramParticipantController extends Controller
{
     /**
     * Show All Program Participants
     * @OA\Get (
     *     path="/api/program_participants",
     *     tags={"Program Participants"},
     *     @OA\Response(
     *         response=200,
     *         description="List of ProgramParticipants",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page",type="integer",example="1"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="program_id",type="integer",example="My Program Id"),
     *                     @OA\Property(property="entity_type",type="string",example="My Entity Type any One of this 'App\Models\User', 'App\Models\Challenge', 'App\Models\Company'"),
     *                     @OA\Property(property="entity_id",type="integer", example="My Entity Id")
     *                 )
     *             ),
     *             @OA\Property(property="first_page_url", type="string", example="http://127.0.0.1:8000/api/program_participants?page=1"),
     *             @OA\Property( property="last_page_url",type="string",example="http://127.0.0.1:8000/api/program_participants?page=3"),
     *             @OA\Property( property="next_page_url",type="string", example="http://127.0.0.1:8000/api/program_participants?page=2"),
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

        $data =\ProgramParticipantService::all($page);

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
     * Show Specific Program Participant
     * @OA\Get (
     *     path="/api/program_participants/{id}",
     *     tags={"Program Participants"},
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
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="program_id",type="integer",example="My Program Id"),
     *                     @OA\Property(property="entity_type",type="string",example="My Entity Type any One of this 'App\Models\User', 'App\Models\Challenge', 'App\Models\Company'"),
     *                     @OA\Property(property="entity_id",type="integer", example="My Entity Id")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No exists Program Participant with id : #"),
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        $programParticipant = \ProgramParticipantService::find($id);
        return response()->json($programParticipant);
    }

    /**
     * Almacena un nuevo Program Participant en el sistema.
     * @OA\Post (
     *     path="/api/program_participants",
     *     tags={"Program Participants"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"program_id","entity_type","entity_id"},
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="program_id",type="integer",example="My Program Id"),
     *                     @OA\Property(property="entity_type",type="string",example="My Entity Type any One of this 'App\Models\User', 'App\Models\Challenge', 'App\Models\Company'"),
     *                     @OA\Property(property="entity_id",type="integer", example="My Entity Id")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program Participant creado exitosamente",
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
    public function store(ProgramParticipantRequest $request)
     {
       //Save programParticipants
       $programParticipant = \ProgramParticipantService::store($request);
       $data = [];
       if ($programParticipant) {
           $data['successful'] = true;
           $data['message'] = 'Record Entered Successfully';
           $data['last_insert_id'] = $programParticipant->id;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Entered Successfully';
       }
       return response()->json($data);
  }

    /**
     * Update Exist Program Participant in Database
     * @OA\Put (
     *     path="/api/program_participants/{program_participant}",
     *     tags={"Program Participants"},
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
     *            required={"program_id","entity_type","entity_id"},
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="program_id",type="integer",example="My Program Id"),
     *                     @OA\Property(property="entity_type",type="string",example="My Entity Type any One of this 'App\Models\User', 'App\Models\Challenge', 'App\Models\Company'"),
     *                     @OA\Property(property="entity_id",type="integer", example="My Entity Id")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program Participant actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Record Update Successfully"),
     *             @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Program Participant no encontrado"
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
    public function update($programParticipant,ProgramParticipantRequest $request)
     {
       //Update programParticipants
       $programParticipant = \ProgramParticipantService::update($programParticipant, $request);
       $data = [];
       if ($programParticipant) {
           $data['successful'] = true;
           $data['message'] = 'Record Update Successfully';
           $data['created_at'] = $programParticipant;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Update Successfully';
       }
       return response()->json($data);
    }

    /**
     * Remove Program Participant From System
     * @OA\Delete (
     *     path="/api/program_participants/{program_participant}",
     *     tags={"Program Participants"},
     *     @OA\Parameter(
     *         name="program_participant",
     *         in="path",
     *         description="ID del program_participant a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program Participant eliminado exitosamente",
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
    public function destroy($programParticipant)
     {
       //Delete programParticipants
       $programParticipant = \ProgramParticipantService::destroy($programParticipant);
       $data = [];
       if ($programParticipant) {
           $data['successful'] = true;
           $data['message'] = 'Record Delete Successfully';

       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Delete Successfully';
       }
       return response()->json($data);
    }
}

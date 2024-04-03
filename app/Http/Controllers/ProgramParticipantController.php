<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\ProgramParticipantRequest;
use App\Http\Docs\ProgramParticipantDocs;

/**
    * @OA\Tag(name="Program Participants", description="Operations related to the Programs")
*/
class ProgramParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param    \App\Models\ProgramParticipant  $ProgramParticipant
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        $programParticipant = \ProgramParticipantService::find($id);
        //Validation of not exists model $programParticipant
        if($programParticipant == null){
            return response()->json(['message' => 'No exists Program Participant with id : '.$id], 404);
        }
        return response()->json($programParticipant);
    }

    /*
    * Store ProgramParticipant
    * @return  void
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

    /*
    * Update ProgramParticipant
    * @return  void
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

    /*
    * Delete $programParticipant
    * @return  void
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

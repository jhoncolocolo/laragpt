<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\ProgramRequest;
use App\Http\Docs\ProgramDocs;

/**
    * @OA\Tag(name="Programs", description="Operations related to the Programs")
*/
class ProgramController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param    \App\Models\Program  $Program
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        $program = \ProgramService::find($id);
        //Validation of not exists model $program
        if($program == null){
            return response()->json(['message' => 'No exists program with id : '.$id], 404);
        }
        return response()->json($program);
    }

    /*
    * Store Program
    * @return  void
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

    /*
    * Update Program
    * @return  void
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

    /*
    * Delete $program
    * @return  void
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

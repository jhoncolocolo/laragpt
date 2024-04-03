<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\ChallengeRequest;
use App\Http\Docs\ChallengeDocs;

/**
    * @OA\Tag(name="Challenges", description="Operations related to Challenges")
*/
class ChallengeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $page = $request->query('page', 1);

        $data = \ChallengeService::all($page);

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
     * @param    \App\Models\Challenge  $Challenge
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        $challenge = \ChallengeService::find($id);
        return response()->json($challenge);
    }

    /*
    * Store Challenge
    * @return  void
    */
    public function store(ChallengeRequest $request)
     {
       //Save challenges
       $challenge = \ChallengeService::store($request);
       $data = [];
       if ($challenge) {
           $data['successful'] = true;
           $data['message'] = 'Record Entered Successfully';
           $data['last_insert_id'] = $challenge->id;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Entered Successfully';
       }
       return response()->json($data);
  }

    /*
    * Update Challenge
    * @return  void
    */
    public function update($challenge,ChallengeRequest $request)
     {
       //Update challenges
       $challenge = \ChallengeService::update($challenge, $request);
       $data = [];
       if ($challenge) {
           $data['successful'] = true;
           $data['message'] = 'Record Update Successfully';
           $data['created_at'] = $challenge;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Update Successfully';
       }
       return response()->json($data);
    }

    /*
    * Delete $challenge
    * @return  void
    */
    public function destroy($challenge)
     {
       //Delete challenges
       $challenge = \ChallengeService::destroy($challenge);
       $data = [];
       if ($challenge) {
           $data['successful'] = true;
           $data['message'] = 'Record Delete Successfully';

       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Delete Successfully';
       }
       return response()->json($data);
    }
}

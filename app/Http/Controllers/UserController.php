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
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param    \App\Models\User  $User
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \UserService::find($id);
        return response()->json($user);
    }

    /*
    * Store User
    * @return  void
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

    /*
    * Update User
    * @return  void
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

    /*
    * Delete $user
    * @return  void
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

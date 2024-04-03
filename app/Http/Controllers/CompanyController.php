<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\CompanyRequest;
use App\Http\Docs\CompanyDocs;

/**
    * @OA\Tag(name="Companies", description="Operations related to Companies")
*/
class CompanyController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $page = $request->query('page', 1);

        $data = \CompanyService::all($page);

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
     * @param    \App\Models\Company  $Company
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = \CompanyService::find($id);
        return response()->json($company);
    }

    /*
    * Store Company
    * @return  void
    */
    public function store(CompanyRequest $request)
     {
       //Save companies
       $company = \CompanyService::store($request);
       $data = [];
       if ($company) {
           $data['successful'] = true;
           $data['message'] = 'Record Entered Successfully';
           $data['last_insert_id'] = $company->id;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Entered Successfully';
       }
       return response()->json($data);
  }

    /*
    * Update Company
    * @return  void
    */
    public function update($company,CompanyRequest $request)
     {
       //Update companies
       $company = \CompanyService::update($company, $request);
       $data = [];
       if ($company) {
           $data['successful'] = true;
           $data['message'] = 'Record Update Successfully';
           $data['created_at'] = $company;
       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Update Successfully';
       }
       return response()->json($data);
    }

    /*
    * Delete $company
    * @return  void
    */
    public function destroy($company)
     {
       //Delete companies
       $company = \CompanyService::destroy($company);
       $data = [];
       if ($company) {
           $data['successful'] = true;
           $data['message'] = 'Record Delete Successfully';

       }else{
           $data['successful'] = false;
           $data['message'] = 'Record Not Delete Successfully';
       }
       return response()->json($data);
    }
}

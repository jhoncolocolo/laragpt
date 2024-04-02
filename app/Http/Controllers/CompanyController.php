<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{
    /**
     * Show All Companies
     * @OA\Get (
     *     path="/api/companies",
     *     tags={"Companies"},
     *     @OA\Response(
     *         response=200,
     *         description="List of Companies",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page",type="integer",example="1"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="name",type="string",example="My Name"),
     *                     @OA\Property(property="image_path",type="string",example="https://randomuser.me/api/portraits/women/23.jpg"),
     *                     @OA\Property(property="location",type="string", example="New York, NY"),
     *                     @OA\Property(property="industry",type="string", example="Finance"),
     *                     @OA\Property(property="user_id",type="integer",example="1")
     *                 )
     *             ),
     *             @OA\Property(property="first_page_url", type="string", example="http://127.0.0.1:8000/api/companies?page=1"),
     *             @OA\Property( property="last_page_url",type="string",example="http://127.0.0.1:8000/api/companies?page=3"),
     *             @OA\Property( property="next_page_url",type="string", example="http://127.0.0.1:8000/api/companies?page=2"),
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
     * Show Specific Company
     * @OA\Get (
     *     path="/api/companies/{id}",
     *     tags={"Companies"},
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
     *                     @OA\Property(property="name",type="string",example="My Name"),
     *                     @OA\Property(property="image_path",type="string",example="https://randomuser.me/api/portraits/women/23.jpg"),
     *                     @OA\Property(property="location",type="string", example="New York, NY"),
     *                     @OA\Property(property="industry",type="string", example="Finance"),
     *                     @OA\Property(property="user_id",type="integer",example="1")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No exists company with id : #"),
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        $company = \CompanyService::find($id);
        return response()->json($company);
    }

    /**
     * Almacena un nuevo company en el sistema.
     * @OA\Post (
     *     path="/api/companies",
     *     tags={"Companies"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"name","location","industry","user_id"},
     *                     @OA\Property(property="id",type="integer",example="1"),
     *                     @OA\Property(property="name",type="string",example="My Name"),
     *                     @OA\Property(property="image_path",type="string",example="https://randomuser.me/api/portraits/women/23.jpg"),
     *                     @OA\Property(property="location",type="string", example="New York, NY"),
     *                     @OA\Property(property="industry",type="string", example="Finance"),
     *                     @OA\Property(property="user_id",type="integer",example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Company creado exitosamente",
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

       /**
     * Update Exist Company in Database
     * @OA\Put (
     *     path="/api/companies/{company}",
     *     tags={"Companies"},
     *     @OA\Parameter(
     *         name="company",
     *         in="path",
     *         description="ID del company a actualizar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"name","location","industry","user_id"},
     *            @OA\Property(property="id",type="integer",example="1"),
     *            @OA\Property(property="name",type="string",example="My Name"),
     *            @OA\Property(property="image_path",type="string",example="https://randomuser.me/api/portraits/women/23.jpg"),
     *            @OA\Property(property="location",type="string", example="New York, NY"),
     *            @OA\Property(property="industry",type="string", example="Finance"),
     *            @OA\Property(property="user_id",type="integer",example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Company actualizado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Record Update Successfully"),
     *             @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Company no encontrado"
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

    /**
     * Remove Company From System
     * @OA\Delete (
     *     path="/api/companies/{company}",
     *     tags={"Companies"},
     *     @OA\Parameter(
     *         name="company",
     *         in="path",
     *         description="ID del company a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Company eliminado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Record Delete Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Company no encontrado"
     *     )
     * )
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

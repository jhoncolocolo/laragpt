<?php

namespace App\Repositories\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class CompanyRepository  implements CompanyRepositoryInterface
{
    /**
     *Return all values
     *
     * @return  mixed
    */
    public function all($pageNumber=1)
	{
      return Company::paginate(10, ['*'], 'page', $pageNumber);
    }

    /**
    *Display the specified resource.
     *
     * @return  \Illuminate\Http\Response
   */
   public function show($company)
    {
      return Company::find($company);
   }

   /**
    * Save Company
     *
     * @return  mixed
   */
    public function store($data)
    {
      return Company::create(array(
        'name' => $data['name'],
        'image_path' => $data['image_path'],
        'location' => $data['location'],
        'industry' => $data['industry'],
        'user_id' => $data['user_id'],
        'created_at' => Carbon::now()
      ));
    }

   /**
    *Update Company
     *
     * @return  mixed
   */
   public function update($company,$data)
     {
      //Find Company
      $company = Company::find($company);
      $company->fill(array(
        'name' => $data['name'],
        'image_path' => $data['image_path'],
        'location' => $data['location'],
        'industry' => $data['industry'],
        'user_id' => $data['user_id'],
        'updated_at' => Carbon::now()
      ));
      return $company->save();
   }


   /**
    *Delete Company
     *
     * @return  mixed
   */
   public function destroy($company)
     {
      //Find Company
      $company = Company::find($company);
      return $company->delete();
   }

}

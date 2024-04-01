<?php

namespace App\Services\Company;
use App\Repositories\Company\CompanyRepository;

class CompanyService
{
    /**
    *Return all values
     *
     * @return  mixed
    */
    public function all($pageNumber)
	{
      return (new CompanyRepository())->all($pageNumber);
    }

   /*
    * Get Company By Id
    * @param  $companyId Int
    */
    public function find($companyId)
    {
        return (new CompanyRepository())->show($companyId);
    }

    /*
    * Do Company
    * @param  $data Array
    */
    public function store($data)
    {
        //Save Company
        return (new CompanyRepository())->store($data);
    }

    /*
    * Update Company
    * @param  $companyId Int
    * @param  $data Array
    */
    public function update($companyId, $data)
    {
        //Update Company
        return (new CompanyRepository())->update($companyId, $data);
    }

    /*
    * Delete Company
    * @param  $companyId Int
    */
    public function destroy($companyId)
    {
        //Delete Company
        return (new CompanyRepository())->destroy($companyId);
    }
}

<?php

namespace App\Services\Program;
use App\Repositories\Program\ProgramRepository;

class ProgramService
{
    /**
    *Return all values
     *
     * @return  mixed
    */
    public function all($pageNumber)
	{
      return (new ProgramRepository())->all($pageNumber);
    }

    /**
    *Return all Registries With Detail
     *
     * @return  mixed
    */
    public function allDetails($search)
    {
      return (new ProgramRepository())->allDetails($search);
    }

   /*
    * Get Program By Id
    * @param  $programId Int
    */
    public function find($programId)
    {
        return (new ProgramRepository())->show($programId);
    }

    /*
    * Do Program
    * @param  $data Array
    */
    public function store($data)
    {
        //Save Program
        return (new ProgramRepository())->store($data);
    }

    /*
    * Update Program
    * @param  $programId Int
    * @param  $data Array
    */
    public function update($programId, $data)
    {
        //Update Program
        return (new ProgramRepository())->update($programId, $data);
    }

    /*
    * Delete Program
    * @param  $programId Int
    */
    public function destroy($programId)
    {
        //Delete Program
        return (new ProgramRepository())->destroy($programId);
    }
}

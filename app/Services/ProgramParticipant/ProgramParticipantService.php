<?php

namespace App\Services\ProgramParticipant;
use App\Repositories\ProgramParticipant\ProgramParticipantRepository;

class ProgramParticipantService
{
    /**
    *Return all values
     *
     * @return  mixed
    */
    public function all($pageNumber)
	{
      return (new ProgramParticipantRepository())->all($pageNumber);
    }

    /**
    *Return all Registries With Detail
     *
     * @return  mixed
    */
    public function allDetails($search)
    {
      return (new ProgramParticipantRepository())->allDetails($search);
    }

   /*
    * Get ProgramParticipant By Id
    * @param  $programParticipantId Int
    */
    public function find($programParticipantId)
    {
        return (new ProgramParticipantRepository())->show($programParticipantId);
    }

    /*
    * Do ProgramParticipant
    * @param  $data Array
    */
    public function store($data)
    {
        //Save ProgramParticipant
        return (new ProgramParticipantRepository())->store($data);
    }

    /*
    * Update ProgramParticipant
    * @param  $programParticipantId Int
    * @param  $data Array
    */
    public function update($programParticipantId, $data)
    {
        //Update ProgramParticipant
        return (new ProgramParticipantRepository())->update($programParticipantId, $data);
    }

    /*
    * Delete ProgramParticipant
    * @param  $programParticipantId Int
    */
    public function destroy($programParticipantId)
    {
        //Delete ProgramParticipant
        return (new ProgramParticipantRepository())->destroy($programParticipantId);
    }
}

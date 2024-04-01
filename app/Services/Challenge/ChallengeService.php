<?php

namespace App\Services\Challenge;
use App\Repositories\Challenge\ChallengeRepository;

class ChallengeService
{
    /**
    *Return all values
     *
     * @return  mixed
    */
    public function all($pageNumber)
	{
      return (new ChallengeRepository())->all($pageNumber);
    }

   /*
    * Get Challenge By Id
    * @param  $challengeId Int
    */
    public function find($challengeId)
    {
        return (new ChallengeRepository())->show($challengeId);
    }

    /*
    * Do Challenge
    * @param  $data Array
    */
    public function store($data)
    {
        //Save Challenge
        return (new ChallengeRepository())->store($data);
    }

    /*
    * Update Challenge
    * @param  $challengeId Int
    * @param  $data Array
    */
    public function update($challengeId, $data)
    {
        //Update Challenge
        return (new ChallengeRepository())->update($challengeId, $data);
    }

    /*
    * Delete Challenge
    * @param  $challengeId Int
    */
    public function destroy($challengeId)
    {
        //Delete Challenge
        return (new ChallengeRepository())->destroy($challengeId);
    }
}

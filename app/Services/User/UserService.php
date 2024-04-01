<?php

namespace App\Services\User;
use App\Repositories\User\UserRepository;

class UserService
{
    /**
    *Return all values
     *
     * @return  mixed
    */
    public function all($pageNumber)
	{
      return (new UserRepository())->all($pageNumber);
    }


   /*
    * Get User By Id
    * @param  $userId Int
    */
    public function find($userId)
    {
        return (new UserRepository())->show($userId);
    }

    /*
    * Do User
    * @param  $data Array
    */
    public function store($data)
    {
        //Save User
        return (new UserRepository())->store($data);
    }

    /*
    * Update User
    * @param  $userId Int
    * @param  $data Array
    */
    public function update($userId, $data)
    {
        //Update User
        return (new UserRepository())->update($userId, $data);
    }

    /*
    * Delete User
    * @param  $userId Int
    */
    public function destroy($userId)
    {
        //Delete User
        return (new UserRepository())->destroy($userId);
    }
}

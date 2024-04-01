<?php

namespace App\Repositories\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserRepository  implements UserRepositoryInterface
{
   /**
    *Return all values
     *
     * @return  mixed
   */
   public function all($pageNumber=1)
	 {
      return User::paginate(10, ['*'], 'page', $pageNumber);
   }

    /**
    *Display the specified resource.
     *
     * @return  \Illuminate\Http\Response
   */
   public function show($user)
    {
      return User::find($user);
   }

   /**
    * Save User
     *
     * @return  mixed
   */
    public function store($data)
    {
      return User::create(array(
        'name' => $data['name'],
        'email' => $data['email'],
        'image_path' => $data['image_path'],
        'created_at' => Carbon::now()
      ));
    }

   /**
    *Update User
     *
     * @return  mixed
   */
   public function update($user,$data)
     {
      //Find User
      $user = User::find($user);
      $user->fill(array(
        'name' => $data['name'],
        'email' => $data['email'],
        'image_path' => $data['image_path'],
        'updated_at' => Carbon::now()
      ));
      return $user->save();
   }


   /**
    *Delete User
     *
     * @return  mixed
   */
   public function destroy($user)
     {
      //Find User
      $user = User::find($user);
      return $user->delete();
   }

}

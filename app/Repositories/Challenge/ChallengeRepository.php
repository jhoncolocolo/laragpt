<?php

namespace App\Repositories\Challenge;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Challenge;

class ChallengeRepository  implements ChallengeRepositoryInterface
{
   /**
    *Return all values
     *
     * @return  mixed
   */
   public function all($pageNumber=1)
	 {
      return Challenge::paginate(10, ['*'], 'page', $pageNumber);
   }

    /**
    *Display the specified resource.
     *
     * @return  \Illuminate\Http\Response
   */
   public function show($challenge)
    {
      return Challenge::find($challenge);
   }

   /**
    * Save Challenge
     *
     * @return  mixed
   */
    public function store($data)
    {
      return Challenge::create(array(
        'title' => $data['title'],
        'description' => $data['description'],
        'difficulty' => $data['difficulty'],
        'user_id' => $data['user_id'],
        'created_at' => Carbon::now()
      ));
    }

   /**
    *Update Challenge
     *
     * @return  mixed
   */
   public function update($challenge,$data)
     {
      //Find Challenge
      $challenge = Challenge::find($challenge);
      $challenge->fill(array(
        'title' => $data['title'],
        'description' => $data['description'],
        'difficulty' => $data['difficulty'],
        'user_id' => $data['user_id'],
        'updated_at' => Carbon::now()
      ));
      return $challenge->save();
   }


   /**
    *Delete Challenge
     *
     * @return  mixed
   */
   public function destroy($challenge)
     {
      //Find Challenge
      $challenge = Challenge::find($challenge);
      return $challenge->delete();
   }

}

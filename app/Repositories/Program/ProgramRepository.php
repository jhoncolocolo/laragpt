<?php

namespace App\Repositories\Program;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Program;

class ProgramRepository  implements ProgramRepositoryInterface
{
   /**
    *Return all values
     *
     * @return  mixed
   */
   public function all($pageNumber=1)
	 {
      return Program::paginate(10, ['*'], 'page', $pageNumber);
   }

    /**
    *Display the specified resource.
     *
     * @return  \Illuminate\Http\Response
   */
   public function show($program)
    {
      return Program::find($program);
   }

   /**
    * Save Program
     *
     * @return  mixed
   */
    public function store($data)
    {
      return Program::create(array(
        'title' => $data['title'],
        'description' => $data['description'],
        'start_date' => $data['start_date'],
        'end_date' => $data['end_date'],
        'user_id' => $data['user_id'],
        'created_at' => Carbon::now()
      ));
    }

   /**
    *Update Program
     *
     * @return  mixed
   */
   public function update($program,$data)
     {
      //Find Program
      $program = Program::find($program);
      $program->fill(array(
        'title' => $data['title'],
        'description' => $data['description'],
        'start_date' => $data['start_date'],
        'end_date' => $data['end_date'],
        'user_id' => $data['user_id'],
        'updated_at' => Carbon::now()
      ));
      return $program->save();
   }


   /**
    *Delete Program
     *
     * @return  mixed
   */
   public function destroy($program)
     {
      //Find Program
      $program = Program::find($program);
      return $program->delete();
   }

}

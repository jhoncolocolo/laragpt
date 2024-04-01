<?php

namespace App\Repositories\ProgramParticipant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramParticipant;

class ProgramParticipantRepository  implements ProgramParticipantRepositoryInterface
{
   /**
    *Return all values
     *
     * @return  mixed
   */
   public function all($pageNumber=1)
	 {
      return ProgramParticipant::paginate(10, ['*'], 'page', $pageNumber);
   }

    /**
    *Display the specified resource.
     *
     * @return  \Illuminate\Http\Response
   */
   public function show($programParticipant)
    {
      return ProgramParticipant::find($programParticipant);
   }

   /**
    * Save ProgramParticipant
     *
     * @return  mixed
   */
    public function store($data)
    {
      return ProgramParticipant::create(array(
        'program_id' => $data['program_id'],
        'entity_type' => $data['entity_type'],
        'entity_id' => $data['entity_id'],
        'created_at' => Carbon::now()
      ));
    }

   /**
    *Update ProgramParticipant
     *
     * @return  mixed
   */
   public function update($programParticipant,$data)
     {
      //Find ProgramParticipant
      $programParticipant = ProgramParticipant::find($programParticipant);
      $programParticipant->fill(array(
        'program_id' => $data['program_id'],
        'entity_type' => $data['entity_type'],
        'entity_id' => $data['entity_id'],
        'updated_at' => Carbon::now()
      ));
      return $programParticipant->save();
   }


   /**
    *Delete ProgramParticipant
     *
     * @return  mixed
   */
   public function destroy($programParticipant)
     {
      //Find ProgramParticipant
      $programParticipant = ProgramParticipant::find($programParticipant);
      return $programParticipant->delete();
   }

}

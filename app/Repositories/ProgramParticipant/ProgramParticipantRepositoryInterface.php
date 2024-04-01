<?php

namespace App\Repositories\ProgramParticipant;

interface ProgramParticipantRepositoryInterface {
   public function all($pageNumber);
   public function show($programParticipant);
   public function store($data);
   public function update($programParticipant,$data);
   public function destroy($programParticipant);
}

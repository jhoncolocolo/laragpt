<?php

namespace App\Repositories\Program;

interface ProgramRepositoryInterface {
   public function all($pageNumber);
   public function show($program);
   public function store($data);
   public function update($program,$data);
   public function destroy($program);
}

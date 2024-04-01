<?php

namespace App\Repositories\Challenge;

interface ChallengeRepositoryInterface {
   public function all($pageNumber);
   public function show($challenge);
   public function store($data);
   public function update($challenge,$data);
   public function destroy($challenge);
}

<?php

namespace App\Repositories\User;

interface UserRepositoryInterface {
   public function all($pageNumber);
   public function show($user);
   public function store($data);
   public function update($user,$data);
   public function destroy($user);
}

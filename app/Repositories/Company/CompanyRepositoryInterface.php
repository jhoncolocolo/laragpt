<?php

namespace App\Repositories\Company;

interface CompanyRepositoryInterface {
   public function all($pageNumber);
   public function show($company);
   public function store($data);
   public function update($company,$data);
   public function destroy($company);
}

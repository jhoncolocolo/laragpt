<?php

namespace Tests\Feature\Laragpt;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Company;
use App\Models\User;
use Tests\Feature\Laragpt\Factory\MasterFactory;

class CompanyTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        //Base Factories
        MasterFactory::createBase();
        $this->setUpFaker();
    }

    /**
    * test get all companies.
    * you can call only This test of this way php artisan test --filter testCompaniesGetAll
    * @return  void
    */
    public function testCompaniesGetAll()
    {
        $companies = Company::factory()->count(45)->create();

         $response = $this->json('GET','api/companies');

         // Get a random record of those created
         $company = Company::first();

         // Verify that the response is in JSON format
         $response->assertHeader('Content-Type', 'application/json');

         // Get data from JSON response
         $responseData = $response->json();

         // Verify that the specific record is present in the paginated response
         $this->assertContains($company->toArray(), $responseData['data']);

         $this->assertDatabaseCount('companies', 45);

         $response->assertStatus(200);
    }

     /**
     * test when not exist data.
     * you can call only This test of this way php artisan test --filter testNoDataExists
     * @return  void
     */
     public function testNoDataExists()
     {
         $response = $this->get('api/companies');
         $response->assertStatus(404);
         $response->assertJsonFragment(['message' => 'Not found Registries']);
     }

     /**
     * test Exception when user send page with value Zero .
     * you can call only This test of this way php artisan test --filter testExceptionPageValueZero
     * @return  void
     */
     public function testExceptionPageValueZero()
     {
         $response = $this->get('api/companies?page=0');

         $response->assertStatus(405)
             ->assertJson([
                 'message' => 'Validation exception',
                 'errors' => [
                     'page' => ['The Value of the Page cannot be less than 1']
                 ]
             ]);
     }

     /**
     * test Exception when user send page with not integer value.
     * you can call only This test of this way php artisan test --filter testExceptionPageNonIntegerValue
     * @return  void
     */
     public function testExceptionPageNonIntegerValue()
     {
         $response = $this->get('/api/companies?page=abc');

         $response->assertStatus(405)
             ->assertJson([
                 'message' => 'Validation exception',
                 'errors' => [
                     'page' => ['The page should be a integer']
                 ]
             ]);
     }

     /**
     * test when user send page with value greater than the pages exist according registries of database.
     * you can call only This test of this way php artisan test --filter testPageBeyondLimit
     * @return  void
     */
     public function testPageBeyondLimit()
     {
         $challenges = Company::factory()->count(15)->create();

         $response = $this->get('/api/companies?page=3');

         $response->assertStatus(400)
             ->assertJson([
                 'message' => 'The requested page is beyond the limit'
             ]);
     }

     /**
     * test when user send page with value greater than the first page according registries of database.
     * you can call only This test of this way php artisan test --filter testPageGreaterThanFirst
     * @return  void
     */
     public function testPageGreaterThanFirst()
     {
         // Create 45 regsitries companies
         Company::factory()->count(45)->create();

         // Make an HTTP GET request to the path /companies?page=2
         $response = $this->get('/api/companies?page=2');

         // Verify that the response has HTTP status 200 (OK)
         $response->assertStatus(200);

         // Verify that the structure of the JSON response is correct
         $response->assertJsonStructure([
             'current_page',
             'data' => [
                 '*' => [
                     'id',
                     'name',
                     'image_path',
                     'location',
                     'industry',
                     'user_id'
                 ]
             ],
             'next_page_url',
             'path',
             'per_page',
             'to',
             'total',
         ]);
     }


    /**
    * test get company By Id.
    *
    * @return  void
    */
   public function testCompanyGetById()
   {
       $company = Company::create([
            'name' => $name_1 =  $this->faker->text(255),
            'image_path' => $image_path_1 =  $this->faker->text(255),
            'location' => $location_1 =  $this->faker->text(255),
            'industry' => $industry_1 =  $this->faker->text(255),
            'user_id' => $user_id_1 =  User::inRandomOrder()->first()->id,
        ]);

       $response = $this->json('GET','api/companies/'.$company->id);

       $response->assertJson([
            'name' => $name_1,
            'image_path' => $image_path_1,
            'location' => $location_1,
            'industry' => $industry_1,
            'user_id' => $user_id_1,
        ]);

       $response->assertStatus(200);
   }

   /**
     * test create company.
     *
     * @return  void
     */
    public function testCompanyCreate()
    {

        $response = $this->json('POST','api/companies',[
            'name' => $this->faker->text(255),
            'image_path' => $this->faker->text(255),
            'location' => $this->faker->text(255),
            'industry' => $this->faker->text(255),
            'user_id' => User::inRandomOrder()->first()->id,
        ]);
        $this->assertDatabaseCount('companies', 1);
        $response->assertStatus(200);
    }

    /**
     * test update company.
     *
     * @return  void
     */
    public function testCompanyUpdate()
    {
        $company = Company::create([
            'name' => $this->faker->text(255),
            'image_path' => $this->faker->text(255),
            'location' => $this->faker->text(255),
            'industry' => $this->faker->text(255),
            'user_id' => User::inRandomOrder()->first()->id,
        ]);
        $response = $this->json('PUT','api/companies/'.$company->id,[
            'name' => $name = $this->faker->text(255),
          'image_path' => $company->image_path,
          'location' => $company->location,
          'industry' => $company->industry,
          'user_id' => $company->user_id,

        ]);

        $this->assertDatabaseHas('companies', [
            'name' => $name,
        ]);

        $response->assertStatus(200);
    }

    /**
     * test delete company.
     *
     * @return  void
     */
    public function testCompanyDelete()
    {
        $company = Company::create([
            'name' => $this->faker->text(255),
            'image_path' => $this->faker->text(255),
            'location' => $this->faker->text(255),
            'industry' => $this->faker->text(255),
            'user_id' => User::inRandomOrder()->first()->id,
        ]);

        $response = $this->json('DELETE','api/companies/'.$company->id);

        $this->assertDatabaseCount('companies', 0);

        $response->assertStatus(200);
    }
}

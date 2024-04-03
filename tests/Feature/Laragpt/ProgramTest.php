<?php

namespace Tests\Feature\Laragpt;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Program;
use App\Models\User;
use Tests\Feature\Laragpt\Factory\MasterFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProgramTest extends TestCase
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
    * test get all programs.
    * you can call only This test of this way php artisan test --filter testProgramsGetAll
    * @return  void
    */
    public function testProgramsGetAll()
    {
        $programs = Program::factory()->count(45)->create();

         $response = $this->json('GET','api/programs');

         // Get a random record of those created
         $program = Program::first();

         // Verify that the response is in JSON format
         $response->assertHeader('Content-Type', 'application/json');

         // Get data from JSON response
         $responseData = $response->json();

         //Verify that the specific record is present in the paginated response
         $this->assertContains($program->toArray(), $responseData['data']);

         $this->assertDatabaseCount('programs', 45);

         $response->assertStatus(200);
    }

     /**
     * test when not exist data.
     * you can call only This test of this way php artisan test --filter testNoDataExists
     * @return  void
     */
     public function testNoDataExists()
     {
         $response = $this->get('api/programs');
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
         $response = $this->get('api/programs?page=0');

         $response->assertStatus(405)
             ->assertJson([
                 'message' => 'Validation exception',
                 'errors' => [
                     'page' => ['The Value of the Page cannot be less than 1']
                 ]
             ]);
     }

     /**
     * test Exception when program send page with not integer value.
     * you can call only This test of this way php artisan test --filter testExceptionPageNonIntegerValue
     * @return  void
     */
     public function testExceptionPageNonIntegerValue()
     {
         $response = $this->get('/api/programs?page=abc');

         $response->assertStatus(405)
             ->assertJson([
                 'message' => 'Validation exception',
                 'errors' => [
                     'page' => ['The page should be a integer']
                 ]
             ]);
     }

     /**
     * test when program send page with value greater than the pages exist according registries of database.
     * you can call only This test of this way php artisan test --filter testPageBeyondLimit
     * @return  void
     */
     public function testPageBeyondLimit()
     {
         $programs = Program::factory()->count(15)->create();

         $response = $this->get('/api/programs?page=3');

         $response->assertStatus(400)
             ->assertJson([
                 'message' => 'The requested page is beyond the limit'
             ]);
     }

     /**
     * test when program send page with value greater than the first page according registries of database.
     * you can call only This test of this way php artisan test --filter testPageGreaterThanFirst
     * @return  void
     */
     public function testPageGreaterThanFirst()
     {
         //Create 45 regsitries programs
         Program::factory()->count(45)->create();

         // Make an HTTP GET request to the path  /programs?page=2
         $response = $this->get('/api/programs?page=2');

         // Verify that the response has HTTP status 200(OK)
         $response->assertStatus(200);

         //  Verify that the structure of the JSON response is correct
         $response->assertJsonStructure([
             'current_page',
             'data' => [
                 '*' => [
                     'id',
                     'title',
                     'description',
                     'start_date',
                     'end_date',
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
    * test get program By Id.
    *
    * @return  void
    */
   public function testProgramGetById()
   {
       $program = Program::create([
            'title' => $title_1 =  $this->faker->text(255),
            'description' => $description_1 =  $this->faker->text(),
            'start_date' => $start_date_1 =  $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'end_date' => $end_date_1 =  $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'user_id' => $user_id_1 =  User::inRandomOrder()->first()->id,
        ]);

       $response = $this->json('GET','api/programs/'.$program->id);

       $response->assertJson([
            'title' => $title_1,
            'description' => $description_1,
            'start_date' => $start_date_1,
            'end_date' => $end_date_1,
            'user_id' => $user_id_1,
        ]);

       $response->assertStatus(200);
   }

   /**
     * test when specific company not exists in databse
     * you can call only This test of this way php artisan test --filter testProgramGetByIdNotFound
     * @return  void
     */
    public function testProgramGetByIdNotFound()
    {
        $id = 3;
        $response = $this->get('/api/programs/'.$id);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'No exists program with id : '.$id
            ]);
    }

   /**
     * test create program.
     *
     * @return  void
     */
    public function testProgramCreate()
    {
        $response = $this->json('POST','api/programs',[
            'title' => $this->faker->text(255),
            'description' => $this->faker->text(),
            'start_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
            'end_date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
            'user_id' => User::inRandomOrder()->first()->id,
        ]);
        $this->assertDatabaseCount('programs', 1);
        $response->assertStatus(200);
    }

    /**
     * test update program.
     *
     * @return  void
     */
    public function testProgramUpdate()
    {
        $program = Program::create([
            'title' => $this->faker->text(255),
            'description' => $this->faker->text(),
            'start_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
            'end_date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
            'user_id' => User::inRandomOrder()->first()->id,
        ]);
        $response = $this->json('PUT','api/programs/'.$program->id,[
            'title' => $title = $this->faker->text(255),
          'description' => $program->description,
          'start_date' => $program->start_date,
          'end_date' => $program->end_date,
          'user_id' => $program->user_id,

        ]);

        $this->assertDatabaseHas('programs', [
            'title' => $title,
        ]);

        $response->assertStatus(200);
    }

    /**
     * test delete program.
     *
     * @return  void
     */
    public function testProgramsDelete()
    {
        $program = Program::create([
            'title' => $this->faker->text(255),
            'description' => $this->faker->text(),
            'start_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
            'end_date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
            'user_id' => User::inRandomOrder()->first()->id,
        ]);

        $response = $this->json('DELETE','api/programs/'.$program->id);

        $this->assertDatabaseCount('programs', 0);

        $response->assertStatus(200);
    }
}

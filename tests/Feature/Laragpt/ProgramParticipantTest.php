<?php

namespace Tests\Feature\Laragpt;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ProgramParticipant;
use App\Models\Program;
use App\Models\Challenge;
use App\Models\Company;
use App\Models\User;
use Tests\Feature\Laragpt\Factory\MasterFactory;
use Tests\Feature\Laragpt\Factory\TablesDependentFactory;

class ProgramParticipantTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        //Base Factories
        MasterFactory::createBase();
        $this->setUpFaker();
        TablesDependentFactory::createTables('programs');
        TablesDependentFactory::createTables('challenges');
        TablesDependentFactory::createTables('companies');
    }

    /**
    * test get all programParticipants.
    * you can call only This test of this way php artisan test --filter testProgramParticipantsGetAll
    * @return  void
    */
    public function testProgramParticipantsGetAll()
    {

        $programParticipants = ProgramParticipant::factory()->count(45)->create();
         $response = $this->json('GET','api/program_participants');

         // Get a random record of those created
         $user = ProgramParticipant::first();

         // Verify that the response is in JSON format
         $response->assertHeader('Content-Type', 'application/json');

         // Get data from JSON response
         $responseData = $response->json();

         //Verify that the specific record is present in the paginated response
         $this->assertContains($user->toArray(), $responseData['data']);

         $this->assertDatabaseCount('program_participants', 45);

         $response->assertStatus(200);
    }

     /**
     * test when not exist data.
     * you can call only This test of this way php artisan test --filter testNoDataExists
     * @return  void
     */
     public function testNoDataExists()
     {
         $response = $this->get('api/program_participants');
         $response->assertStatus(404);
         $response->assertJsonFragment(['message' => 'Not found Registries']);
     }

     /**
     * test Exception when program  send page with value Zero .
     * you can call only This test of this way php artisan test --filter testExceptionPageValueZero
     * @return  void
     */
     public function testExceptionPageValueZero()
     {
         $response = $this->get('api/program_participants?page=0');

         $response->assertStatus(405)
             ->assertJson([
                 'message' => 'Validation exception',
                 'errors' => [
                     'page' => ['The Value of the Page cannot be less than 1']
                 ]
             ]);
     }

     /**
     * test Exception when Program participant send page with not integer value.
     * you can call only This test of this way php artisan test --filter testExceptionPageNonIntegerValue
     * @return  void
     */
     public function testExceptionPageNonIntegerValue()
     {
         $response = $this->get('/api/program_participants?page=abc');

         $response->assertStatus(405)
             ->assertJson([
                 'message' => 'Validation exception',
                 'errors' => [
                     'page' => ['The page should be a integer']
                 ]
             ]);
     }

      /**
     * test when Program participant send page with value greater than the pages exist according registries of database.
     * you can call only This test of this way php artisan test --filter testPageBeyondLimit
     * @return  void
     */
    public function testPageBeyondLimit()
    {
        $programParticipants = ProgramParticipant::factory()->count(15)->create();

        $response = $this->get('/api/program_participants?page=3');

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'The requested page is beyond the limit'
            ]);
    }

    /**
    * test when Program Participant send page with value greater than the first page according registries of database.
    * you can call only This test of this way php artisan test --filter testPageGreaterThanFirst
    * @return  void
    */
    public function testPageGreaterThanFirst()
    {
        //Create 45 regsitries programParticipants
        ProgramParticipant::factory()->count(45)->create();

        // Make an HTTP GET request to the path  /program_participants?page=2
        $response = $this->get('/api/program_participants?page=2');

        // Verify that the response has HTTP status 200(OK)
        $response->assertStatus(200);

        //  Verify that the structure of the JSON response is correct
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'program_id',
                    'entitiable_type',
                    'entitiable_id'
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
    * test get programParticipant By Id.
    *
    * @return  void
    */
   public function testProgramParticipantGetById()
   {
       $programParticipant = ProgramParticipant::create([
            'program_id' => $program_id_1 =  Program::inRandomOrder()->first()->id,
            'entitiable_type' => $entitiable_type_1 =  $this->faker->text(50),
            'entitiable_id' => $entitiable_id_1 =  $this->faker->randomDigit(),
        ]);

       $response = $this->json('GET','api/program_participants/'.$programParticipant->id);

       $response->assertJson([
            'program_id' => $program_id_1,
            'entitiable_type' => $entitiable_type_1,
            'entitiable_id' => $entitiable_id_1,
        ]);

       $response->assertStatus(200);
   }

   /**
     * test when specific Program Participant not exists in databse
     * you can call only This test of this way php artisan test --filter testProgramParticipantGetByIdNotFound
     * @return  void
     */
    public function testProgramParticipantGetByIdNotFound()
    {
        $id = 3;
        $response = $this->get('/api/program_participants/'.$id);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'No exists Program Participant with id : '.$id
            ]);
    }

   /**
     * test create programParticipant.
     *
     * @return  void
     */
    public function testProgramParticipantCreate()
    {
        // Possible entities
        $entitiableTypes = ['App\Models\User', 'App\Models\Challenge', 'App\Models\Company'];

        $entitiableType = $this->faker->randomElement($entitiableTypes);
        $entitiableId = null;

        switch ($entitiableType) {
            case 'App\Models\User':
                $entitiableId = User::getRandomId();
                break;
            case 'App\Models\Challenge':
                $entitiableId = Challenge::getRandomId();
                break;
            case 'App\Models\Company':
                $entitiableId = Company::getRandomId();
                break;
        }
        $programId = Program::inRandomOrder()->first()->id;

        $response = $this->json('POST','api/program_participants',[
                'program_id' =>$programId,
                'entitiable_type' => $entitiableType,
                'entitiable_id' => $entitiableId,
        ]);
        $this->assertDatabaseCount('program_participants', 1);
        $response->assertStatus(200);
    }

    /**
     * test fail because Program Participant Break Polymorphism Create
     *
     * @return  void
     */
    public function testFailProgramParticipantBreakPolymorphismCreate()
    {
        //Entity Id not exists
        $nonExistentChallengeId = Challenge::max('id') + 1;

        $programId = Program::inRandomOrder()->first()->id;

        $response = $this->json('POST','api/program_participants',[
                'program_id' =>$programId,
                'entitiable_type' => 'App\Models\Challenge',
                'entitiable_id' => $nonExistentChallengeId,
        ]);
        $response->assertStatus(405)
        ->assertJson([
            'message' => 'Validation exception',
            'errors' => [
                'entitiable_id' => ['The entitiable id '.$nonExistentChallengeId.' not exists in entitiable_type App\Models\Challenge']
            ]
        ]);
    }

    /**
     * test update programParticipant.
     *
     * @return  void
     */
    public function testProgramParticipantUpdate()
    {
        $programParticipant = ProgramParticipant::factory()->count(1)->create();

        $response = $this->json('PUT','api/program_participants/'.$programParticipant[0]["id"],[
            'program_id' => $program_id = $programParticipant[0]["program_id"],
            'entitiable_type' => $programParticipant[0]["entitiable_type"],
            'entitiable_id' => $programParticipant[0]["entitiable_id"],
        ]);

        $this->assertDatabaseHas('program_participants', [
            'program_id' => $program_id,
        ]);

        $response->assertStatus(200);
    }

    /**
     * test fail because Program Participant Break Polymorphism Update
     *
     * @return  void
     */
    public function testFailProgramParticipantBreakPolymorphismUpdate()
    {
        //Entity Id not exists
        $nonExistentChallengeId = Challenge::max('id') + 1;

        $programParticipant = ProgramParticipant::factory()->count(1)->create();

        $response = $this->json('PUT','api/program_participants/'.$programParticipant[0]["id"],[
            'program_id' => $program_id = $programParticipant[0]["program_id"],
            'entitiable_type' => 'App\Models\Challenge',
            'entitiable_id' => $nonExistentChallengeId,
        ]);

        $response->assertStatus(405)
        ->assertJson([
            'message' => 'Validation exception',
            'errors' => [
                'entitiable_id' => ['The entitiable id '.$nonExistentChallengeId.' not exists in entitiable_type App\Models\Challenge']
            ]
        ]);
    }

    /**
     * test delete programParticipant.
     *
     * @return  void
     */
    public function testProgramParticipantDelete()
    {
        $programParticipant = ProgramParticipant::factory()->count(1)->create()[0];

        $response = $this->json('DELETE','api/program_participants/'.$programParticipant['id']);

        $this->assertDatabaseCount('program_participants', 0);

        $response->assertStatus(200);
    }
}


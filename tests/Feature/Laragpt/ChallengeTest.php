<?php

namespace Tests\Feature\Laragpt;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Challenge;
use App\Models\User;
use Tests\Feature\Laragpt\Factory\MasterFactory;

class ChallengeTest extends TestCase
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
    * test get all challenges.
    * you can call only This test of this way php artisan test --filter testChallengesGetAll
    * @return  void
    */
    public function testChallengesGetAll()
    {
        $challenges = Challenge::factory()->count(45)->create();

         $response = $this->json('GET','api/challenges');

         // Get a random record of those created
         $challenge = Challenge::first();

         // Verify that the response is in JSON format
         $response->assertHeader('Content-Type', 'application/json');

         // Get data from JSON response
         $responseData = $response->json();

         //Verify that the specific record is present in the paginated response
         $this->assertContains($challenge->toArray(), $responseData['data']);

         $this->assertDatabaseCount('challenges', 45);

         $response->assertStatus(200);
    }

     /**
     * test when not exist data.
     * you can call only This test of this way php artisan test --filter testNoDataExists
     * @return  void
     */
     public function testNoDataExists()
     {
         $response = $this->get('api/challenges');
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
         $response = $this->get('api/challenges?page=0');

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
         $response = $this->get('/api/challenges?page=abc');

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
         $challenges = Challenge::factory()->count(15)->create();

         $response = $this->get('/api/challenges?page=3');

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
         //Create 45 regsitries challenges
         Challenge::factory()->count(45)->create();

         // Make an HTTP GET request to the path  /challenges?page=2
         $response = $this->get('/api/challenges?page=2');

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
                     'difficulty',
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
    * test get challenge By Id.
    *
    * @return  void
    */
   public function testChallengeGetById()
   {
       $challenge = Challenge::create([
            'title' => $title_1 =  $this->faker->text(255),
            'description' => $description_1 =  $this->faker->text(),
            'difficulty' => $difficulty_1 =  $this->faker->randomElement([1, 2, 3]),
            'user_id' => $user_id_1 =  User::inRandomOrder()->first()->id,
        ]);

       $response = $this->json('GET','api/challenges/'.$challenge->id);

       $response->assertJson([
            'title' => $title_1,
            'description' => $description_1,
            'difficulty' => $difficulty_1,
            'user_id' => $user_id_1,
        ]);

       $response->assertStatus(200);
   }

   /**
     * test create challenge.
     *
     * @return  void
     */
    public function testChallengeCreate()
    {

        $response = $this->json('POST','api/challenges',[
            'title' => $this->faker->text(255),
            'description' => $this->faker->text(),
            'difficulty' => $this->faker->randomElement([1, 2, 3]),
            'user_id' => User::inRandomOrder()->first()->id,
        ]);
        $this->assertDatabaseCount('challenges', 1);
        $response->assertStatus(200);
    }

    /**
     * test update challenge.
     *
     * @return  void
     */
    public function testChallengeUpdate()
    {
        $challenge = Challenge::create([
            'title' => $this->faker->text(255),
            'description' => $this->faker->text(),
            'difficulty' => $this->faker->randomElement([1, 2, 3]),
            'user_id' => User::inRandomOrder()->first()->id,
        ]);
        $response = $this->json('PUT','api/challenges/'.$challenge->id,[
            'title' => $title = $this->faker->text(255),
          'description' => $challenge->description,
          'difficulty' => $challenge->difficulty,
          'user_id' => $challenge->user_id,

        ]);

        $this->assertDatabaseHas('challenges', [
            'title' => $title,
        ]);

        $response->assertStatus(200);
    }

    /**
     * test delete challenge.
     *
     * @return  void
     */
    public function testChallengeDelete()
    {
        $challenge = Challenge::create([
            'title' => $this->faker->text(255),
            'description' => $this->faker->text(),
            'difficulty' => $this->faker->randomDigit(),
            'user_id' => User::inRandomOrder()->first()->id,
        ]);

        $response = $this->json('DELETE','api/challenges/'.$challenge->id);

        $this->assertDatabaseCount('challenges', 0);

        $response->assertStatus(200);
    }
}

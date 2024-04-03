<?php

namespace Tests\Feature\Laragpt;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use ErrorException;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
    * test get all users.
    * you can call only This test of this way php artisan test --filter testUsersGetAll
    * @return  void
    */
    public function testUsersGetAll()
    {
        $users = User::factory()->count(45)->create();

         $response = $this->json('GET','api/users');

         // Get a random record of those created
         $user = User::first();

         // Verify that the response is in JSON format
         $response->assertHeader('Content-Type', 'application/json');

         // Get data from JSON response
         $responseData = $response->json();

         //Verify that the specific record is present in the paginated response
         $this->assertContains($user->toArray(), $responseData['data']);

         $this->assertDatabaseCount('users', 45);

         $response->assertStatus(200);
    }

     /**
     * test when not exist data.
     * you can call only This test of this way php artisan test --filter testNoDataExists
     * @return  void
     */
     public function testNoDataExists()
     {
         $response = $this->get('api/users');
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
         $response = $this->get('api/users?page=0');

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
         $response = $this->get('/api/users?page=abc');

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
        $users = User::factory()->count(15)->create();

        $response = $this->get('/api/users?page=3');

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
        //Create 45 regsitries users
        User::factory()->count(45)->create();

        // Make an HTTP GET request to the path  /users?page=2
        $response = $this->get('/api/users?page=2');

        // Verify that the response has HTTP status 200(OK)
        $response->assertStatus(200);

        //  Verify that the structure of the JSON response is correct
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'image_path'
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
    * test get user By Id.
    *
    * @return  void
    */
   public function testUserGetById()
   {
       $user = User::create([
            'name' => $name_1 =  $this->faker->userName(),
            'email' => $email_1 =  $this->faker->unique()->safeEmail(),
            'image_path' => $image_path_1 =  $this->faker->text(255),
        ]);

       $response = $this->json('GET','api/users/'.$user->id);

       $response->assertJson([
            'name' => $name_1,
            'email' => $email_1,
            'image_path' => $image_path_1,
        ]);

       $response->assertStatus(200);
   }

   /**
     * test when specific company not exists in databse
     * you can call only This test of this way php artisan test --filter testUserGetByIdNotFound
     * @return  void
     */
    public function testUserGetByIdNotFound()
    {
        $id = 3;
        $response = $this->get('/api/users/'.$id);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'No exists user with id : '.$id
            ]);
    }

   /**
     * test create user.
     *
     * @return  void
     */
    public function testUserCreate()
    {

        $response = $this->json('POST','api/users',[
            'name' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'image_path' => $this->faker->text(255),
        ]);
        $this->assertDatabaseCount('users', 1);
        $response->assertStatus(200);
    }

    /**
     * test update user.
     *
     * @return  void
     */
    public function testUserUpdate()
    {
        $user = User::create([
            'name' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'image_path' => $this->faker->text(255),
        ]);
        $response = $this->json('PUT','api/users/'.$user->id,[
            'name' => $name = $this->faker->userName(),
          'email' => $user->email,
          'image_path' => $user->image_path,

        ]);

        $this->assertDatabaseHas('users', [
            'name' => $name,
        ]);

        $response->assertStatus(200);
    }

    /**
     * test delete user.
     *
     * @return  void
     */
    public function testUsersDelete()
    {
        $user = User::create([
            'name' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'image_path' => $this->faker->text(255),
        ]);

        $response = $this->json('DELETE','api/users/'.$user->id);

        $this->assertDatabaseCount('users', 0);

        $response->assertStatus(200);
    }

    /**
    * test Massive Generator.
    *
    * @return  void
    */
    public function testMassiveGenerator()
    {
        //File that Contain the request to GPT
        $requestToGPT= $this->getFileContent('/../../../storage/app/requests/','requestToGPTUsers.txt');

         //Get Dummy which simulates the valid response of GPT
        $responseToGPT= $this->getFileContent('/../../../storage/app/dummies/','responseGPTUser.txt');

        // Simulate the Gemini response
         Gemini::fake([
             GenerateContentResponse::fake([
                 'candidates' => [
                     [
                         'content' => [
                             'parts' => [
                                 [
                                     'text' => $responseToGPT,
                                 ],
                             ],
                         ],
                     ],
                 ],
             ]),
         ]);

         // Call Method Controller
        $response = $this->json('POST','api/massive_generator',[
            'message' => $requestToGPT
        ]);
        $this->assertDatabaseCount('users', 24);

        // Verify that a JSON response is returned with the expected message
        $response->assertJson([
            'message' => 'Records Created Successfully',
            'status' => 200
        ]);
    }

    /**
     * Get Content File
     * @param $pathDirectory path Directory
     * @param $nameFile name of File
     * @return mixed
    */
    private function getFileContent($pathDirectory,$nameFile)
    {
        // Get path Directory
        $storagePath = __DIR__ . $pathDirectory;

        // Get name File
        $filePath = $storagePath . $nameFile;

        // Check if exist file
        if (file_exists($filePath)) {
            // Read File
            return file_get_contents($filePath);

        } else {
            return null;
        }
    }
}

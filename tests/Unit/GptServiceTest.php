<?php

namespace Tests\Unit;

use Gemini\Laravel\Facades\Gemini;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use ErrorException;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Generic\GenericService;
use App\Services\User\UserService;
use App\Services\Challenge\ChallengeService;
use App\Services\Company\CompanyService;
use App\Services\Program\ProgramService;
use App\Services\ProgramParticipant\ProgramParticipantService;
use App\Services\Gpt\GptService;

class GptServiceTest extends TestCase
{
    use RefreshDatabase;
    protected $requestMessage;
    protected $jsonResponse;
    protected $dummieResponse;
    public function setUp(): void
    {

        parent::setUp();

        // Service Instance
        $this->genericService = new GenericService();
        $this->userService = new UserService();
        $this->challengeService = new ChallengeService();
        $this->companyService = new CompanyService();
        $this->programService = new ProgramService();
        $this->programParticipantService = new ProgramParticipantService();
        $this->gptService = new GptService();

        //File that Contain the request to GPT
        $this->requestMessage = $this->getFileContent('/../../storage/app/requests/','requestToGPTTest.txt');

        // File that define the expected JSON response
        $this->dummieResponse = $this->getFileContent('/../../storage/app/dummies/','responseGPTChallenge.txt');

        // Simulate the Gemini response
        Gemini::fake([
            GenerateContentResponse::fake([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                [
                                    'text' => $this->dummieResponse,
                                ],
                            ],
                        ],
                    ],
                ],
            ]),
        ]);
    }


    /** @test */
    public function it_can_generate_content()
    {

        // Call the method to generate content
        $result = $this->gptService->send($this->requestMessage);

        // Assert that the response matches the expected JSON
        $this->assertEquals($this->dummieResponse, $result);
    }

    /** @test */
    public function testWhenHaveErrorsInApiAndReturnInGenerateSeeders()
    {

        // Simulate a 500 error response from Gemini
        Gemini::fake([
            new ErrorException("Something went wrong on Gemini", 500),
        ]);

        // Call the method to generate random JSON data
        $result = $this->gptService->generateSeeders($this->requestMessage);

        // Assert that the result is an array with an error message
        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        //Last Message of Catch generateSeeders
        $this->assertEquals("Error generating JSON data: Error sending request to Gemini: Something went wrong on Gemini", $result['error']);
    }


    /** @test */
    public function testWhenHaveErrorsInApiAndReturnInSend()
    {
        // Simulate a 500 error response from Gemini
        Gemini::fake([
            new ErrorException("Something went wrong on Gemini", 500),
        ]);

        try {
            // Call the method to generate random JSON data
            $result = $this->gptService->send($this->requestMessage);

        } catch (\Exception $e) {
            // Assert the correct exception message and code create in method send
            $this->assertEquals("Error sending request to Gemini: Something went wrong on Gemini", $e->getMessage());
            $this->assertEquals(500, $e->getCode());
        }
    }

    /** @test */
    public function testIsSuccessSendGptMessage()
    {

        // Call the method to send a Gpt message
        $result = $this->gptService->send($this->requestMessage);

        // Assert that the response matches the expected JSON
        $this->assertEquals($this->dummieResponse, $result);
    }

    /** @test */
    public function testIsSuccessGenerateSeeders()
    {
        // Call the method to generate random JSON data
        $result = $this->gptService->generateSeeders($this->requestMessage);
        // Assert that the response is an array
        $this->assertIsArray($result);
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

    /**
     * Limpia la base de datos después de cada prueba.
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }
}

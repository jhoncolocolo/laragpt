<?php
namespace App\Services\Gpt;

use Gemini\Laravel\Facades\Gemini;
use Gemini\Requests\GenerativeModel\GenerateContentRequest;
use Gemini\Enums\ModelType;
use Exception;
use Gemini\Client;
use App\Services\Generic\GenericService;

class GptService
{
    /**
     * Send a request to Bard and return the JSON response.
     *
     * @param array $data Message to send to Bard
     * @return string|null JSON response string or null on failure
     * @throws Exception
     */
    public function send($message)
    {

        if (!$message) {
            throw new Exception('Missing message in request data');
        }

        try {
            $result = Gemini::geminiPro()->generateContent($message);

            if (!$result) {
                throw new Exception('Gemini response was empty'); // Throw exception if Gemini response is empty
            }

            // Get the JSON data from the response object
            return $result->text();
        } catch (Exception $e) {
            // Handle any exceptions and rethrow
            throw new Exception('Error sending request to Gemini: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Generate random JSON data using Bard.
     *
     * @return array|null PHP array or null on failure
     */
    public function generateSeeders($message)
    {
        try {

            $response = $this->send($message);

            if (!is_string($response)) {
                throw new Exception('Unexpected response format from Bard');
            }

            //Convert response of GPT to Array
            $jsonData = $this->convertResponseGPTToArray($response);

            if ($jsonData !== null) {
                return $jsonData;
            } else {
                $errorMessage = json_last_error_msg();

                // Manejar errores de decodificación
                if (strpos($errorMessage, 'syntax error') !== false) {
                    // Handle syntax errors
                    return ['error' => 'Invalid JSON syntax in Bard response'];
                } else {
                    // Handle other decoding errors
                    return ['error' => 'Error decoding JSON: ' . $errorMessage];
                }
            }
        } catch (Exception $e) {
            return ['error' => 'Error generating JSON data: ' . $e->getMessage()];
        }
    }

    /**
     * convertResponseGPTToArray
     * Function for convert response GPT to Array
     * @param $string String
     * @return array|null PHP array or null on failure
     */
    public function convertResponseGPTToArray($string){
        $genericService = new GenericService();
        $string= $genericService->cleanStringForConvertions($string);

        //Check that exists character backSlash in order to avoid errors
        if (strpos($string, '\\') !== false) {
            $string = preg_replace('/\\\+/', '**backslash**', $string);
            $data = json_decode($string, true);

            // Restore backslashes in case that these was replaced before
            if (is_array($data)) {
                array_walk_recursive($data, function (&$value) {
                    if (is_string($value)) {
                        $value = str_replace('**backslash**', '\\', $value);
                    }
                });
            }
        }else{
            $data = json_decode($string, true);
        }
        return $data;
    }
}

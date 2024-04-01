<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\User\UserService;
use App\Services\Challenge\ChallengeService;
use App\Services\Company\CompanyService;
use App\Services\Program\ProgramService;
use App\Services\ProgramParticipant\ProgramParticipantService;
use App\Services\Gpt\GptService;
use App\Services\Generic\GenericService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FillDataWithGptCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-data-with-gpt-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill Information With GPT';

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var ChallengeService
     */
    protected $challengeService;

    /**
     * @var CompanyService
     */
    protected $companyService;

    /**
     * @var ProgramService
     */
    protected $programService;

    /**
     * @var ProgramParticipantService
     */
    protected $programParticipantService;

    /**
     * @var GptService
     */
    protected $gptService;

    /**
     * @var GenericService
     */
    protected $genericService;

    /**
     * Create a new command instance.
     *
     * @param UserService $userService
     * @param ChallengeService $challengeService
     * @param CompanyService $companyService
     * @param ProgramService $programService
     * @param ProgramParticipantService $programParticipantService
     * @param GptService $gptService
     * @param GenericService $genericService
     */
    public function __construct(
        UserService $userService,
        ChallengeService $challengeService,
        CompanyService $companyService,
        ProgramService $programService,
        ProgramParticipantService $programParticipantService,
        GptService $gptService,
        GenericService $genericService
    ) {
        parent::__construct();

        $this->userService = $userService;
        $this->challengeService = $challengeService;
        $this->companyService = $companyService;
        $this->programService = $programService;
        $this->programParticipantService = $programParticipantService;
        $this->gptService = $gptService;
        $this->genericService = $genericService;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line("Getting Information of Api Artificial Intelligence");

        $infoToGetFromAI = [
            'users' =>Storage::disk('local')->get('requests/requestToGPTUsers.txt'),
            'challenges' =>Storage::disk('local')->get('requests/requestToGPTChallenges.txt'),
            'companies' =>Storage::disk('local')->get('requests/requestToGPTCompanies.txt'),
            'programs' =>Storage::disk('local')->get('requests/requestToGPTPrograms.txt'),
            'program_participants' =>Storage::disk('local')->get('requests/requestToProgramsPartipants.txt')
        ];
        $totalTables = count($infoToGetFromAI);

        $this->info('Loading...');

        // Inicializar el progreso
        $this->output->progressStart($totalTables);

        try{
            foreach ($infoToGetFromAI as $table => $requestToGPTAI) {
                $this->output->text("Get Data for registries into the table: $table");
                Log::info("Para la tabla");
                Log::info($table);
                Log::info("Se info que se manda a AI");
                Log::info($requestToGPTAI);

                $seeders = \GptService::generateSeeders($requestToGPTAI);
                Log::info("Lo que se obtuvo");
                Log::info($seeders);
                $this->output->text("Inserting " . count($seeders) . " registries into the table: $table");

                foreach ($seeders as $registry => $data) {
                    switch ($table) {
                        case 'users':
                            $this->userService->store($data);
                        break;
                        case 'challenges':
                            $this->challengeService->store($data);
                        break;
                        case 'companies':
                            $this->companyService->store($data);
                        break;
                        case 'programs':
                            $this->programService->store($data);
                        break;
                        case 'program_participants':
                            $this->programParticipantService->store($data);
                            break;
                    }
                }
                // Increase progress bar
                $this->output->progressAdvance();
            }
            // Finalizar la barra de progreso después de procesar todas las tablas
            $this->output->progressFinish();
        }catch(\Exeption $e){
            // handle any exception to finish de process
            $this->error('Error inserting data for Tables: ' . $e->getMessage());
            $this->output->progressFinish();
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}

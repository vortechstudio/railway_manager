<?php

namespace App\Services\Github;

use Cloudstudio\Ollama\Facades\Ollama;
use Github\AuthMethod;
use Github\Client;
use Monolog\Level;
use Monolog\LogRecord;

class Issues
{
    private $owner;

    private $repo;

    protected $client;

    protected $gpt;

    public function __construct(
        public LogRecord $record
    ) {
        $this->owner = config('updater.github_username');
        $this->repo = config('updater.github_repository');
        $this->client = new Client();
        $this->client->authenticate(config('updater.github_token'), null, AuthMethod::ACCESS_TOKEN);
        $this->gpt = Ollama::agent('Tu est un expert en laravel 10 / livewire 3 et AlpineJS. Tu est également un expert en Git et tu connais github pour le provisionnement des repos. Tu est français.');
    }

    /**
     * Crée un problème à partir d'une exception.
     *
     * @throws void
     */
    public function createIssueFromException(bool $gpt = false): void
    {
        $title = "Erreur: {$this->record['message']}";
        $details = collect([
            'message' => $this->record['message'],
            'context' => $this->record['context'],
            'level' => $this->record['level_name'],
            'time' => $this->record['datetime']->format('Y-m-d H:i:s'),
            'env' => config('app.env'),
        ]);

        if (config('ollama-laravel.prompt_state') === true) {
            $openai = $this->generatePrompt($title, $details);

            ob_start();
            ?>
            ## Détail de l'erreur

            Message: <?= $details['message'] ?>

            Contexte: <?= json_encode($details['context']) ?>

            Niveau: <?= $details['level'] ?>

            Date: <?= $details['time'] ?>

            Environnement: <?= $details['env'] ?>

            ## Description
            <?= $openai[0]['description'] ?>

            ## Reproduction
            <?= $openai[1]['reproduce'] ?>

            ## Comportement attendu
            <?= $openai[2]['comportement'] ?>

            ## Solution proposé
            <?= $openai[3]['solution'] ?>
            <?php
            $issueContent = ob_get_clean();
        } else {
            ob_start();
            ?>
            ## Détail de l'erreur

            Message: <?= $details['message'] ?>

            Contexte: <?= json_encode($details['context']) ?>

            Niveau: <?= $details['level'] ?>

            Date: <?= $details['time'] ?>

            Environnement: <?= $details['env'] ?>
            <?php
            $issueContent = ob_get_clean();
        }

        $this->pushToGithub($title, $issueContent);
    }

    /**
     * A function to generate prompt using OpenAI GPT-3.5-turbo model.
     *
     * @param  string  $title  The title for the prompt
     * @param  \Illuminate\Support\Collection  $details  The details for the prompt
     */
    private function generatePrompt(string $title, \Illuminate\Support\Collection $details): \Illuminate\Support\Collection
    {
        $results = collect();

        $describe = $this->gpt->prompt("Description sous le format issue de GITHUB: \n".$title."\n".$details['message']."\n".$details['context'][0]->getMessage()."\n".$details['context'][0]->getTraceAsString())
            ->model('llama3')
            ->options(['temperature' => 0.8])
            ->stream(false)
            ->ask();

        $reproduce = $this->gpt->prompt("Comment reproduire l'erreur: \n".$title."\n".$details['message']."\n".$details['context'][0]->getMessage()."\n".$details['context'][0]->getTraceAsString())
            ->model('llama3')
            ->options(['temperature' => 0.8])
            ->stream(false)
            ->ask();

        $comportement = $this->gpt->prompt("Comportement attendu: \n".$title."\n".$details['message']."\n".$details['context'][0]->getMessage()."\n".$details['context'][0]->getTraceAsString())
            ->model('llama3')
            ->options(['temperature' => 0.8])
            ->stream(false)
            ->ask();

        $solution = $this->gpt->prompt("Solution proposé: \n".$title."\n".$details['message']."\n".$details['context'][0]->getMessage()."\n".$details['context'][0]->getTraceAsString())
            ->model('llama3')
            ->options(['temperature' => 0.8])
            ->stream(false)
            ->ask();

        $results->push(['description' => $describe['response']]);
        $results->push(['reproduce' => $reproduce['response']]);
        $results->push(['comportement' => $comportement['response']]);
        $results->push(['solution' => $solution['response']]);

        return $results;
    }

    /**
     * Envoie un problème vers Github.
     *
     * @param  string  $title  Le titre du problème
     * @param  string|bool  $issueContent  Le contenu du problème
     */
    private function pushToGithub(string $title, bool|string $issueContent): void
    {
        try {
            $this->client->issues()
                ->create($this->owner, $this->repo, [
                    'title' => $title,
                    'body' => $issueContent,
                    'labels' => ['bug', 'auto-generated', 'version::'.\VersionBuildAction::getVersionInfo()],
                ]);

            return;
        } catch (\Exception $exception) {
            \Log::emergency("Impossible de créer une issue sur Github: {$exception->getMessage()}");
        }
    }

    public static function createIssueMonolog(string $channel, string $message, array $exception, string $level = 'error')
    {
        $level = match ($level) {
            'emergency' => Level::Emergency,
            'alert' => Level::Alert,
            'critical' => Level::Critical,
            'error' => Level::Error,
            'warning' => Level::Warning,
            'notice' => Level::Notice,
            'debug' => Level::Debug,
            default => Level::Info,
        };

        return new LogRecord(
            new \DateTimeImmutable('now'),
            $channel,
            $level,
            $message,
            $exception,
        );
    }
}

<?php

namespace App\Services\Github;

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
        $this->gpt = \OpenAI::client(config('services.openai.api_key'));
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

        if (config('services.openai.state') === true && $gpt === true) {
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
            @AdaGPT Aide moi à corriger cette erreur

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

        $describe =
            $this->gpt->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'assistant',
                        'content' => "Description sous le format issue de GITHUB: \n".$title."\n".$details['message']."\n".$details['context']['exception']->getMessage()."\n".$details['context']['exception']->getTraceAsString(),
                    ],
                ],
            ]);

        $reproduce = $this->gpt->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'assistant',
                    'content' => "Comment reproduire l'erreur: \n".$title."\n".$details['message']."\n".$details['context']['exception']->getMessage()."\n".$details['context']['exception']->getTraceAsString(),
                ],
            ],
        ]);

        $comportement = $this->gpt->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'assistant',
                    'content' => "Comportement attendu: \n".$title."\n".$details['message']."\n".$details['context']['exception']->getMessage()."\n".$details['context']['exception']->getTraceAsString(),
                ],
            ],
        ]);

        $solution = $this->gpt->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'assistant',
                    'content' => "Solution proposé: \n".$title."\n".$details['message']."\n".$details['context']['exception']->getMessage()."\n".$details['context']['exception']->getTraceAsString(),
                ],
            ],
        ]);

        $results->push(['description' => $describe->choices[0]->message->content]);
        $results->push(['reproduce' => $reproduce->choices[0]->message->content]);
        $results->push(['comportement' => $comportement->choices[0]->message->content]);
        $results->push(['solution' => $solution->choices[0]->message->content]);

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

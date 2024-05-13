<?php

namespace App\Console\Commands;

use App\Models\Config\Service;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateReleaseCommand extends Command
{
    protected $signature = 'release:update';

    protected $description = 'Récupère et met à jour les release d\'un projet en liaison avec la table service';

    public function handle(): int
    {
        foreach (Service::all() as $service) {
            $this->info("Mise à jour de version du service: $service->name");
            if (isset($service->repository)) {
                $response = \Http::get("https://api.github.com/repos/vortechstudio/$service->repository/releases");

                if ($response->failed()) {
                    $this->error('Impossible de récupérer les informations de releases.');

                    return 1;
                }

                $releases = $response->json();

                foreach ($releases as $release) {
                    $service->versions()->updateOrCreate(
                        ['version' => $release['name']],
                        [
                            'version' => $release['name'],
                            'title' => $release['name'],
                            'contenue' => $release['body'],
                            'created_at' => $release['created_at'],
                            'updated_at' => $release['created_at'],
                            'published' => true,
                            'published_at' => Carbon::createFromTimestamp(strtotime($release['published_at'])),
                            'service_id' => $service->id,
                        ]
                    );
                }
            }
        }
        $this->alert('Mise à jour terminer');

        return 0;
    }
}

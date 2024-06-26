<?php

namespace App\Livewire\Game\Core;

use App\Models\Railway\Ligne\RailwayLigneStation;
use App\Models\Railway\Planning\RailwayPlanning;
use App\Models\User\Railway\UserRailwayHub;
use Livewire\Component;

class Map extends Component
{
    public string $type = '';

    public $user_hub_id;

    public $user_ligne_id;

    public RailwayPlanning $planning;

    public $user;

    public $hubs;

    public $initialMarkers;

    public $initialPolygons;

    public $initialPolylines;

    public $initialRectangles;

    public $initialCircles;

    public $options;

    public function mount(): void
    {
        match ($this->type) {
            'hub' => $this->defineForHub(),
            'hubs' => $this->defineForHubs(),
            'lignes' => $this->defineForLignes(),
            'station' => $this->defineStation(),
            default => $this->defineDefault(),
            'allLong' => $this->defineAllLong(),
        };
    }

    public function render()
    {
        return view('livewire.game.core.map');
    }

    private function defineForHub(): void
    {
        $hub = UserRailwayHub::find($this->user_hub_id);
        $this->options = [
            'center' => [
                'lat' => $hub->railwayHub->gare->latitude,
                'lng' => $hub->railwayHub->gare->longitude,
            ],
            'zoom' => 18,
            'zoomControl' => true,
            'minZoom' => 5,
            'maxZoom' => 18,
        ];

        $this->initialMarkers = [
            [
                'position' => [
                    'lat' => $hub->railwayHub->gare->latitude,
                    'lng' => $hub->railwayHub->gare->longitude,
                ],
                'draggable' => false,
                'title' => 'Tatuí - SP',
            ],
        ];
    }

    private function defineForLignes(): void
    {
        $hub = UserRailwayHub::find($this->user_hub_id);
        $this->options = [
            'center' => [
                'lat' => $hub->railwayHub->gare->latitude,
                'lng' => $hub->railwayHub->gare->longitude,
            ],
            'zoom' => 18,
            'zoomControl' => true,
            'minZoom' => 5,
            'maxZoom' => 18,
        ];

        $this->initialMarkers = $hub->userRailwayLigne->map(function ($ligne) {
            $ligne->railwayLigne->stations->map(function (RailwayLigneStation $railwayLigneStation) {
                return [
                    'position' => [
                        'lat' => $railwayLigneStation->gare->latitude,
                        'lng' => $railwayLigneStation->gare->longitude,
                    ],
                    'draggable' => false,
                    'title' => $railwayLigneStation->gare->name,
                ];
            });
        });

        $this->initialPolylines = $hub->userRailwayLigne->map(function ($ligne) {
            $ligne->railwayLigne->stations->map(function (RailwayLigneStation $railwayLigneStation) {
                return [
                    'path' => [$railwayLigneStation->gare->latitude, $railwayLigneStation->gare->longitude],
                    'strokeColor' => '#FF0000',
                    'strokeOpacity' => 1.0,
                    'strokeWeight' => 2,
                ];
            })->toArray();
        })->toArray();
    }

    private function defineDefault(): void
    {
        if (auth()->user()->userRailwayHub()->exists()) {
            $firstHub = auth()->user()->userRailwayHub()->first();
            $hubs = auth()->user()->userRailwayHub()->whereNot('id', $firstHub->id)->get();
            $this->initialMarkers = collect();

            $this->options = [
                'center' => [
                    'lat' => $firstHub->railwayHub->gare->latitude,
                    'lng' => $firstHub->railwayHub->gare->longitude,
                ],
                'zoom' => 6,
                'zoomControl' => true,
                'minZoom' => 5,
                'maxZoom' => 18,
            ];
            $this->initialMarkers->push([
                'position' => [
                    'lat' => $firstHub->railwayHub->gare->latitude,
                    'lng' => $firstHub->railwayHub->gare->longitude,
                ],
                'draggable' => false,
                'title' => $firstHub->railwayHub->gare->name,
            ]);

            $this->initialMarkers->push(
                $hubs->map(function (UserRailwayHub $userRailwayHub) {
                    return [
                        'position' => [
                            'lat' => $userRailwayHub->railwayHub->gare->latitude,
                            'lng' => $userRailwayHub->railwayHub->gare->longitude,
                        ],
                        'draggable' => false,
                        'title' => $userRailwayHub->railwayHub->gare->name,
                    ];
                })
            );
            $this->initialMarkers = $this->initialMarkers->toArray();
        } else {
            $this->options = [
                'zoom' => 6,
                'zoomControl' => true,
                'minZoom' => 5,
                'maxZoom' => 18,
            ];
        }
    }

    private function defineStation(): void
    {
        $station_start = $this->planning->stations()->where('status', 'done')->orderBy('departure_at', 'desc')->first();
        $station_end = $this->planning->stations()->where('status', 'init')->orderBy('arrival_at')->first();

        $centerLat = ($station_start->railwayLigneStation->gare->latitude + $station_end->railwayLigneStation->gare->latitude) / 2;
        $centerLng = ($station_start->railwayLigneStation->gare->longitude + $station_end->railwayLigneStation->gare->longitude) / 2;

        $this->options = [
            'center' => [
                'lat' => $centerLat,
                'lng' => $centerLng,
            ],
            'zoom' => 17,
            'zoomControl' => true,
            'minZoom' => 5,
            'maxZoom' => 18,
        ];

        $this->initialMarkers = [
            [
                'position' => [
                    'lat' => $station_start->railwayLigneStation->gare->latitude,
                    'lng' => $station_start->railwayLigneStation->gare->longitude,
                ],
                'draggable' => false,
                'title' => 'Tatuí - SP',
            ],
            [
                'position' => [
                    'lat' => $station_end->railwayLigneStation->gare->latitude,
                    'lng' => $station_end->railwayLigneStation->gare->longitude,
                ],
                'draggable' => false,
                'title' => 'Tatuí - SP',
            ],
        ];

    }

    private function defineForHubs(): void
    {
        $centerLat = 0;
        $centerLng = 0;

        foreach ($this->hubs as $hub) {
            $centerLat += $hub->gare->latitude / 2;
            $centerLng += $hub->gare->longitude / 2;
        }
        $this->initialMarkers = $this->hubs->map(function ($hub) {
            return [
                'position' => [
                    'lat' => $hub->gare->latitude,
                    'lng' => $hub->gare->longitude,
                ],
                'draggable' => false,
                'title' => $hub->gare->name,
            ];
        })->toArray();
        $this->options = [
            'center' => [
                'lat' => $centerLat,
                'lng' => $centerLng,
            ],
            'zoom' => 8,
            'zoomControl' => true,
            'minZoom' => 5,
            'maxZoom' => 18,
        ];

    }

    private function defineAllLong()
    {
    }
}

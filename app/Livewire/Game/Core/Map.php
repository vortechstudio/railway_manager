<?php

namespace App\Livewire\Game\Core;

use App\Models\Railway\Ligne\RailwayLigneStation;
use App\Models\User\Railway\UserRailwayHub;
use Livewire\Component;

class Map extends Component
{
    public string $type;
    public $user_hub_id;
    public $user_ligne_id;
    public $user;
    public $initialMarkers;
    public $initialPolygons;
    public $initialPolylines;
    public $initialRectangles;
    public $initialCircles;
    public $options;

    public function mount()
    {
        match ($this->type) {
            "hub" => $this->defineForHub(),
            "lignes" => $this->defineForLignes()
        };
    }

    public function render()
    {
        return view('livewire.game.core.map');
    }

    private function defineForHub()
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
                'title' => 'Tatuí - SP'
            ]
        ];
    }

    private function defineForLignes()
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
                    'title' => $railwayLigneStation->gare->name
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
}

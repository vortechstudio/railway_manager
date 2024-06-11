<?php

namespace App\Livewire\Game\Company;

use App\Models\User\Railway\UserRailway;
use App\Models\User\Railway\UserRailwayCompany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class RankingTable extends Component
{
    use WithPagination;
    public string $search = '';
    public int $perPage = 100;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    private function paginateCollection($collection, int $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $collection instanceof  Collection ? $collection : Collection::make($collection);
        return new LengthAwarePaginator(array_values($items->forPage($page, $perPage)->toArray()), $items->count(), $perPage, $page, $options);
    }

    public function render()
    {
        $users = UserRailway::with('user')
            ->when($this->search, fn(Builder $query) => $query->where('name_company', 'like', '%' . $this->search . '%'))
            ->get()
            ->sortBy('ranking');
        $users = $this->paginateCollection($users, $this->perPage);

        return view('livewire.game.company.ranking-table', [
            "users" => $users,
        ]);
    }
}

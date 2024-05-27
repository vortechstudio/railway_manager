<table class="table table-row-bordered table-striped w-100 rounded-4 bg-primary gap-5 gs-5 gy-5 gx-5 align-middle">
    <thead>
        <tr class="fw-bold fs-2">
            <th>Arret</th>
            <th>Arrivée</th>
            <th>Etat</th>
        </tr>
    </thead>
    <tbody>
    @foreach($planning->stations as $key => $station)
        <tr class="animate__animated animate__slideInRight animate__delay-{{ $key }}">
            <td class="fw-bold fs-2">{{ $station->name }}</td>
            <td class="fs-2">{{ $station->arrival_at->format('H:i') }}</td>
            <td>{!! $station->status_label !!}</td>
        </tr>
    @endforeach
    </tbody>
    @if($station->railwayPlanning->incidents()->where('niveau', '>=', 2)->exists())
        <tfoot class="bg-warning bg-striped">
            <tr class="bg-warning bg-striped">
                <td colspan="3" data-text="{{ $station->railwayPlanning->incidents()->where('niveau', '>=', 2)->first()->designation }}" class="bg-amber-600 w-100 fs-italic fs-4 scrolling-text"></td>
            </tr>
        </tfoot>
    @endif
</table>

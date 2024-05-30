@if(count($datas) > 0)
    <div id="timelinePlanning"></div>
    @push('scripts')
        <script src="//www.google.com/jsapi"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" integrity="sha512-hUhvpC5f8cgc04OZb55j0KNGh4eh7dLxd/dPSJ5VyzqDWxsayYbojWyl5Tkcgrmb/RVKCRJI1jNlRbVP4WWC4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/locale/fr.min.js" integrity="sha512-RAt2+PIRwJiyjWpzvvhKAG2LEdPpQhTgWfbEkFDCo8wC4rFYh5GQzJBVIFDswwaEDEYX16GEE/4fpeDNr7OIZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            let data = {!! $plannings !!}
            google.charts.load('current', {'packages':['timeline']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                let container = document.getElementById('timelinePlanning')
                let chart = new google.visualization.Timeline(container);
                let dataTable = new google.visualization.DataTable();

                dataTable.addColumn({ type: 'string', id: 'President' });
                dataTable.addColumn({ type: 'string', id: 'Ligne' });
                dataTable.addColumn({ type: 'string', role: 'tooltip' });
                dataTable.addColumn({ type: 'date', id: 'Start' });
                dataTable.addColumn({ type: 'date', id: 'End' });
                let rows = [];
                data.forEach(element => {
                    rows.push([element[0], element[1], element[2], moment(element[3]).locale('fr').toDate(), moment(element[4]).locale('fr').toDate()]);
                });
                dataTable.addRows(rows);

                let options = {
                    timeline: { colorByRowLabel: true },
                    avoidOverlappingGridLines: false
                };

                chart.draw(dataTable, options);
            }
        </script>
    @endpush
@else
    <x-base.is-null
        text="Aucune planification programmé actuellement" />
@endif




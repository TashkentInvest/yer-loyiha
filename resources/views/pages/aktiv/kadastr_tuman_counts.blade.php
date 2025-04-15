@extends('layouts.admin')

@section('content')
    <h1 class="mb-4">Хатловда аниқланган активлар туманлар кесимида</h1>

    @if ($districts->count())
        <div class="table-responsive rounded shadow-sm">
            <table id="districts-table" class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Туман ID</th>
                        <th scope="col">Туман номи</th>
                        <th scope="col">Кадастрлар сони</th>
                        <th scope="col">Ҳаракатлар</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($districts as $district)
                        <tr>
                            <td>{{ $district->id }}</td>
                            <td>{{ $district->name_uz ?? 'Номи йўқ' }}</td>
                            <td>{{ $district->aktiv_count }}</td>
                            <td>
                                <!-- Link to the new page to show cadastral details for the district -->
                                <a href="{{ route('aktivs.kadastrByDistrict', ['district_id' => $district->id]) }}" title="{{$district->name_uz}}" 
                                   class="btn btn-primary btn-sm">
                                    Кадастрларни кўриш
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Туманлар топилмади.</p>
    @endif
@endsection

@section('scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#districts-table').DataTable({
                language: {
                    url: '/path_to_local_json/Uzbek.json' // You can adjust this URL or remove it if not needed
                }
            });
        });
    </script>
@endsection

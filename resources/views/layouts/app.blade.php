<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    

    <!-- Scripts -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

</head>
<body class="nav-fixed">
    @include('layouts.sidebar')
        {{-- <style>
            .is-deleted {
                text-decoration: line-through;
                color: red;
            }
        </style> --}}
        <div id="layoutSidenav_content">
            @yield('content')
        </div>
    </div>
   <!-- Include jQuery, Bootstrap, Chart.js, DataTables, Moment.js, and your custom scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{asset('js/chart.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>

<script>
    
//  $(document).ready(function() {
//     $('#dataTable thead th').each(function(index) {
//         var columnId = 'column-' + index; // Generate a unique identifier for each column
//         $(this).html('<div class="d-flex justify-content-between align-items-center"><span>' + $(this).text() + '</span><div class="sorting-icons" id="' + columnId + '"><i class="fas fa-sort-up sort-up" data-index="' + index + '"></i><i class="fas fa-sort-down sort-down" data-index="' + index + '"></i></div></div>');
//     });

//     $('#dataTable').on('click', '.sort-up', function() {
//         var columnIndex = $(this).data('index');
//         var columnId = '#column-' + columnIndex; // Get the unique identifier for the column
//         table.order([columnIndex, 'asc']).draw();
//         resetSortingIcons(columnId);
//         $(this).addClass('active');
//     });

//     $('#dataTable').on('click', '.sort-down', function() {
//         var columnIndex = $(this).data('index');
//         var columnId = '#column-' + columnIndex; // Get the unique identifier for the column
//         table.order([columnIndex, 'desc']).draw();
//         resetSortingIcons(columnId);
//         $(this).addClass('active');
//     });

//     function resetSortingIcons(columnId) {
//         $('.sorting-icons').not(columnId).find('.sort-up, .sort-down').removeClass('active');
//     }
// });


    feather.replace();
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
{{-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> --}}
@stack('scripts')
</body>
</html>

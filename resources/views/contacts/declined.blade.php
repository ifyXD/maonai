@extends('layouts.app')
@section('content')


<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var dataTable = $('#dataTable').DataTable();

        // Search functionality
        $('#search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            dataTable.search(value).draw();
        });

        // Pagination
        $('#dataTable').on('draw.dt', function() {
            var pageInfo = dataTable.page.info();
            var currentPage = pageInfo.page + 1;
            var totalPages = pageInfo.pages;

            $('.dataTables_paginate .paginate_button').removeClass('disabled');

            // Disable previous button if on first page
            if (currentPage === 1) {
                $('.dataTables_paginate .previous').addClass('disabled');
            }

            // Disable next button if on last page
            if (currentPage === totalPages) {
                $('.dataTables_paginate .next').addClass('disabled');
            }
        });

        $('.dataTables_paginate .previous').on('click', function() {
            dataTable.page('previous').draw('page');
        });

        $('.dataTables_paginate .next').on('click', function() {
            dataTable.page('next').draw('page');
        });
    });
</script>

<style>
.custom-gradient {
    background: linear-gradient(to right, #9F1C05, #EF2B08);
}

</style>


<header class="page-header page-header-dark custom-gradient pb-4">
    <div class="container">
        <div class="page-header-content pt-4 d-flex justify-content-between align-items-center">
            <h1 class="page-header-title">
                <div class="page-header-icon">
                    <i data-feather="alert-circle" style="margin-right: 0.25em;"></i> <!-- Adjust margin-right as needed -->
                </div>
                Dashboard: Declined
            </h1>

        </div>
    </div>
</header>


<div class="container mt-4">
    <h1>
        Job Request Managment
        <i data-feather="file-text" style="margin-right: 0.25em;"></i>
    </h1>

    @include('contacts.cards.quartetCard', ['counts' => $counts])

    <div class="card mb-4">
        <!-- Card header with search bar -->
        <div class="card-header" style="background-color: #9F1C05; color: white; border-bottom: 0; display: flex; justify-content: space-between;">
            <div>
                <i data-feather="database" style="margin-right: 0.25em;"></i> <!-- Adjust margin-right as needed -->
                Declined Request
            </div>
        </div>
        <div class="card-body">
            <div class="datatable">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Content</th>
                                <th>Export</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->department }}</td>
                                <td>{{ $contact->content }}</td>
                                <td>
                                    <!-- Action button to export individual request as PDF -->
                                    <div class="action-table-container">
                                        <a href="" class="btn btn-datatable btn-icon btn-transparent-dark">
                                            <i data-feather="aperture"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <!-- Button to trigger the modal for editing request -->
                                    <button type="button" class="btn btn-datatable btn-icon btn-transparent-dark mr-2 edit-request-btn" data-toggle="modal" data-target="#editRequestModal">
                                        <i data-feather="edit"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto footer-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 small">Copyright &copy; Your Website 2021</div>
                <div class="col-md-6 text-md-right small">
                    <a href="#!">Privacy Policy</a>
                    &middot;
                    <a href="#!">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>


</div>




@endsection

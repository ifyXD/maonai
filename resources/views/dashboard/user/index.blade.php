<!-- resources/views/JRMSdashboard.blade.php -->

@extends('layouts.application')

@section('content')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-4">
    <div class="container">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="activity"></i></div>
                        GENERAL SERVICE OFFICE
                    </h1>
                    <div class="page-header-subtitle">WE DELIVER WHAT YOU COMMISSION</div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container mt-4">
    <h1>
        Job Request Management
        <i data-feather="file-text" style="margin-right: 0.25em; width: 1em; height: 1em;"></i>
    </h1>
    <script>
        feather.replace()
    </script>

    <div class="card mb-4">
        <div class="card-header" style="background-image: linear-gradient(to right, #117105, #82AD34); color: white;">
            <div>
                <i data-feather="database" style="margin-right: 0.25em;"></i> Main
            </div>
        </div>
        <!-- Display flash message -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card-body">
            <div class="datatable">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="text-align: center;">Request</th>
                            <th style="text-align: center;">ListView</th>


                            <!-- Add more fields as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <!-- Add more fields as needed -->
                                <td class="text-center" style="width: 50px;">
                                    <div class="d-inline-block">
                                        <a href="{{ route('contacts.create', ['userId' => $user->id]) }}" class="btn btn-sm btn-info open-edit-modal">
                                            <i data-feather="aperture"></i> Insert
                                        </a>
                                    </div>
                                </td>

                                <td class="text-center" style="width: 50px;">
                                    <div class="d-inline-block">
                                        <a href="{{ route("contacts.index") }}" class="btn btn-sm btn-success open-edit-modal">
                                            <i data-feather="airplay"></i> Contact
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Contact</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="editModalBody">
            <!-- Edit form content will be loaded here via AJAX -->
        </div>
    </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.open-edit-modal').click(function() {
        var contactId = $(this).data('contact-id');
        $.ajax({
            url: '/contacts/' + contactId + '/edit?redirect_to=index', // Include redirect_to parameter
            type: 'GET',
            success: function(response) {
                $('#editModalBody').html(response);
                $('#editModal').modal('show');
            },
            error: function(xhr) {
                // Handle error
            }
        });
    });
});
</script>

<!-- Footer -->
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
@endsection

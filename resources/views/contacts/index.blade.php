<!-- resources/views/contacts/index.blade.php -->

@extends('layouts.app')

@section('content')


<!-- Example DataTable for Dashboard Demo-->

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
                <div class="col-12 col-xl-auto mt-4">
                    <button class="btn btn-white p-3" id="reportrange">
                        <i class="mr-2 text-primary" data-feather="calendar"></i>
                        <span></span>
                        <i class="ml-1" data-feather="chevron-down"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>






<div class="container mt-4">

        @include('contacts.cards.quartetCard')

    <div class="card mb-4">
        <!-- Card header with export button -->
        <div class="card-header" style="background-image: linear-gradient(to right, #117105, #82AD34); color: white; border-bottom: 0; display: flex; justify-content: space-between;">
            <div>
                <i data-feather="database" style="margin-right: 0.25em;"></i> <!-- Adjust margin-right as needed -->
                Main
            </div>
        </div>

        <div class="card-body">
            <div class="datatable">

                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Department</th>
                            <th scope="col">Content</th>
                            <th scope="col">Status</th> {{-- New header for Status --}}
                            <th scope="col">Actions</th> {{-- New header for Actions --}}
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
                                <form action="{{ route('contacts.updateStatus', ['contact' => $contact->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="d-flex align-items-center">
                                        <select name="status" class="form-control" style="min-width: 120px;">
                                            <option value="pending" {{ $contact->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="accepted" {{ $contact->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                            <option value="declined" {{ $contact->status === 'declined' ? 'selected' : '' }}>Declined</option>
                                        </select>
                                        <div class="input-group-append ml-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i data-feather="refresh-ccw"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </td>
                            <td>
                                <a href="{{ route('invoices.index', ['contact_id' => $contact->id]) }}" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

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

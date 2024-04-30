<!-- resources/views/contacts/index.blade.php -->

@extends('layouts.landing')

@section('design')


<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <!-- Card header with export button -->
    <div class="card-header" style="background-color: #01A868; color: white; border-bottom: 0; display: flex; justify-content: space-between;">
        <div>Accepted Request</div>
        <div>
            <!-- Export button -->
            <a href=" " class="btn btn-primary">Export as PDF</a>
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
                            <a href="{{ route('invoices.index', ['contact_id' => $contact->id]) }}" class="btn btn-primary">View</a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

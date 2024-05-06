@extends('layouts.app')

@section('content')
<main class="mb-1">

    <header class="page-header page-header-dark bg-teal pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="book"></i></div>
                            All users
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <div class="container mt-n10">
        <div class="card mb-4 mt">
            <div class="card-body">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Plate Number</th>
                            <th scope="col">Type</th>
                            <th scope="col">Driver</th>
                            <th scope="col">Condition</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="date-header">Created at (UTC)</th>
                            <th scope="col" class="date-header">Updated at (UTC)</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>yawa</td>
                            <td>yawa</td>
                            <td>yawa</td>
                            <td>yawa</td>
                            <td>yawa</td>
                            <td>yawa</td>
                            <td>yawa</td>
                            <td>yawa</td>
                            <td>yawa</td>
                            <td>yawa</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>        

@endsection

@push('styles')
@endpush

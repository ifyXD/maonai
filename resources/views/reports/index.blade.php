@extends('layouts.app')
@section('content')

<style>
    /* Add your custom styles here */
</style>

<main class="mb-2">

    <!-- Page Header -->
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-4">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            GENERAL SERVICE OFFICE REPORTS
                        </h1>
                    </div>
                   
                </div>
            </div>
        </div>
    </header>

    <!-- Cards Section -->
    <div class="container mt-4">
        <div class="row">

            <!-- Main Contacts Card -->
            <div class="col-md-6">
                <div class="card mb-4 bg-primary text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">
                                <i data-feather="cpu" style="margin-right: 0.25em;"></i>
                                Fuels 
                            </h5>
                            <a href="/admin/fuel" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">Fuel Cost Total →</span>
                            <div class="rounded-circle bg-white text-primary d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 1rem;"> {{($vehicles)}}
                                {{-- <div class="font-weight-bold">{{ $counts['totalContacts'] }}</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Contacts Card -->
            <div class="col-md-6">
                <div class="card mb-4 bg-warning text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">
                                <i data-feather="pause-circle" style="margin-right: 0.25em;"></i>
                                Mechanics
                            </h5>
                            <a href="/admin/contacts/pending" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">Total of Mechanics →</span>
                            <div class="rounded-circle bg-white text-warning d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                                {{ $mechanicsCount }}
                                                        {{-- <div class="font-weight-bold">{{ $counts['pendingCount'] }}</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accepted Contacts Card -->
            <div class="col-md-6">
                <div class="card mb-4 bg-success text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">
                                <i data-feather="feather" style="margin-right: 0.25em;"></i>
                                Driver
                            </h5>
                            <a href="/admin/drivers" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">Total of Driver →</span>
                            <div class="rounded-circle bg-white text-success d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">{{$driver}}
                                {{-- <div class="font-weight-bold">{{ $counts['acceptedCount'] }}</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Declined Contacts Card -->
            <div class="col-md-6">
                <div class="card mb-4 bg-danger text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">
                                <i data-feather="alert-circle" style="margin-right: 0.25em;"></i>
                                Vehicles
                            </h5>
                            <a href="/admin/vehicle" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">Total of Vehicle →</span>
                            <div class="rounded-circle bg-white text-success d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">{{$vehiclesdata}}
                                {{-- <div class="font-weight-bold">{{ $counts['declinedCount'] }}</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Card 1 -->
            <div class="col-md-6 m-auto">
                <div class="card mb-4 bg-info text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">
                                <i data-feather="info" style="margin-right: 0.25em;"></i>
                                Maintenanances
                            </h5>
                            <a href="/admin/maintenance" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">Maintenances →</span>
                            <div class="rounded-circle bg-white text-info d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;"> {{$maintenance}}
                                {{-- <div class="font-weight-bold">{{ $counts['newCard1Data'] }}</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

       
        </div>
    </div>

</main>

@endsection

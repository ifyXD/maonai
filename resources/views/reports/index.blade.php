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
                                Main
                            </h5>
                            <a href="/admin/contacts" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">Totalization Contacts Requested →</span>
                            <div class="rounded-circle bg-white text-primary d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
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
                                Pending
                            </h5>
                            <a href="/admin/contacts/pending" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">Total of Pending Requests →</span>
                            <div class="rounded-circle bg-white text-warning d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
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
                                Accepted
                            </h5>
                            <a href="/admin/contacts/accepted" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">Total of Accepted Requests →</span>
                            <div class="rounded-circle bg-white text-success d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
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
                                Declined
                            </h5>
                            <a href="/admin/contacts/declined" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">Total of Declined Requests →</span>
                            <div class="rounded-circle bg-black text-white d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                                {{-- <div class="font-weight-bold">{{ $counts['declinedCount'] }}</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Card 1 -->
            <div class="col-md-6">
                <div class="card mb-4 bg-info text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">
                                <i data-feather="info" style="margin-right: 0.25em;"></i>
                                New Card 1
                            </h5>
                            <a href="#" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">New Card 1 Data →</span>
                            <div class="rounded-circle bg-white text-info d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                                {{-- <div class="font-weight-bold">{{ $counts['newCard1Data'] }}</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Card 2 -->
            <div class="col-md-6">
                <div class="card mb-4 bg-secondary text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">
                                <i data-feather="archive" style="margin-right: 0.25em;"></i>
                                New Card 2
                            </h5>
                            <a href="#" class="btn btn-light">View Info</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="mr-2">New Card 2 Data →</span>
                            <div class="rounded-circle bg-white text-secondary d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                                {{-- <div class="font-weight-bold">{{ $counts['newCard2Data'] }}</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- New Card 3 -->
<div class="col-md-6">
    <div class="card mb-4 bg-info text-white">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title text-white">
                    <i data-feather="info" style="margin-right: 0.25em;"></i>
                    New Card 3
                </h5>
                <a href="#" class="btn btn-light">View Info</a>
            </div>
            <div class="d-flex align-items-center">
                <span class="mr-2">New Card 3 Data →</span>
                <div class="rounded-circle bg-white text-info d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{-- <div class="font-weight-bold">{{ $counts['newCard3Data'] }}</div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Card 4 -->
<div class="col-md-6">
    <div class="card mb-4 bg-secondary text-white">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title text-white">
                    <i data-feather="archive" style="margin-right: 0.25em;"></i>
                    New Card 4
                </h5>
                <a href="#" class="btn btn-light">View Info</a>
            </div>
            <div class="d-flex align-items-center">
                <span class="mr-2">New Card 4 Data →</span>
                <div class="rounded-circle bg-white text-secondary d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{-- <div class="font-weight-bold">{{ $counts['newCard4Data'] }}</div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>

</main>

@endsection

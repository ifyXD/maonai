
<style>
    .bg-primary {
        background: linear-gradient(to right, #117105, #7BA931);
    }

    .bg-warning {
        background: linear-gradient(to right, #FF9800, #FFC107);
    }

    .bg-success {
        background: linear-gradient(to right, #01A868, #8BC34A);
    }

    .bg-danger {
        background: linear-gradient(to right, #9F1C05, #EF2B08);
    }
</style>

<main>


    <div class="row">


        <div class="col-md-6">
            <!-- Main Contacts Card -->
            <div class="card mb-4 bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-white">
                            <i data-feather="cpu" style="margin-right: 0.25em;"></i>
                            Main
                        </h5>
                        <a href="/contacts" class="btn btn-light">View Info</a>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="mr-2">Totalization Contacts Requested →</span>
                        <div class="rounded-circle bg-white text-primary d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <div class="font-weight-bold">{{ $counts['totalContacts'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <!-- Pending Contacts Card -->
            <div class="card mb-4 bg-warning text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-white">
                            <i data-feather="pause-circle" style="margin-right: 0.25em;"></i>
                            Pending
                        </h5>
                        <a href="/contacts/pending" class="btn btn-light">View Info</a>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="mr-2">Total of Pending Requests →</span>
                        <div class="rounded-circle bg-white text-warning d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <div class="font-weight-bold">{{ $counts['pendingCount'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Accepted Contacts Card -->
            <div class="card mb-4 bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-white">
                            <i data-feather="feather" style="margin-right: 0.25em;"></i>
                            Accepted
                        </h5>
                        <a href="/contacts/accepted" class="btn btn-light">View Info</a>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="mr-2">Total of Accepted Requests →</span>
                        <div class="rounded-circle bg-white text-success d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <div class="font-weight-bold">{{ $counts['acceptedCount'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Declined Contacts Card -->
            <div class="card mb-4 bg-danger text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title text-white">
                            <i data-feather="alert-circle" style="margin-right: 0.25em;"></i>
                            Declined
                        </h5>
                        <a href="/contacts/declined" class="btn btn-light">View Info</a>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="mr-2">Total of Declined Requests →</span>
                        <div class="rounded-circle bg-black text-white d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 2rem;">
                            <div class="font-weight-bold">{{ $counts['declinedCount'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>





</main>



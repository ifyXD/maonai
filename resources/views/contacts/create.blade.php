@extends('layouts.app')

@section('content')

<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-6">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-5">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="layers"></i></div>
                            Technical Request
                        </h1>
                        <div class="page-header-subtitle">WE DELIVER WHAT YOU COMMISSION</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->

    <div class="container mt-n10">

        <section id="contacts">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-feather-alt"></i> JOB REQUEST FORM
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <form method="POST" action="{{ route('contacts.insert', ['userId' => $user->id]) }}">
                                @csrf <!-- CSRF protection -->
                                <!-- Form Group (contact name)-->
                                <div class="form-group">
                                    <label class="small mb-1" for="name">Identification (Full Name)</label>
                                    <input class="form-control" id="name" type="text" placeholder="Enter your name" name="name" required>
                                </div>
                                <!-- Form Row-->
                                <div class="form-row">
                                    <!-- Form Group (contact email)-->
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="email">Email (Institutional Email)</label>
                                        <input class="form-control" id="email" type="email" placeholder="Enter your email address" name="email" required>
                                    </div>
                                    <!-- Form Group (department)-->
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="department">Department (Office/Unit/Organization)</label>
                                        <input class="form-control" id="department" type="text" placeholder="Enter Department" name="department">
                                    </div>
                                </div>
                                <!-- Request Type -->
                                <div class="form-group" style="margin-bottom: 1.5rem;">
                                    <label class="small mb-1">Request Type:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="request_type[]" id="repair" value="repair">
                                        <label class="form-check-label" for="repair">Repair/Maintenance</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="request_type[]" id="service" value="service">
                                        <label class="form-check-label" for="service">Service</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="request_type[]" id="commission" value="commission">
                                        <label class="form-check-label" for="commission">Commission</label>
                                    </div>
                                </div>
                                <!-- Content Comment Section -->
                                <div class="form-group">
                                    <label class="small mb-1" for="content">Other</label>
                                    <textarea class="form-control" id="content" placeholder="Enter any additional comments or requests" name="content"></textarea>
                                </div>
                                <!-- Save changes button-->
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <span class="ml-auto" style="font-family: 'Times New Roman', serif; font-weight:  font-style: italic;">Wish to Check Your Progress? <a href="/users/dashboard">Click Here!</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

</main>
@endsection

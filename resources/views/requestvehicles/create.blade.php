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
                                Create Request
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container mt-n10">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('request-store.user')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="{{ Auth::user()->username }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Vehicle</label>
                                    <select class="form-control" id="type" name="vehicle_id" required>
                                        <option value="" selected disabled>Select Vehicle</option>
                                        @foreach ($vehicle as $vehicle)
                                            <option value="{{ $vehicle->id }}"
                                                data-platenumber="{{ $vehicle->platenumber }}"
                                                data-condition="{{ $vehicle->condition }}">{{ $vehicle->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="platenumber" class="form-label">Platenumber</label>
                                    <input type="text" class="form-control" id="platenumber" name="platenumber" required
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" class="form-control" id="capacity" name="capacity" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="purpose" class="form-label">Purpose</label>
                                    <input type="text" class="form-control" id="purpose" name="purpose" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appointment" class="form-label">Appointment</label>
                                    <input type="datetime-local" class="form-control" id="appointment" name="appointment" required>
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appointment_end" class="form-label">End of Appointment</label>
                                    <input type="datetime-local" class="form-control" id="appointment_end" name="appointment_end" required>
                                </div>
                            </div> 
                        </div> 

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#type').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var selectedPlatenumber = selectedOption.data('platenumber');
                var selectedCondition = selectedOption.data('condition');
                $('#platenumber').val(selectedPlatenumber);
                $('#condition').val(selectedCondition);

            });
        });

        $('#createUserForm').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior

            let ufname = $('#ufname').val();
            let uname = $('#uname').val();
            let lname = $('#lname').val();
            let address = $('#address').val();
            let contact = $('#contact').val();
            let username = $('#username').val();
            let password = $('#password').val();
            console.log(ufname + uname + lname + address + contact + username + password);
            $.ajax({
                type: 'post',
                url: '/admin/addnewuser',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'ufname': ufname,
                    'uname': uname,
                    'lname': lname,
                    'address': address,
                    'contact': contact,
                    'username': username,
                    'password': password,
                },
                success: function(data) {
                    if (data.message === 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'User added successfully.',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            // Reload the page
                            location.reload();
                        });
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON.message;
                    if (errorMessage) {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while adding the user'
                        });
                    }
                }
            });

            // Reset the form after submission
            $('#createUserForm')[0].reset();
        });
    </script>
    
@endpush

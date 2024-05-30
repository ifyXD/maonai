@extends('layouts.app')
<style>
    #calendar {
        max-width: 900px;
        /* Adjust the max-width as needed */
        margin: 0 auto;
        height: 600px;
        /* Set a fixed height */
    }
</style>
@section('content')
    <main class="mb-1">
        <header class="page-header page-header-dark bg-teal pb-10">
            <div class="container">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="book"></i></div>
                                @php
                                    $my_id = $myrequest->id ?? null;
                                @endphp
                                {{ $my_id == null ? 'Create Request' : 'Update Request' }}
                            </h1>

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container mt-n10">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('request-store.user') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <div id='calendar' class="w-75"></div>
                            </div>
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
                                    <select name="vehicle_id" id="vehicle_id" class="form-control">
                                        <option value="" selected disabled>Select Vehicle</option>
                                        @foreach ($vehicles as $vehicle)
                                            @php
                                                $vehicle_id = $myrequest->vehicle_id ?? null;
                                                $hasPendingRequest =
                                                    isset($pendingOrAcceptedRequests[$vehicle->id]) &&
                                                    $pendingOrAcceptedRequests[$vehicle->id]
                                                        ->where('user_id', $userId)
                                                        ->isNotEmpty();
                                                $hasAcceptedRequestForOtherUsers = isset(
                                                    $acceptedRequestsForOtherUsers[$vehicle->id],
                                                );
                                                $isDisabled = $hasPendingRequest || $hasAcceptedRequestForOtherUsers;
                                            @endphp
                                            <option value="{{ $vehicle->id }}"
                                                data-platenumber="{{ $vehicle->platenumber }}"
                                                data-condition="{{ $vehicle->condition }}"
                                                {{ $vehicle->id == $vehicle_id ? 'selected' : '' }}
                                                {{ $isDisabled ? 'disabled' : '' }}>
                                                {{ $vehicle->type }} {{ $isDisabled ? '(Not Available)' : '' }}
                                            </option>
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
                                    <input type="hidden" name="id" value="{{ $myrequest->id ?? null }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" value="{{ $myrequest->capacity ?? null }}" class="form-control"
                                        id="capacity" name="capacity" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="purpose" class="form-label">Purpose</label>
                                    <input type="text" value="{{ $myrequest->purpose ?? null }}" class="form-control"
                                        id="purpose" name="purpose" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appointment" class="form-label">Appointment</label>
                                    <input type="datetime-local" value="{{ $myrequest->appointment ?? null }}"
                                        class="form-control" id="appointment" name="appointment" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appointment_end" class="form-label">End of Appointment</label>
                                    <input type="datetime-local" value="{{ $myrequest->appointment_end ?? null }}"
                                        class="form-control" id="appointment_end" name="appointment_end" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit"
                                    class="btn btn-primary">{{ $myrequest == null ? 'Submit' : 'Update' }}</button>
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
        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');

            $.ajax({
                url: '/user/request-events/',
                method: 'GET',
                success: function(events) {
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        events: events,
                        dateClick: function(info) {
                            // Check if the date is in the list of "Not Available" dates
                            var isNotAvailable = events.some(event => event.start === info
                                .dateStr);
                            if (isNotAvailable) {
                                alert('This date is not available.');
                                return;
                            }
                            alert('Clicked on: ' + info.dateStr);
                        }
                    });
                    calendar.render();
                },
                error: function(error) {
                    console.error('There was a problem with the AJAX request:', error);
                }
            });


            // Get the current date and time
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            // Format the date and time for the datetime-local input
            const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

            // Set the min attribute to the current date and time
            document.getElementById('appointment').setAttribute('min', currentDateTime);
            document.getElementById('appointment_end').setAttribute('min', currentDateTime);
        });


        selectedVehicle();

        function selectedVehicle() {


            $('#platenumber').val($('#type').find('option:selected').data('platenumber'));


        }
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
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/user/request-events/',
                method: 'GET',
                success: function(events) {
                    var unavailableDates = events.map(event => event.start);

                    $('#appointment').on('change', function(event) {
                        var selectedDate = new Date(event.target.value).toISOString().split(
                            'T')[0];
                        if (unavailableDates.includes(selectedDate)) {
                            alert('This date is not available.');
                            event.target.value = '';
                        }
                    });

                    $('#appointment_end').on('change', function(event) {
                        var selectedDate = new Date(event.target.value).toISOString().split(
                            'T')[0];
                        if (unavailableDates.includes(selectedDate)) {
                            alert('This date is not available.');
                            event.target.value = '';
                        }
                    });
                },
                error: function(error) {
                    console.error('There was a problem with the AJAX request:', error);
                }
            });
        });
    </script>
@endpush

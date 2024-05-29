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
                                Maintenances
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container mt-n10">
            <div class="card mb-4">
                <div class="card-header">
                    <button type="button" class="btn btn-transparent-dark" data-toggle="modal"
                        data-target="#addNewMaintenance">
                        <div>
                            <i data-feather="plus-square"></i>
                            Add Maintenance
                        </div>
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="datatable" width="100%" cellspacing="1">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Evaluation</th>
                                <th scope="col">Time Finished</th>
                                <th scope="col">Condition</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Updated at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </main>

    <div class="modal fade" id="addNewMaintenance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="createMaintenanceForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Maintenance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div class="mb-1">
                            <label for="evaluation" class="form-label">Vehicle Name</label>
                            <select name="vehicle" class="form-control" id="vehicle">
                                <option value="" selected disabled>Select Vehicle</option>
                                @foreach ($vehicles as $item)
                                    <option value="{{ $item->id }}">{{ ucfirst($item->type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-1">
                            <label for="evaluation" class="form-label">Evaluation</label>
                            <input type="text" class="form-control" id="evaluation" name="evaluation">
                        </div>

                        <div class="mb-1">
                            <label for="condition" class="form-label">Condition</label>
                            <input type="text" class="form-control" id="condition" name="condition">
                        </div>

                        <div class="mb-1">
                            <label for="timestarted" class="form-label">Time and Date Started</label>
                            <input type="datetime-local" class="form-control" id="timestarted" name="timestarted">
                        </div>
                        <div class="mb-1">
                            <label for="timefinish" class="form-label">Time and Date Finished</label>
                            <input type="datetime-local" class="form-control" id="timefinish" name="timefinish">
                        </div>

                        <div class="mb-1">
                            <label for="status" class="form-label">Status</label>
                            {{-- <input type="text" class="form-control" value="pending" id="status" name="status"> --}}
                            <select name="status" class="form-control" id="status">
                                <option value="" disabled>Select an option</option>
                                <option value="pending" selected>Pending</option>
                                <option value="ongoing">Ongoing Maintenance</option>
                                <option value="completed">Completed Maintenance</option>
                            </select>
                        </div>

                        <hr>
                        <div class="text-center">
                            <h4 class="text-info">
                                -- SELECT MECHANIC/S --
                            </h4>
                        </div>
                        <div class="mb-1">
                            <div class="table-responsive">
                                <table class="table" id="mechanicsTable">
                                    <thead>
                                        <tr>
                                            <th>Mechanic Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <thead id="tbodypart">
                                        <tr>
                                            <td>
                                                <select class="form-control mechanicSelect" name="mechanic"
                                                    id="mechanicSelect">
                                                    <option value="">Select Mechanic</option>
                                                </select>
                                            </td>
                                            <td><button type="button"
                                                    class="btn btn-primary rounded-pill addRowBtn">+</button></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="createMaintenanceBtn" class="btn btn-primary mr-auto">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let mechanics = @json($mechanics);

        function populateMechanicSelect(selectElement) {
            $.each(mechanics, function(index, mechanic) {
                selectElement.append($('<option>', {
                    value: mechanic.id,
                    text: mechanic.mechanics_name
                }));
            });
        }

        populateMechanicSelect($('.mechanicSelect'));

        // Add new row when the addRowBtn is clicked
        $('#mechanicsTable').on('click', '.addRowBtn', function() {
            let newRow = `<tr> 
                            <td>
                                <select class="form-control mechanicSelect" name="mechanic">
                                    <option value="">Select Mechanic</option>
                                   
                                </select>
                            </td>
                            <td><button type="button" class="btn btn-danger rounded-pill removeBtn">x</button></td>
                        </tr>`;
            $('#mechanicsTable #tbodypart').append(newRow);
            // Populate the new select element with mechanics data
            populateMechanicSelect($('#mechanicsTable #tbodypart tr:last .mechanicSelect'));
        });


        $('#mechanicsTable').on('click', '.removeBtn', function() {
            $(this).closest('tr').remove();
        });


        $('option[value="decline"]').hide();

        maintenance();

        function formatDate(dateString) {
            var date = new Date(dateString);
            var monthNames = [
                "Jan", "Feb", "Mar",
                "Apr", "May", "Jun", "Jul",
                "Aug", "Sep", "Oct",
                "Nov", "Dec"
            ];
            var day = date.getDate();
            var monthIndex = date.getMonth();
            var year = date.getFullYear();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';

            // Convert hours from 24-hour to 12-hour format
            hours = hours % 12;
            hours = hours ? hours : 12; // Handle midnight (0 hours)

            // Pad the hours, minutes, and seconds with leading zeros if needed
            minutes = minutes < 10 ? '0' + minutes : minutes;

            return monthNames[monthIndex] + ' ' + day + ', ' + year + ' ' + hours + ':' + minutes + ' ' + ampm;
        }

        function maintenance() {
            $('#datatable').DataTable().destroy();
            $('tbody').empty();
            $.ajax({
                type: 'get',
                url: '/admin/maintenancedata',
                success: function(data) {
                    // Assuming data is an array of user objects
                    $.each(data.maintenances, function(index, maintenance) {
                        var key = index + 1;
                        var ifdel = maintenance.isdel === 'deleted' ? 'is-deleted' : '';

                        var action = maintenance.isdel === 'active' ?
                            `<a href="#" class="editMaintenance" data-id="${maintenance.id}" data-bs-toggle="modal" data-bs-target="#maintenanceEdit${maintenance.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                                
                                <a href="#" onclick="confirmDelete(${maintenance.id});" id="deleteMaintenance">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>
                                </a>` :
                            `<span class="text-danger">Deleted</span>`;

                        // Append the row to the table body
                        let row = `
                            <tr class="${ifdel}" id="trId${maintenance.id}">
                                <td>${key}</td>
                                <td id="evaluationId${maintenance.id}">${maintenance.evaluation}</td>
                                <td id="timefinishId${maintenance.id}">${formatDate(maintenance.timefinish)}</td>
                                <td id="conditionId${maintenance.id}">${maintenance.condition}</td>
                                <td id="statusId${maintenance.id}">${maintenance.status}</td>
                                <td id="createdAtId${maintenance.id}">${formatDate(maintenance.created_at)}</td>
                                <td id="updatedAtId${maintenance.id}">${formatDate(maintenance.updated_at)}</td>
                                <td>
                                    ${action}
                                                <div class="modal fade" data-id="${maintenance.id}" id="maintenanceEdit${maintenance.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit maintenances</h1>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <i class="fas fa-times"></i>
                                                        </button>
                                                            </div>
                                                            <div class="modal-body"> 
                                                                <div class="mb-3">
                                                                    <label for="evaluation" class="form-label">Vehicle Name</label>
                                                                    <select name="editvehicle" class="form-control" id="editvehicle${maintenance.id}">
                                                                        <option value="" selected disabled>Select Vehicle</option>
                                                                        @foreach ($vehicles as $item)
                                                                            <option ${maintenance.vehicle_id == {{ $item->id }} ? 'selected' : ''} value="{{ $item->id }}">{{ ucfirst($item->type) }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="editevaluation${maintenance.id}" class="form-label">Evaluation</label>
                                                                    <input type="text" value="${maintenance.evaluation}" class="form-control" id="editevaluation${maintenance.id}" aria-describedby="emailHelp"> 
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="editcondition${maintenance.id}" class="form-label">Condition</label>
                                                                    <input type="text" value="${maintenance.condition}" class="form-control" id="editcondition${maintenance.id}" aria-describedby="emailHelp"> 
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edittimestarted${maintenance.id}" class="form-label">Time and Date Started</label>
                                                                    <input type="datetime-local" value="${maintenance.timestarted}" class="form-control" id="edittimestarted${maintenance.id}" aria-describedby="emailHelp"> 
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edittimefinish${maintenance.id}" class="form-label">Time and Date Finished</label>
                                                                    <input type="datetime-local" value="${maintenance.timefinish}" class="form-control" id="edittimefinish${maintenance.id}" aria-describedby="emailHelp"> 
                                                                </div>
                                                              
                                                                <div class="mb-1">
                                                                <label for="editstatus" class="form-label">Status</label>
                                                                <select name="status" id="status${maintenance.id}"  class="form-control" required>
                                                                    <option ${maintenance.status == 'pending' ? 'selected' : ''} value="pending">Pending</option>
                                                                    <option ${maintenance.status == 'ongoing' ? 'selected' : ''} value="ongoing">Ongoing Maintenance</option>
                                                                    <option ${maintenance.status == 'completed' ? 'selected' : ''} value="completed">Completed Maintenance</option>
                                                                </select>
                                                            </div>

                                                            <hr>
                                                            <div class="text-center">
                                                                    <h4 class="text-info">
                                                                        -- SELECT MECHANIC/S --
                                                                    </h4>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <div class="table-responsive">
                                                                        <table class="table" id="mechanicsTable${maintenance.id}">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Mechanic Name</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <thead id="tbodypart${maintenance.id}">
                                                                                <tr>
                                                                                    <td>
                                                                                        <select class="form-control editMechanicSelect mechanicSelect${maintenance.id}" name="mechanic"
                                                                                            id="mechanicSelec${maintenance.id}t">
                                                                                            <option value="">Select Mechanic</option>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td><button type="button" onclick="editAddRowBtn(${maintenance.id}, $(this));" class="btn btn-primary rounded-pill editaddRowBtn">+</button></td>
                                                                                </tr>
                                                                            </thead>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" id="editSaveBtn" data-id="${maintenance.id}">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                </td>
                            </tr>`;
                        // Append the row to the 


                        $('tbody').append(row);
                    });
                    $('#datatable').DataTable();


                }

            });
        }

        function deleteUser(userid) {
            $.ajax({
                type: 'post',
                url: '/admin/maintenance/deletebyid',
                data: {
                    'id': userid
                },
                success: function(data) {

                    maintenance();
                },
                error: function(xhr, status, error) {


                    console.log(xhr);

                }


            });
        }

        function editAddRowBtn(id, element) {
            let mechanicsa = @json($mechanics);

            // Build the options string
            let options = '<option value="" disabled selected>Select Mechanic</option>';
            $.each(mechanicsa, function(index, mechanic) {
                options += `<option value="${mechanic.id}">${mechanic.mechanics_name}</option>`;
            });

            // Append the new row with the mechanics options
            $(`#tbodypart${id}`).append(`
                <tr class="subtr${id}">
                    <td>
                        <select name="mechanic" class="form-control editMechanicSelect mechanicSelect${id} mechanicSelectSub${id}">
                            ${options}
                        </select>
                    </td>
                    <td>
                        <button type="button" onclick="editRemove(${id}, $(this));" class="btn btn-danger rounded-pill editremoveBtn">x</button>
                    </td>
                </tr>
            `);
        }


        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",

                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Call your delete function here
                    deleteUser(id);

                    Swal.fire({
                        title: 'Deleted!',
                        text: 'User has been deleted.',
                        icon: 'success',
                        timer: 1500, // 2 seconds
                        timerProgressBar: true
                    }).then(() => {
                        // Reload the page or do any other necessary action
                        location.reload();
                    });
                }
            });
        }

        function getSelectedMechanicIds() {
            let selectedIds = new Set();
            $('.mechanicSelect').each(function() {
                let selectedId = $(this).val();
                if (selectedId !== "") {
                    selectedIds.add(selectedId);
                }
            });
            return Array.from(selectedIds);
        }
        function edditgetSelectedMechanicIds(id) {
            let selectedIds = new Set();
            $(`.mechanicSelect${id}`).each(function() {
                let selectedId = $(this).val();
                if (selectedId !== "") {
                    selectedIds.add(selectedId);
                }
            });
            return Array.from(selectedIds);
        }


        function formatErrors(errors) {
            let errorMessage = '';
            for (const field in errors) {
                if (errors.hasOwnProperty(field)) {
                    errorMessage += `${errors[field].join(', ')}<br>`;
                }
            }
            return errorMessage;
        }

        function createmaintenance(vehicle_id, evaluation, timestarted, timefinish, condition, status, callback) {
            let selectedMechanicIds = getSelectedMechanicIds();
            $.ajax({
                type: 'post',
                url: '/admin/addmaintenance',
                data: {
                    'vehicle_id': vehicle_id,
                    'evaluation': evaluation,
                    'timestarted': timestarted,
                    'timefinish': timefinish,
                    'condition': condition,
                    'status': status,
                    'mechanic_ids': selectedMechanicIds,

                },
                success: function(data) {
                    console.log(data);
                    if (data.message === 'success') {
                        $('#messageflash').text('Maintenances added successfully');
                        callback(true); // Invoke the callback with true indicating success
                    }
                },
                error: function(xhr, status, error) {
                    // Log the error to the console for debugging
                    console.log(xhr.responseText);

                    // Parse the response JSON to extract errors
                    var response = xhr.responseJSON;
                    if (response && response.errors) {
                        var formattedErrors = formatErrors(response.errors);
                        Swal.fire("Error!", formattedErrors, "error");
                    } else if (response && response.message) {
                        Swal.fire("Error!", response.message, "error");
                    } else {
                        Swal.fire("Error!", "An error occurred while adding the fuel.", "error");
                    }

                    callback(false); // Invoke the callback with false indicating failure
                }
            });
        }

        function editRemove(id, element) {
            $(`#mechanicsTable${id}`).on('click', '.editremoveBtn', function() {
                $(element).closest('tr').remove();
            });

        }
    </script>

    {{-- jquery code --}}
    <script>
        $('#createMaintenanceBtn').on('click', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior

            let vehicle_id = $('#vehicle').val();
            let evaluation = $('#evaluation').val();
            let timestarted = $('#timestarted').val();
            let timefinish = $('#timefinish').val();
            let condition = $('#condition').val();
            let status = $('#status').val();



            createmaintenance(vehicle_id, evaluation, timestarted, timefinish, condition, status, function(
                success) {
                if (success === true) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: " Maintenance Added successfully.",
                        showConfirmButton: true,
                        timer: 1500, // 2 seconds
                        timerProgressBar: true,

                    }).then(() => {
                        $('#evaluation').val('');
                        $('#timefinish').val('');
                        $('#condition').val('');
                        $('#status').val('');


                        // Redirect to the same page to refresh
                        location.reload();
                    });
                }
            });
        });

        $('tbody').on('click', '.editMaintenance', function() {
            // Get the id of the maintenance record to edit
            let id = $(this).data('id');

            // Show the edit modal
            $(`#maintenanceEdit${id}`).modal('show');

            // Get the current maintenance data
            let evaluation = $(`#editevaluation${id}`).val();
            let timefinish = $(`#edittimefinish${id}`).val();
            let condition = $(`#editcondition${id}`).val();
            let status = $(`#status${id}`).val();

            // Update the modal inputs with the current maintenance data
            $(`#editevaluation${id}`).val(evaluation);
            $(`#edittimefinish${id}`).val(timefinish);
            $(`#editcondition${id}`).val(condition);
            $(`#status${id}`).val(status);

            $.ajax({
                type: 'get',
                url: '/admin/getmechanic_maintenances',
                data: {
                    'id': id,
                },
                success: function(response) {
                    let first = response.mechanics_main[0].mechanic_id;
                    let filteredMechanics = response.mechanics_main.filter(mechanic => mechanic
                        .mechanic_id !== first);

                    let eachMechanicOptions = '';
                    let mechanicsa = @json($mechanics);

                    $(`.mechanicSelect${id}`).empty(); // Clear existing options
                    $(`.subtr${id}`).empty(); // Clear existing options

                    // Add the default option
                    $(`.mechanicSelect${id}`).append($('<option>', {
                        value: '',
                        text: 'Select Mechanic',
                        disabled: true,
                    }));

                    // Add mechanic options and select the first mechanic if it matches
                    $.each(mechanicsa, function(index, mechanic) {
                        $(`.mechanicSelect${id}`).append($('<option>', {
                            value: mechanic.id,
                            text: mechanic.mechanics_name,
                            selected: mechanic.id === first
                        }));
                    });

                    // Generate options string for mechanics
                    $.each(mechanicsa, function(index, mechanic) {
                        eachMechanicOptions +=
                            `<option value="${mechanic.id}">${mechanic.mechanics_name}</option>`;
                    });

                    // Generate rows for each filtered mechanic
                    let rows = '';
                    $.each(filteredMechanics, function(index, filteredMechanic) {
                        let optionsWithSelected = mechanicsa.map(mechanic => {
                            let selected = (filteredMechanic.mechanic_id === mechanic
                                .id) ? 'selected' : '';
                            return `<option value="${mechanic.id}" ${selected}>${mechanic.mechanics_name}</option>`;
                        }).join('');

                        rows += `
                                <tr class="subtr${id}">
                                    <td>
                                        <select name="mechanic" class="form-control editMechanicSelect mechanicSelect${id} mechanicSelectSub${id}">
                                            <option value="" selected disabled>Select Mechanic</option>
                                            ${optionsWithSelected}
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" onclick="editRemove(${id}, $(this));" class="btn btn-danger rounded-pill editremoveBtn">x</button>
                                    </td>
                                </tr>`;
                    });

                    // Append generated rows to the tbody
                    $(`#tbodypart${id}`).append(rows);
                },

                error: function(xhr, status, error) {
                    console.log(xhr);
                    // Handle the error response
                    // Swal.fire("Error!", "Failed to update maintenance: " + xhr.responseJSON.message,
                    //     "error");
                }
            });
        });

        // Save button click event listener
        $('tbody').on('click', '#editSaveBtn', function() {
            // Get the id of the maintenance record being edited
            let id = $(this).data('id');

            // Get the updated values from the modal inputs
            let vehicle_id = $(`#editvehicle${id}`).val();
            let evaluation = $(`#editevaluation${id}`).val();
            let condition = $(`#editcondition${id}`).val();
            let timestarted = $(`#edittimestarted${id}`).val();
            let timefinish = $(`#edittimefinish${id}`).val();
            let status = $(`#status${id}`).val();

            console.log(evaluation + timefinish + condition + status);
            let selectedMechanicIds = edditgetSelectedMechanicIds(id);

            // Send the data to the server using AJAX
            $.ajax({
                type: 'post',
                url: '/admin/editbyid-maintenance',
                data: {
                    'id': id,
                    'vehicle_id': vehicle_id,
                    'evaluation': evaluation,
                    'timestarted': timestarted,
                    'timefinish': timefinish,
                    'condition': condition,
                    'status': status,
                    'mechanic_ids': selectedMechanicIds,
                },
                success: function(response) {
                    // Handle the success response
                    Swal.fire({
                        title: 'Success!',
                        text: 'Maintenance updated successfully.',
                        icon: 'success',
                        timer: 1500, // 2 seconds
                        timerProgressBar: true,
                        didClose: () => {
                            // Reload the page to reflect the changes
                            maintenance();
                        }
                    });
                    $(`#maintenanceEdit${id}`).modal('hide');
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    Swal.fire("Error!", "Failed to update maintenance: " + xhr.responseJSON.message,
                        "error");
                }
            });

        });

        $(document).on('click', '[data-bs-dismiss="modal"]', function() {
            $(this).closest('.modal').modal('hide');
        });
        $(document).on('click', '.editaddRowBtn', function() {
            console.log($(this).closest('.modal').data('id'));
        });
    </script>
@endpush

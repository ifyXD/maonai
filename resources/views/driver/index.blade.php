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
                           Drivers
                       </h1>
                   </div>
               </div>
           </div>
       </div>
   </header>
   
       <body>
           
           
   
       <div class="container mt-n10">
           
               <div class="card mb-4">
                   
                   <div class="card-header">
                       
                       
                       <button type="button" class="btn btn-transparent-dark" data-toggle="modal" data-target="#addNewVehicle">
                           <div>
                               <i data-feather="plus-square"></i>
                               Add Driver
                           </div>
                       </button>
                       
                   </div>
                   <div class="card-body">
                       
                       
                       <div class="datatable">
                           <div class="modal fade" id="addNewVehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                               <div class="modal-dialog">
                                   <form>
                                       @csrf
                                       <div class="modal-content create-new-vehicle-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Driver</h1>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
    
                                            <div class="mb-3">
                                                <label for="driver_name" class="form-label">Driver Name</label>
                                                <input type="text" class="form-control" id="driver_name" name="driver_name"
                                                    placeholder="Driver Name" required>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="contact" class="form-label">Contact</label>
                                                <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact"
                                                    required>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                                    required>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="driver_license" class="form-label">Driver License</label>
                                                <input type="text" class="form-control" id="driver_license" name="driver_license"
                                                    placeholder="Driver License" required>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <textarea class="form-control" id="address" name="address" rows="3"
                                                    placeholder="Address" required></textarea>
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="pending">Pending</option>
                                                    <option value="Active">Active</option>
                                                    <option value="InActive">InActive</option>
                                                </select>
                                            </div>
                           
                                            <button type="submit" id="createDriverBtn" class="btn btn-primary">Create</button>                                           </div>
                                       </div>
                                   </form>
                               </div>
                           </div>
                           </div>
   
                           <table class="table table-bordered table-hover" id="dataTable"width="100%" cellspacing="1">
                               <thead>
                                   <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Driver Name</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Driver License</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Update</th>
                                    <th scope="col">Action</th>
                                   </tr>
                               </thead>
      
   
                           </table>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>    
   </main>        

@endsection
@push('scripts')
    {{-- ajax crud --}}
    <script>
  tae();

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

        function tae() {
            $('#dataTable').DataTable().destroy();
            $('tbody').empty();
            $.ajax({
                type: 'get',
                url: '/admin/driverve',
                success: function(data) {
                    // Assuming data is an array of user objects
                    $.each(data.drivers, function(index, driver) {
                        var key = index + 1;
                        var ifdel = driver.isdel === 'deleted' ? 'is-deleted' : '';

                        var action = driver.isdel === 'active' ?

                        
    `<a href="#" class="editDriver" data-id="${driver.id}" data-bs-toggle="modal" data-bs-target="#driverEdit${driver.id}">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
        </svg>
    </a>
    <a href="#" onclick="confirmDelete(${driver.id});" id="deleteUserId">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
        </svg>
    </a>` :
    `<span class="text-danger">Deleted</span>`;
// Assuming user has properties like id, name, email, etc.
let row =
    `<tr class="${ifdel}" id="trId${driver.id}">
        <td > ${key }</td>
        <td id="driver_nameId${driver.id}"> ${driver.driver_name}</td>
        <td id="contactId${driver.id}"> ${driver.contact} </td>
        <td id="emailId${driver.id}"> ${driver.email}</td>
        <td id="driver_licenseId${driver.id}"> ${driver.driver_license} </td>
        <td id="addressId${driver.id}"> ${driver.addressId}</td>
        <td id="statusId${driver.id}"> ${driver.status} </td> 
        <td id="createdAtId${driver.id}">${formatDate(driver.created_at)}</td>
        <td id="updatedAtId${driver.id}">${formatDate(driver.updated_at)}</td>
        <td> 
            ${action}
            <div class="modal fade" id="driverEdit${driver.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Vehicle</h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <i class="fas fa-times"></i>
</button>
                        </div>
                        <div class="modal-body"> 
                            <div class="mb-3">
                                <label for="editdriver_name${driver.id}" class="form-label">Driver Name</label>
                                <input type="text" value="${driver.driver_name}" class="form-control" id="editdriver${driver.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editcontact${driver.id}" class="form-label">Contact</label>
                                <input type="number" value="${driver.contact}" class="form-control" id="editcontact${driver.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editemail${driver.id}" class="form-label">Email</label>
                                <input type="email" value="${driver.email}" class="form-control" id="editemail${driver.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editdriver_license${driver.id}" class="form-label">Driver License</label>
                                <input type="text" value="${driver.driver_license}" class="form-control" id="editlicense${driver.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-3">
                                <label for="editaddress${driver.id}" class="form-label">Address</label>
                                <input type="text" value="${driver.address}" class="form-control" id="editaddress${driver.id}" aria-describedby="emailHelp"> 
                            </div>
                            <div class="mb-1">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status${driver.id}"  class="form-control" required>
                                                    <option value="pending">Pending</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="editSaveBtn" data-id="${driver.id}">Save</button>
                        </div>
                    </div>
                </div>
            </div> 
        </td>
    </tr>`;
                        // Append the row to the 


                        $('tbody').append(row);
                    });
                    $('#dataTable').DataTable();
                     
                   
                }

            });
        } 

        function deleteUser(userid) {
            $.ajax({
                type: 'post',
                url: '/admin/driver/deletebyid',
                data: {
                    'id': userid
                },
                success: function(data) {

                    tae();
                },
                error: function(xhr, status, error) {


                    console.log(xhr);

                }


            });
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
            timer: 2000, // 2 seconds
            timerProgressBar: true
        }).then(() => {
            // Reload the page or do any other necessary action
            location.reload();
        });
    }
});
        }

        function createdriver(driver_name, contact, email, driver_license, address, status, callback) {
            $.ajax({
                type: 'post',
                url: '/admin/addnnewDriver',
                data: {
                    'driver_name': driver_name,
                    'contact': contact,
                    'email': email,
                    'driver_license': driver_license,
                    'address': address,
                    'status': status,

                },
                success: function(data) {
                    if (data.message === 'success') {
                        $('#messageflash').text('Driver added successfully');
                        callback(true); // Invoke the callback with true indicating success
                    }
                },
                error: function(xhr, status, error) {


                    // Error handling
                    var errorMessage = xhr.responseJSON.message;
                    if (errorMessage) {
                        $('#messageflash').text('Erroryawa: ' + errorMessage);
                    } else {
                        $('#messageflash').text('An error occurred while adding the user');
                    }
                    callback(false); // Invoke the callback with false indicating failure
                }
            });
        }
    </script>

    {{-- jquery code --}}
    <script>

$('#createDriverBtn').on('click', function(e) {
    e.preventDefault(); // Prevent the default form submission behavior

    let driver_name = $('#driver_name').val();
    let contact = $('#contact').val();
    let email = $('#email').val();
    let driver_license = $('#driver_license').val();
    let address = $('#address').val();
    let status = $('#status').val();
    console.log(driver_name+contact+email+driver_license+address+status);

    createdriver(driver_name, contact, email, driver_license, address, status, function(success) {
        if (success === true) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Driver added successfully.",
                showConfirmButton: true,
                timer: 2000, // 2 seconds
                timerProgressBar: true,

            }).then(() => {
                $('#driver_name').val('');
                $('#contact').val('');
                $('#email').val('');
                $('#driver_license').val('');
                $('#address').val('');
                $('#status').val('');
                // Redirect to the same page to refresh
                location.reload();
            });
        }
    });
});

$('tbody').on('click', '.editVehicle', function() {
    // Get the id of the vehicle to edit
    let id = $(this).data('id');

    // Show the edit modal
    $(`#vehicleEdit${id}`).modal('show');

    // Get the current vehicle data
    let platenumber = $('#platenumber').val();
    let type = $('#type').val();
    let driver = $('#driver').val();
    let condition = $('#condition').val();
    let description = $('#description').val();
    let status = $('#status').val();

    // Update the modal inputs with the current vehicle data
    $(`#editplatenumber${id}`).val(vehicle.platenumber);
    $(`#edittype${id}`).val(vehicle.type);
    $(`#editdriver${id}`).val(vehicle.driver);
    $(`#editcondition${id}`).val(vehicle.condition);
    $(`#editdescription${id}`).val(vehicle.description);
    $(`#editstatus${id}`).val(vehicle.status);
});

// Save button click event listener
$('tbody').on('click', '#editSaveBtn', function() {
    // Get the id of the vehicle being edited
    let id = $(this).attr('data-id');

    // Get the updated values from the modal inputs
    let platenumber = $(`#editplatenumber${id}`).val();
    let type = $(`#edittype${id}`).val();
    let driver = $(`#editdriver${id}`).val();
    let condition = $(`#editcondition${id}`).val();
    let description = $(`#editdescription${id}`).val();
    let status = $(`#status${id}`).val();

    // Send the data to the server using AJAX
    $.ajax({
        type: 'post',
        url: '/adminuser/editbyid',
        data: {
            'id': id,
            'platenumber': platenumber,
            'type': type,
            'driver': driver,
            'condition': condition,
            'description': description,
            'status': status
        },
        success: function(response) {
            // Handle the success response
            Swal.fire({
                title: 'Success!',
                text: 'Vehicle updated successfully.',
                icon: 'success',
                timer: 2000, // 2 seconds
                timerProgressBar: true,
                didClose: () => {
                    // Reload the page to reflect the changes
                    location.reload();
                }
            });
            $(`#vehicleEdit${id}`).modal('hide');
        },
        error: function(xhr, status, error) {
            // Handle the error response
            Swal.fire("Error!", "Failed to update vehicle.", "error");
            
        }
    });
    
});

$(document).on('click', '[data-bs-dismiss="modal"]', function() {
    $(this).closest('.modal').modal('hide');
});



    </script>
@endpush


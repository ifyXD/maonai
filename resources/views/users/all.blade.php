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
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Username</th>
                                <th scope="col" class="date-header">Created at (UTC)</th>
                                <th scope="col" class="date-header">Updated at (UTC)</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $('option[value="decline"]').hide();

        tausers();

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


        function tausers() {
    // Destroy the existing DataTable instance to prevent conflicts
    if ($.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable().destroy();
    }

    // Clear the table body before populating it with new data
    $('tbody').empty();

    $.ajax({
        type: 'get',
        url: '/admin/usersdata',
        success: function(data) {
            // Assuming data is an array of user objects
            $.each(data.users, function(index, user) {
                var key = index + 1;
                var ifdel = user.isdel === 'deleted' ? 'is-deleted' : '';

                var action = user.isdel === 'active' ?

                `<a href="#" class="editUsers" data-id="${user.id}" data-bs-toggle="modal" data-bs-target="#userEdit${user.id}">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
          </svg>
      </a>
      <a href="#" onclick="confirmDelete(${user.id});" id="deleteUserId">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash text-danger" viewBox="0 0 16 16">
              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
              <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
          </svg>
      </a>` :
                            `<span class="text-danger">Deleted</span>`;
                        // Assuming user has properties like id, name, email, etc.
                        let row =
                    `<tr class="${ifdel}" id="trId${user.id}">
                        <td>${key}</td>
                        <td id="nameId${user.id}">${user.ufname} ${user.uname} ${user.lname}</td>
                        <td id="addressId${user.id}">${user.address}</td>
                        <td id="contactId${user.id}">${user.contact}</td>
                        <td id="usernameId${user.id}">${user.username}</td>
                        <td id="createdAtId${user.id}">${formatDate(user.created_at)}</td>
                        <td id="updatedAtId${user.id}">${formatDate(user.updated_at)}</td>
                        <td>

              ${action}
              <div class="modal fade" id="userEdit${user.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                                                    </div>
                          <div class="modal-body"> 
                              <div class="mb-3">
                                  <label for="  ${user.id}" class="form-label">First Name</label>
                                  <input type="text" value="${user.ufname}" class="form-control" id="editufname${user.id}" aria-describedby="emailHelp"> 
                              </div>
                              <div class="mb-3">
                                  <label for="edituname${user.id}" class="form-label">Middle Name</label>
                                  <input type="text" value="${user.uname}" class="form-control" id="edituname${user.id}" aria-describedby="emailHelp"> 
                              </div>
                              <div class="mb-3">
                                  <label for="editlname${user.id}" class="form-label">Last Name</label>
                                  <input type="text" value="${user.lname}" class="form-control" id="editlname${user.id}" aria-describedby="emailHelp"> 
                              </div>
                              <div class="mb-3">
                                  <label for="editaddress${user.id}" class="form-label">Address</label>
                                  <input type="text" value="${user.address}" class="form-control" id="editaddress${user.id}" aria-describedby="emailHelp"> 
                              </div>
                              <div class="mb-3">
                                  <label for="editcontact${user.id}" class="form-label">Contact</label>
                                  <input type="number" value="${user.contact}" class="form-control" id="editcontact${user.id}" aria-describedby="emailHelp"> 
                              </div>
                              
                              <div class="mb-3">
                                  <label for="editusername${user.id}" class="form-label">Username</label>
                                  <input type="text" value="${user.username}" class="form-control" id="editcondition${user.id}" aria-describedby="emailHelp"> 
                              </div>
                           
                            <div class="mb-3">
                            <label for="editpassword${user.id}" class="form-label">Password</label>
                            <input type="password" value="${user.password}" class="form-control" id="editpassword${user.id}" aria-describedby="emailHelp">
                            <button type="button" class="btn btn-secondary" id="togglePassword${user.id}" onclick="togglePasswordVisibility(${user.id})">Show</button>

                        </div>

                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="editSaveBtn" data-id="${user.id}">Save</button>
                          </div>
                      </div>
                  </div>
              </div> 
          </td>
      </tr>`;
                $('tbody').append(row);
            });

            // Initialize the DataTable
            $('#dataTable').DataTable();

                }

            });
        }



        function deleteUser(userid) {
            $.ajax({
                type: 'post',
                url: '/admin/users/deletebyid',
                data: {
                    'id': userid
                },
                success: function(data) {

                    tausers();
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
                    deleteUser(id);
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'User has been deleted.',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }

        $('tbody').on('click', '.editUsers', function() {
            let id = $(this).data('id');
            $(`#userEdit${id}`).modal('show');
            // Update modal inputs with current user data
            $(`#editufname${id}`).val($(`#nameId${id}`).text().split(' ')[0]);
            $(`#edituname${id}`).val($(`#nameId${id}`).text().split(' ')[1]);
            $(`#editlname${id}`).val($(`#nameId${id}`).text().split(' ')[2]);
            $(`#editaddress${id}`).val($(`#addressId${id}`).text());
            $(`#editcontact${id}`).val($(`#contactId${id}`).text());
            $(`#editusername${id}`).val($(`#usernameId${id}`).text());
            $(`#editpassword${id}`).val($(`#usernameId${id}`).text());

        });


        // Save button click event listener
      // Save button click event listener
      $('tbody').on('click', '#editSaveBtn', function() {
    let id = $(this).data('id');
    let ufname = $(`#editufname${id}`).val();
    let uname = $(`#edituname${id}`).val();
    let lname = $(`#editlname${id}`).val();
    let address = $(`#editaddress${id}`).val();
    let contact = $(`#editcontact${id}`).val();
    let username = $(`#editusername${id}`).val();
    let password = $(`#editpassword${id}`).val();

    $.ajax({
        type: 'post',
        url: '/admin/user/editbyid',
        data: {
            'id': id,
            'ufname': ufname,
            'uname': uname,
            'lname': lname, 
            'address': address,
            'contact': contact,
            'username': username,
            'password': password // Send plain password to server
        },
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: 'User updated successfully.',
                icon: 'success',
                timer: 2000,
                timerProgressBar: true,
                didClose: () => {
                    location.reload();
                }
            });
            $(`#userEdit${id}`).modal('hide');
        },
        error: function(xhr, status, error) {
            Swal.fire("Error!", "Failed to update user.", "error");
        }
    });
});
        $(document).on('click', '[data-bs-dismiss="modal"]', function() {
            $(this).closest('.modal').modal('hide');
        });
    </script>
@endpush
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
                            Create users
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card">
            <div class="card-body">
                <form>
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="ufname" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="ufname" name="ufname" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="uname" class="form-label">Middle Name:</label>
                                <input type="text" class="form-control" id="uname" name="uname">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="lname" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="lname" name="lname" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <textarea class="form-control" id="address" name="address" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact:</label>
                                <input type="text" class="form-control" id="contact" name="contact" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" autocomplete="username" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="createUserForm" class="btn btn-primary">Submit</button>
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

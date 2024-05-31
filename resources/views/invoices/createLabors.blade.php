@extends('layouts.InvoiceInsert')

@section('content')
<div class="container">
    <h2 class="my-4"><i data-feather="user-plus"></i> <em>Add New Labor</em></h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{ route('invoices.storeLabors', ['contact_id' => $contact->id]) }}" method="POST" id="laborsForm">
                @csrf
                <div class="mb-4 mt-5">
                    <div class="card-header text-center font-weight-bold"><em>"Labor Details"</em></div>

                    <div style="background-color: #F2F6FC;" id="formContainer">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name[]" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" name="date[]" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="rate">Rate</label>
                                <input type="text" class="form-control" name="rate[]" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hours">Hours</label>
                                <input type="text" class="form-control" name="hours[]" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" name="role[]" required>
                                <option value="technician">Technician</option>
                                <option value="repairmen">Repairmen</option>
                                <option value="carpenter">Carpenter</option>
                                <option value="driver">Driver</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

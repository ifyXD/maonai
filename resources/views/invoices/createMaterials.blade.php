@extends('layouts.InvoiceInsert')

@section('content')
<div class="container">
    <h2 class="my-4"><i data-feather="archive"></i> <em>Add New Material</em></h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{ route('invoices.storeMaterials', ['contact_id' => $contact->id]) }}" method="POST">
                @csrf
                <div class="card-header text-center font-weight-bold"><em>"Material Details"</em></div>
                <div class="form-group">
                    <label for="material">Material</label>
                    <input type="text" class="form-control" name="material" required>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="date" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" step="0.01" class="form-control" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="unit_cost">Unit Cost</label>
                    <input type="number" step="0.01" class="form-control" name="unit_cost" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>


@endsection

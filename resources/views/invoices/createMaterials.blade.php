<!-- resources/views/invoices/createMaterials.blade.php -->

@extends('layouts.landing')

@section('design')
    <div class="container">
        <h1 class="my-4">Add New Material</h1>
        <form action="{{ route('invoices.storeMaterials', ['contact_id' => $contact->id]) }}" method="POST">
            @csrf
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
@endsection

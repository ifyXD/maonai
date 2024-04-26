@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Request</h1>
    <form method="POST" action="{{ route('contacts_requests.update', $request->id) }}">
        @csrf
        @method('PUT')

        <!-- Form fields for editing request data -->
        <div class="form-group">
            <label for="content">Content</label>
            <input type="text" class="form-control" id="content" name="content" value="{{ $request->content }}">
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $request->quantity }}">
        </div>

        <div class="form-group">
            <label for="unit_cost">Unit Cost</label>
            <input type="number" class="form-control" id="unit_cost" name="unit_cost" value="{{ $request->unit_cost }}">
        </div>

        <div class="form-group">
            <label for="labor_needed">Labor Needed</label>
            <input type="text" class="form-control" id="labor_needed" name="labor_needed" value="{{ $request->labor_needed }}">
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Save Changes</button>

    </form>
</div>
@endsection

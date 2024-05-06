<!-- resources/views/invoices/create.blade.php -->

@extends('layouts.landing')

@section('design')
    <div class="container">
        <h1 class="my-4">Add New Labor</h1>
        <form action="{{ route('invoices.storeLabors', ['contact_id' => $contact->id]) }}" method="POST" id="laborsForm">
            @csrf
            <div id="labors">
                <!-- Fields for a single labor record -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name[]">
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="date[]">
                </div>
                <div class="form-group">
                    <label for="rate">Rate</label>
                    <input type="text" class="form-control" name="rate[]">
                </div>
                <div class="form-group">
                    <label for="hours">Hours</label>
                    <input type="text" class="form-control" name="hours[]">
                </div>
            </div>
            <button type="button" class="btn btn-success" id="addLabor">Add Labor</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <!-- Add this at the end of the invoices.create view -->
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addLaborButton = document.getElementById('addLabor');
        const laborsContainer = document.getElementById('labors');

        addLaborButton.addEventListener('click', function () {
            const newLabor = document.createElement('div');
            newLabor.innerHTML = `
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name[]">
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" name="date[]">
                </div>
                <div class="form-group">
                    <label for="rate">Rate</label>
                    <input type="text" class="form-control" name="rate[]">
                </div>
                <div class="form-group">
                    <label for="hours">Hours</label>
                    <input type="text" class="form-control" name="hours[]">
                </div>
            `;
            laborsContainer.appendChild(newLabor);
        });
    });
</script>
@endsection

@endsection


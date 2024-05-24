<!-- resources/views/contacts/edit.blade.php -->


<div class="modal-content">
    <div class="modal-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('contacts.update', ['id' => $contact->id]) }}">

            <!-- Hidden input to carry the redirect_to parameter -->
        <input type="hidden" name="redirect_to" value="{{ request()->query('redirect_to') }}">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $contact->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $contact->email }}" required>
            </div>

            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" class="form-control" id="department" name="department" value="{{ $contact->department }}" required>
            </div>

            <div class="form-group">
                <label for="request_type">Request Type:</label><br>
                <input type="checkbox" name="request_type[]" value="repair" {{ in_array('repair', explode(', ', $contact->content)) ? 'checked' : '' }}> Repair<br>
                <input type="checkbox" name="request_type[]" value="service" {{ in_array('service', explode(', ', $contact->content)) ? 'checked' : '' }}> Service<br>
                <input type="checkbox" name="request_type[]" value="commission" {{ in_array('commission', explode(', ', $contact->content)) ? 'checked' : '' }}> Commission<br>
            </div>

            <div class="form-group">
                <label for="other">Other:</label>
                <input type="text" class="form-control" id="other" name="other" value="{{ $contact->other }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Contact</button>
        </form>
    </div>
</div>






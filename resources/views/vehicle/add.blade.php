<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Records</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
<div class="modal fade" id="addNewVehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form>
            @csrf
            <div class="modal-content create-new-vehicle-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create new Vehicles</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                </div>
                <div class="modal-body">

                    <div class="mb-1">
                        <label for="platenumber" class="form-label">Plate Number</label>
                        <input type="text" class="form-control" id="platenumber" name="platenumber"
                            placeholder="Plate Number" required>
                    </div>

                    <div class="mb-1">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type" name="type" placeholder="Type">
                    </div>

                    <div class="mb-1">
                        <label for="driver" class="form-label">Driver</label>
                        <input type="text" class="form-control" id="driver" name="driver" placeholder="Driver">
                    </div>

                    <div class="mb-1">
                        <label for="condition" class="form-label">Condition</label>
                        <input type="text" class="form-control" id="condition" name="condition"
                            placeholder="Condition">
                    </div>

                    <div class="mb-1">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description"></textarea>
                    </div>

                    <div class="mb-1">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pending">Pending</option>
                            <option value="accept">Active</option>


                        </select>
                    </div>

                    <button type="submit" id="createVehicleBtn" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>


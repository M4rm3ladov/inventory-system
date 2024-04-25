<div class="modal fade" id="editBranchModal" tabindex="-1" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editBranchModalLabel">Edit Branch</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('branch') }}" method="POST">
                <div class="modal-body">
                    <label class="my-auto me-2" name="name">Name:</label>
                    <input type="text" class="form-control mb-2">

                    <label class="my-auto me-2" name="address">Address:</label>
                    <input type="text" class="form-control mb-2">

                    <label class="my-auto me-2" name="email">Email:</label>
                    <input type="email" class="form-control mb-2">

                    <label class="my-auto me-2" name="phone">Phone:</label>
                    <input type="tel" class="form-control mb-2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

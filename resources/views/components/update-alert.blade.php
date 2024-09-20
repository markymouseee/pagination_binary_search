<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="updateModalLabel">Update User</h2>
                </div>
                <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="">
                            <label for="floatingInput">Firstname</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="">
                            <label for="floatingInput">Lastname</label>
                        </div>
                    <div class="DisplayName badge rounded-pill text-bg-info text-light"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

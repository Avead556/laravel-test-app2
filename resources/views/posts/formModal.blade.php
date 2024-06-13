<div class="modal fade" id="post-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Post form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="toast align-items-center text-white bg-danger border-0" id="post-error-toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body" id="post-toast-body">
                            Hello, world! This is a toast message.
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>

                <form action="{{route('posts.store')}}" id="post-form">
                    @csrf
                    <fieldset >
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="post-title" name="title" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea id="post-content" name="content" class="form-control"></textarea>
                        </div>
                    </fieldset>
                </form>
                <button type="button" class="btn btn-primary" id="post-submit" >Save changes</button>
            </div>
        </div>
    </div>
</div>

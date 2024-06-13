@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Posts</h1>
        <button type="button" class="btn btn-primary" id="post-create-button">
            Create Post
        </button>

        @foreach($posts as $post)
            <div class="card mt-4">
                <div class="card-header">
                    {{ $post->title }}
                </div>
                <div class="card-body post-line">
                    <p>{{ \Illuminate\Support\Str::limit($post->content, 100) }}</p>
                    <button type="button" class="btn btn-primary post-show" data-id="{{ $post->id }}">
                        Show
                    </button>
                    <button type="submit" class="btn btn-danger post-delete" data-postId="{{ $post->id }}">Delete
                    </button>
                </div>
            </div>
        @endforeach
        {{ $posts->links() }}
        @include('posts.formModal')
        @include('posts.deleteModal')


    </div>
@endsection

@push('javascript')
    <script>

        const postModalElement = document.getElementById('post-modal');
        const postDeleteModalElement = document.getElementById('post-delete-modal');
        const postSubmitButton = document.getElementById('post-submit');
        const postForm = document.getElementById('post-form');
        const postCreateButton = document.getElementById('post-create-button');
        const postSubmitDeleteButton = document.getElementById('post-submit-delete');
        const postToastBody = document.getElementById('post-toast-body');
        const postErrorToast = new bootstrap.Toast(document.getElementById('post-error-toast'));
        const postBootstrapModal = new bootstrap.Modal(postModalElement);
        const postDeleteBootstrapModal = new bootstrap.Modal(postDeleteModalElement);

        postModalElement.addEventListener('hidden.bs.modal', function () {
            postModalElement.querySelector("#post-title").value = '';
            postModalElement.querySelector("#post-content").value = '';
        });


        document.querySelectorAll('.post-show').forEach(button => {
            button.addEventListener('click', async function () {
                const postId = this.getAttribute('data-id');

                const response = await fetch(`/api/posts/${postId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + window.apiToken
                    },
                }).then(response => response.json()).then(data => {
                    postForm.setAttribute('data-postId', postId);
                    postModalElement.querySelector("#post-title").value = data?.title;
                    postModalElement.querySelector("#post-content").value = data?.content;
                    postBootstrapModal.show();
                });
            })
        });

        document.querySelectorAll('.post-delete').forEach(button => {
            button.addEventListener('click', async function () {
                const postId = this.getAttribute('data-postId');
                postDeleteModalElement.setAttribute('data-postId', postId);
                postDeleteBootstrapModal.show();
            })
        });


        postSubmitDeleteButton.addEventListener('click', async function () {
            const postId = postDeleteModalElement.getAttribute('data-postId');
            await fetch(`/api/posts/${postId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + window.apiToken
                },
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    postDeleteModalElement.setAttribute('data-postId', '');
                    location.reload()
                }
            })

        });
        postCreateButton.addEventListener('click', async function () {
            postForm.setAttribute('data-postId', '');
            postBootstrapModal.show();
        });

        postSubmitButton.addEventListener('click', async function () {
            const postFormData = new FormData(postForm);
            const postId = postForm.getAttribute('data-postId');

            if (postId) {
                await sendRequest(`/api/posts/${postId}`, 'PUT', postFormData)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload()
                        }
                        parseErrors(data?.errors)
                    })
            } else {
                await sendRequest(`/api/posts`, 'POST', postFormData)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload()
                        }
                        parseErrors(data?.errors)
                    })
            }
        });

        function parseErrors(errors) {
            Object.keys(errors).forEach(function (key) {
                let errorsText = '';
                errors[key].map((message) => {
                    errorsText += message
                });
                postToastBody.textContent = errorsText
            });

            postErrorToast.show()
        }

        async function sendRequest(url, method, formData) {
            return await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + window.apiToken
                },
                body: JSON.stringify(Object.fromEntries(formData))
            });
        }

    </script>
@endpush

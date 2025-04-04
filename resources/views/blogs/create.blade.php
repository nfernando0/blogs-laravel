@extends('template.index')

@section('content')
    <div class="card mt-5">
        <div class="card-body">
            <form id="blogForm" enctype="multipart/form-data">



                <div class="mb-3">
                    <label for="title" class="form-label">title</label>
                    <input type="text" class="form-control" name="title" id="title">
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" name="slug" id="slug" disabled>
                </div>

                @foreach ($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $category->id }}" name="categories[]"
                            id="category{{ $category->id }}">
                        <label class="form-check-label" for="category">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach

                <div class="mb-3">
                    <label for="body" class="form-label">Body</label>
                    <textarea class="form-control" name="body" id="body" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Image</label>
                    <input class="form-control" type="file" name="photo" accept="image/*" id="photo">
                </div>

                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#title').blur(function() { // Tambahkan event blur
                let title = $(this).val();
                let slug = title.toLowerCase().replace(/[^a-z0-9-]+/g, '-').replace(/^-+|-+$/g, '');
                $('#slug').val(slug);
            });

            $('#blogForm').submit(function(e) {
                e.preventDefault()

                let form = this;
                let formData = new FormData(form);

                $.ajax({
                    url: "{{ route('store.blog') }}",
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            localStorage.setItem('successfully', response.success);
                            Swal.fire({
                                    type: 'success',
                                    title: 'Blog berhasil dibuat!',
                                    text: 'Anda akan di arahkan dalam 3 Detik',
                                    timer: 3000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                })
                                .then(function() {
                                    window.location.href =
                                        "{{ route('home') }}";

                                    localStorage.setItem('successfully',
                                        'Blog Berhasil dibuat!');
                                });
                        }
                    }
                })
            })
        })
    </script>
@endsection

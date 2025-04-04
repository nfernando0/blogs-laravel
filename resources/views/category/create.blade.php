@extends('template.index')

@section('content')
    <form id="categoryForm">
        <div class="mb-3">
            <label for="name" class="form-label">name</label>
            <input type="text" class="form-control" name="name" id="name">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categoryForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('category.created') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            localStorage.setItem('successfully', response.success);
                            Swal.fire({
                                    type: 'success',
                                    title: 'Category berhasil dibuat!',
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

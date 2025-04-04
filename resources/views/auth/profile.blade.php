@extends('template.index')

@section('content')
    <style>
        .profile-container {
            background-color: #ffffff;
            margin-top: 1rem;
            padding: 1rem;
            display: grid;
            grid-template-columns: 19rem 1fr;
            gap: 10px;
        }

        .btn-edit {
            border: none;
            background-color: lightblue;
            padding: 0.2rem 1rem;
            border-radius: 0.5rem;
        }

        .btn-submit {
            border: none;
            background-color: lightblue;
            padding: 0.2rem 1rem;
            border-radius: 0.5rem;
            display: none;
        }

        @media (max-width: 1000px) {

            .profile-container {
                grid-template-columns: 1fr;
            }

            .card-img-top {
                width: 300px !important;
                margin: auto;
                display: flex;
            }
        }
    </style>

    <div class="profile-container">
        <div>
            <img src="https://dummyimage.com/200x200/000/fff" width="30" height="200" class="card-img-top" alt="...">
        </div>
        <div>
            <form action="#" id="form-update">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" value="{{ Auth::user()->username }}" disabled
                        name="username">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" value="{{ Auth::user()->email }}" disabled
                        name="email">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" class="form-control" id="phone" value="{{ Auth::user()->phone }}" disabled
                        name="phone">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="3" disabled>{{ Auth::user()->address }}</textarea>
                </div>
                <button class="btn-edit" id="btn-edit">Edit Profile</button>
                <button type="submit" class="btn-submit" id="btn-submit">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btn-edit').click(function(e) {
                e.preventDefault();
                $('#email, #username, #phone, #address').prop('disabled', false);

                $('#btn-edit').hide()
                $('#btn-submit').show()
            })

            $('#form-update').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('profile.update') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.success) {
                            $('#email, #username, #phone, #address').prop('disabled', true);
                        } else {
                            console.log('error')
                        }
                    }
                })
            })
        })
    </script>
@endsection

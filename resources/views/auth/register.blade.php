@extends('template.index')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6">
            <h4 class="text-center">Register Page</h4>
            <form>
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary w-100" id="btn-submit">Submit</button>
            </form>
            <span>Have Any Account? <a href="{{ route('auth.login') }}">Login here</a></span>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <script>
        function checkUsernameAvailability(username) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/check-username', // Ganti dengan rute Anda
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        username: username
                    },
                    dataType: 'json',
                    success: function(response) {
                        resolve(response.available);
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }

        function checkEmailAvailability(email) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/check-email', // Ganti dengan rute Anda
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        email: email
                    },
                    dataType: 'json',
                    success: function(response) {
                        resolve(response.available);
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }

        $(document).ready(function() {
            $("#btn-submit").click(function(e) {
                e.preventDefault()

                var username = $("#username").val();
                var email = $("#email").val();
                var password = $("#password").val();

                if (username) {
                    checkUsernameAvailability(username)
                        .then(available => {
                            if (!available) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Username Sudah Tersedia',
                                    text: 'Username ini sudah digunakan.'
                                });
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
                if (email) {
                    checkEmailAvailability(email)
                        .then(available => {
                            if (!available) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Email Sudah Tersedia',
                                    text: 'Username ini sudah digunakan.'
                                });
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }

                if (username.length === "") {
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'username Wajib Diisi !'
                    });
                } else if (email.length == "") {
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Email Wajib Diisi !'
                    });
                } else if (password.length == "") {
                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Password Wajib Diisi !'
                    });
                } else {
                    $.ajax({
                        url: "{{ route('register') }}",
                        type: "POST",
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "username": username,
                            "email": email,
                            "password": password
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire({
                                        type: 'success',
                                        title: 'Register Berhasil!',
                                        text: 'Anda akan di arahkan ke halaman login dalam 3 Detik',
                                        timer: 3000,
                                        showCancelButton: false,
                                        showConfirmButton: false
                                    })
                                    .then(function() {
                                        window.location.href =
                                            "{{ route('auth.login') }}";
                                    });

                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Register Gagal!',
                                    text: 'silahkan coba lagi!'
                                });
                                console.log(response);
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection

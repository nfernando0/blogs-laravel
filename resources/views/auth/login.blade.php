@extends('template.index')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6">
            <h4 class="text-center">Login Page</h4>
            <form>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="usernae">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary w-100" id="btn-submit">Submit</button>
            </form>
            <span>Don't Have Any Account? <a href="{{ route('auth.register') }}">Register here</a></span>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#btn-submit').click(function(e) {
                e.preventDefault()

                var username = $("#username").val();
                var password = $("#password").val();
                var token = $("meta[name='csrf-token']").attr("content");

                if (username.length == "") {

                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Username Wajib Diisi !'
                    });

                } else if (password.length == "") {

                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Password Wajib Diisi !'
                    });

                } else {
                    $.ajax({
                        url: "{{ route('login') }}",
                        type: "POST",
                        dataType: "JSON",
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            "username": username,
                            "password": password,
                            "_token": token
                        },
                        success: function(response) {
                            if (response.success) {
                                localStorage.setItem('loginSuccess', response.success);
                                Swal.fire({
                                        type: 'success',
                                        title: 'Login Berhasil!',
                                        text: 'Anda akan di arahkan dalam 3 Detik',
                                        timer: 3000,
                                        showCancelButton: false,
                                        showConfirmButton: false
                                    })
                                    .then(function() {
                                        window.location.href =
                                            "{{ route('home') }}";

                                        sessionStorage.setItem('loginSuccess',
                                            'Login Berhasil!');
                                    });

                            } else {
                                console.log(response.success)

                                Swal.fire({
                                    type: 'error',
                                    title: 'Login Gagal!',
                                    text: 'silahkan coba lagi!'
                                });
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection

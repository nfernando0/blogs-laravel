<style>
    .dropdown-toggle::after {
        display: none;
    }
</style>

<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">My Blogs</a>
        @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown dropdown-end" style="position: relative;">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div>
                                @php
                                    $profileImage = Auth::user()->photo
                                        ? asset('storage/' . Auth::user()->photo)
                                        : asset('https://dummyimage.com/200x200/000/fff');
                                @endphp
                                <img src="{{ $profileImage }}" class="rounded-circle" alt="Bootstrap" width="35"
                                    height="35">
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('auth.profile') }}">Profile</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('myblog', Auth()->user()->id) }}">My Blog</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><button class="dropdown-item" id="btn-logout">Log Out</button></li>
                        </ul>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('auth.login') }}" class="nav-link">Login</a>
        @endauth
    </div>
</nav>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        $('#btn-logout').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('logout') }}",
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message
                        }).then(function() {
                            window.location.href =
                                '/'; // Alihkan ke halaman login
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan.'
                        });
                    }
                }
            })
        })
    })
</script>

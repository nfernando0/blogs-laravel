@extends('template.index')

@section('content')
    <style>
        .card-blog {
            /* border: 1px solid #000000; */
            margin: 0;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.38);
            border-radius: 0.5rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(4.6px);
            -webkit-backdrop-filter: blur(4.6px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            /* display: flex; */
        }

        .img-head {
            width: 100%;
            height: 12rem;
        }

        .btn-read {
            position: absolute;
            left: 0.5rem;
            bottom: 0.1rem;
        }


        .cat {
            border-radius: 0.3rem;
            font-size: 0.8rem;
            display: block;
        }

        .badge-category {
            font-size: 0.7rem;
            border: 1px solid rgb(241, 89, 89);
            border-radius: 0.3rem;
            padding: 0.2rem 1rem;

        }

        .cards {
            border: 1px solid #000000;
            height: 23rem;
            position: relative;
        }

        .cards-body {
            padding: 0 0.5rem;
        }

        .badge-category:hover {
            background-color: rgb(241, 89, 89);
            color: #ffffff;
            cursor: pointer;
        }

        .container-blog {
            display: grid;
            grid-template-columns: 30rem 1fr;
            /* 3 kolom dengan lebar yang sama */
            gap: 10px;
        }

        .card-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            /* 3 kolom dengan lebar yang sama */
            gap: 10px;
        }

        @media (max-width: 568px) {

            .container-blog,
            .card-container {
                grid-template-columns: 1fr;
                /* 1 kolom pada layar kecil */
            }
        }

        @media (max-width: 768px) {
            .cards {
                width: 100%;
            }



        }

        @media (max-width: 1190px) {


            .container-blog {
                grid-template-columns: 1fr;
            }

            .card-container {
                grid-template-columns: repeat(2, 1fr);
                /* 1 kolom pada layar kecil */
            }



        }

        @media (max-width: 1400px) {

            .container-blog {
                grid-template-columns: 1fr;
            }

            .card-cate {
                order: 2;
                /* Pindahkan kolom kecil ke bawah */
            }

            .card-blog {
                order: 1;
                /* Pindahkan kolom lebar ke atas */
            }

            .card-container {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                /* 1 kolom pada layar kecil */
            }

        }
    </style>

    <h1 class="text-center">Blog</h1>

    @auth
        <a class="btn btn-primary" href="{{ route('blogs') }}" style="margin-bottom: 1rem">Add Blog</a>
    @endauth
    <div class="container-blog">
        <div class="card-cate">
            <div class="sticky-top pt-2 mb-4" style="top: 3.5rem;">
                <div class="card">
                    <p class="card-header">Category</p>
                    <div class="card-blog">
                        @foreach ($categories as $category)
                            <span class="cat">{{ $category->name }} ({{ $category->blogs_count }})</span>
                        @endforeach
                        <a href="{{ route('category.create') }}" class="btn btn-primary w-100 mt-2"
                            style="font-size: 0.8rem;">+ Tambah
                            Category</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-blog">
            <div class="container">
                <div class="card-container">
                    @foreach ($blogs as $blog)
                        <div class="cards">
                            @php
                                $profileImage = $blog->photo
                                    ? asset('storage/' . $blog->photo)
                                    : asset('https://dummyimage.com/200x200/000/fff');
                            @endphp <img src="{{ $profileImage }}" alt="Bootstrap" class="img-head">
                            <div class="cards-body">
                                @foreach ($blog->categories as $category)
                                    <span class="badge-category">{{ $category->name }}</span>
                                @endforeach
                                <h4>{{ $blog->title }}</h4>
                                <p>{{ Str::limit($blog->body, 100) }}</p>
                                <a class="btn-read" href="{{ route('blog.show', $blog->slug) }}">Read more...</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            // Tampilkan toast jika ada pesan sukses di session storage
            let loginSuccess = localStorage.getItem('loginSuccess');
            let successfully = localStorage.getItem('successfully');
            if (loginSuccess) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Signed in successfully"
                });

                localStorage.removeItem('loginSuccess');
            }
            if (successfully) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Blog Berhasil Dibuat"
                });

                localStorage.removeItem('successfully');
            }
        });
    </script>
@endsection

@extends('template.index')

@section('content')
    <style>
        .card-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-top: 1rem;
            background-color: #ffffff;
            padding: 0.5rem;
        }

        .cards {
            border: 1px solid #000000;
        }

        .cards-body {
            padding: 0 1rem;
        }

        @media (max-width: 1340px) {
            .card-container {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .card-container {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="card-container">
        @foreach ($blogs as $blog)
            <div class="cards">
                <img src="https://dummyimage.com/200x200/000/fff" width="200" height="250" class="card-img-top"
                    alt="...">
                <div class="cards-body">
                    <h4>{{ $blog->title }}</h4>
                    <p>{{ Str::limit($blog->body, 100) }}</p>
                    <a class="btn" href="{{ route('blog.show', $blog->slug) }}">Read more...</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection

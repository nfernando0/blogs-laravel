@extends('template.index')

@section('content')
    <style>
        .body {
            max-width: 40rem;
            margin: 2rem auto;
            background-color: #ffffff;
            padding: 1rem;
        }

        .badge-category {
            font-size: 0.7rem;
            border: 1px solid rgb(241, 89, 89);

            border-radius: 0.3rem;
            padding: 0.2rem 1rem;
        }

        .badge-category:hover {
            background-color: rgb(241, 89, 89);
            color: #ffffff;
            cursor: pointer;
        }
    </style>
    <div class="body">
        <h1>{{ $blog->title }}</h1>
        @foreach ($blog->categories as $category)
            <span class="badge-category">{{ $category->name }}</span>
        @endforeach
        @php
            $profileImage = $blog->photo
                ? asset('storage/' . $blog->photo)
                : asset('https://dummyimage.com/200x200/000/fff');
        @endphp <img src="{{ $profileImage }}" alt="Bootstrap" style="margin: 1rem auto; display: flex; "
            width="300px">
        <p style="margin-top: 1rem; ">{{ $blog->body }}</p>
        <a href="{{ route('home') }}" class="btn">Back</a>
    </div>
@endsection

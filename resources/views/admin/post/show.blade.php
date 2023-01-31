@extends('layouts.app')

@section('title-page')
    Va che bel post - {{ $elem->id }}
@endsection

@section('content')

    <div>
        <h1>{{ $elem->name }}</h1>
    </div>

    <div>
        <p>
            {{ $elem->date }}
        </p>
    </div>
    {{-- @if ( session('success') )
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}

        <div>
            <p>
                {{ $elem->description }}
            </p>
        </div>

        <div>
            <p>
                {{ $elem->title }}
            </p>
        </div>

        <img src="{{asset("storage/$elem->cover")}}" alt="">

        <a href="{{ route('admin.posts.index') }}"><i class="fa-solid fa-left-long"></i></a>

@endsection

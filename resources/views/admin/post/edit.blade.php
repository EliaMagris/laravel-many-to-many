@extends('layouts.app')

@section('title-page')
Cos'e' non ti piace il post?
@endsection

@section('content')

<h1 class="text-center">Modifica il post</h1>

<form method="POST" action="{{route('admin.posts.update', $elem->id)}}">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nome:</label>
        <input name="name" type="text" class="form-control" id="title" value="{{$elem->name}}">
    </div>

    <div class="mb-3">
        <label class="form-label">Descrizione:</label>
        <textarea name="description" class="form-control" id="">{{$elem->description}}</textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Data:</label>
        <input name="date" value="{{$elem->date}}" type="date" class="form-control" id="title">
    </div>

    <div class="my-3">
            <label for="">Socials</label>
            <select name="category_id" id="">
                <option value="">Seleziona il tuo social preferito</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $category->id == old('category_id', $category->category_id) ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="my-3">
            <label for="">Tipo di cibo</label>

            @foreach ($tags as $tag)
                <label for="">
                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}"
                        {{ $elem->tags->contains($tag) ? 'checked' : '' }}>
                    {{ $tag->name }}
                </label>
            @endforeach

        </div>

    <button type="submit" class="btn btn-primary">Crea record</button>
</form>
@endsection

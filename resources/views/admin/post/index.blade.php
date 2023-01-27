@extends('layouts.app')

@section('content')
    {{-- <h1>Dati Utente</h1>
    {{ $userId }} | {{ $user->name }}
 --}}
    <div class="container">
        <a href="{{ route('admin.posts.create') }}">
            Crea un nuovo post
            <i class="fa-solid fa-plus"></i>
        </a>

        <table class="table ">
            <thead>
                <tr>

                    <th scope="col">Nome</th>
                    <th scope="col">Data</th>
                    <th scope="col">Descrizione</th>
                    <th scope="col">Portata preferita</th>
                    <th scope="col">Cibo preferito</th>
                    <th scope="col">See Info</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $elem)
                    <tr>

                        <td>{{ $elem->name }}</td>
                        <td>{{ $elem->date }}</td>
                        <td>{{ $elem->description }}</td>
                        <td>
                            @if ($elem->category)
                                <p>{{ $elem->category['title'] }}</p>
                            @endif
                        </td>
                        <td>
                            @foreach ($elem->tags as $singoloTag)
                                <ul>
                                    <li>
                                        {{ $singoloTag->name }}
                                    </li>
                                </ul>
                            @endforeach
                        </td>
                        <td><a href="{{ route('admin.posts.show', $elem->id) }}"><i class="fa-solid fa-eye"></i></a></td>

                        <td>
                            <a href="{{ route('admin.posts.edit', $elem->id) }}"><i class="fa-solid fa-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $elem->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form></a>
                        </td>

                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
@endsection

<h1> hai scritto il post dal titolo: {{$post->name}}</h1>
<h1> hai scritto il post con la descrizione: {{$post->description}}</h1>
<h1>Bravo signore, hai scritto il post con la data: {{$post->date}}</h1>

<p>le categorie sono {{$post->category->title}}</p>

<ul>
    @foreach ($post->tags as $elem )
        <li>{{$elem->name}}</li>
    @endforeach
</ul>
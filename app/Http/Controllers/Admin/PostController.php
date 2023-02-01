<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Mail\ConfirmPostMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'posts' => Post::with('category')->paginate(10)
        ];

        return view('admin.post.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::All();
        $tags = Tag::All();
        return view('admin.post.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);

        $newPost = new Post();

        if (array_key_exists('image', $data)) {
            $cover_url = Storage::put('post_covers', $data['image']);
            $data['cover'] = $cover_url;
        }

        $newPost->fill($data);
        $newPost->save();

        $email = new ConfirmPostMail($newPost);
        $userEmail = Auth::user()->email;
        Mail::to($userEmail)->send($email);

        if (array_key_exists('tags', $data)) {
            $newPost->tags()->sync($data['tags']);
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $elem = Post::findOrFail($id);
        // dd($elem);
        return view('admin.post.show', compact('elem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $elem = Post::findOrFail($id);
        $categories = Category::All();
        $tags = Tag::All();

        return view('admin.post.edit', compact('elem', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $post = Post::findOrFail($id);
        // $categories = Category::findOrFail($id);
        // $request->validate(
        // [
        //     'name' => 'required|max:50'
        // ],
        // [
        //     'name.required' => 'Attenzione il campo name è obbligatorio',
        //     'name.max' => 'Attenzione il campo non deve superare i 50 caratteri'
        // ]
        // );
        $post->update($data);
        // $post->update($categories);

        if (array_key_exists('tags', $data)) {
            $post->tags()->sync($data['tags']);
        } else {
            $post->tags()->sync([]);
        }


        return redirect()->route('admin.posts.show', $post->id)->with('success', "Hai modificato con successo: $post->name");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $singlePost = Post::findOrFail($id);
        if ($singlePost->cover) {
            Storage::delete($singlePost->cover);
        }
        ;
        $singlePost->tags()->sync([]);
        $singlePost->delete();
        return redirect()->route('admin.posts.index');
    }
}
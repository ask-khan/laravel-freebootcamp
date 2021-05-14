<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Intervention\Image\Facades\Image;


class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $user = auth()->user()->following()->pluck('profiles.user_id');
        //$posts = Posts::whereIn('user_id', $user)->OrderBy('created_at', 'DESC')->get();
        $posts = Posts::whereIn('user_id', $user)->latest()->paginate(5);
        return view( 'posts.index', compact('posts') );
    }


    public function create() {
        return view('posts.create');
    }

    public function store() {
        $data = request()->validate([
            //'another' => '',
            'caption' => 'required',
            'image' => ['required','image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');
        
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200,1200);
        $image->save();    

        auth()->user()->posts()->create( [
            'caption' => $data['caption'],
            'image' => $imagePath
        ] );

        // $post = new \App\Models\Post();

        // $post->caption = $data['caption'];
        // $post->save();

        //\App\Models\Post::create( $data );
        
        //dd( request()->all() );
        $loginUser = strval( auth()->user()->id );
        return redirect("/profile/{$loginUser}");
    }

    public function show( \App\Models\Posts $post ) {
        return view( 'posts.show', compact('post') );
    }
}

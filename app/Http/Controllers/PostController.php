<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Http\Requests\CreatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::orderBy('id','asc')->get();
        //$posts = Post::latest()->get();
        $posts = Post::recent(); // using query scope
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        //

        $input = $request->all();

        if($file = $request->file('dfile'))
        {
            $actualName = $file->getClientOriginalName();
            $file->move('images', $actualName);
            $input['ipath'] = $actualName;
        }


        Post::create($input);

        return $input;

        //return $file;
        // echo "<br>";
        // echo $file->getClientOriginalName();

        //echo "<br>";
        //echo $file->getClientSize();


        // $this->validate($request, [
        //     'title' => 'required|max:8'
        // ]);

        // Post::create($request->all());

        // return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
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
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id)->whereId($id)->delete();
        //$post->delete();
        return redirect('/posts');
    }

    public function show_post($id, $name, $tent)
    {
        // return view('contact')->with('id',$id);

        return view('contact',compact('id', 'name', 'tent'));
    }
}

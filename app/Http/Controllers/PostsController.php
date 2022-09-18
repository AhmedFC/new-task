<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\LikeDislike;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at','desc')
        ->get();

        return view('content.posts',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $request_data = $request->except(['_token']);
        $request_data['user_id'] = auth()->user()->id;

       $post =  Post::create($request_data);

       if($request->image) {
        $post->photos()->create([
            'src' => $this->uploadImage($request->image) ,
            'type' => 'photo'
        ]);
    }

        $success = "Post Created Successfully";
        return redirect()->route('posts.index')->with('success', $success);
    }

    // Save Comment
   public function save_comment(Request $request){
        $data=new Comment();
        $data->post_id=$request->post;
        $data->body=$request->comment;
        $data->user_id = auth()->user()->id;
        $data->save();
        return response()->json([
            'bool'=>true
        ]);
    }

    // Save Like Or dislike
    public function save_likedislike(Request $request){
        $data=new LikeDislike();
        $data->post_id=$request->post;
        $data->user_id = auth()->user()->id;
        if($request->type=='like'){
            $data->like=1;
        }else{
            $data->dislike=1;
        }
        $data->save();
        return response()->json([
            'bool'=>true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($hashtag)
    {

        $posts = Post::with('user')->orderBy('created_at','desc')

        ->where('hashtag', 'like', '%' . $hashtag . '%')
        ->get();



        return view('content.posts',compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id == $post->user_id) {
            if ($post->photos()->exists()) {
                $this->deleteImage($post->photos()->first()->src);
            }

            $post->delete();

            return redirect()->back();

        }
    }

    private function uploadImage($image)
    {
        $imageName = $image->hashName();
        Image::make($image)
            // ->resize(200, 500, function ($constraint) {
            //     $constraint->aspectRatio();
            // })
            ->save(public_path('images/posts/' . $imageName));
        return $imageName;
    }

    private function deleteImage($image)
    {
        Storage::disk('public_uploads')->delete('/images/posts' . $image);
    }
}

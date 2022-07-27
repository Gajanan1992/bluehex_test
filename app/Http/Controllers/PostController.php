<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['user', 'categories'])
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required',
            'categories' => 'required',
            'files' => 'nullable|max:2048',
        ]);
        // dd($request->all());
        try {
            DB::beginTransaction();

            $post = Post::create(array_merge($request->all(), ['user_id' => auth()->id()]));
            $post->categories()->sync($request->categories);

            //upload file
            if (count($request->files) > 0) {
                $this->handleFileUploads($request->file('files'), $post);
            }

            DB::commit();
            return redirect()->route('posts.index')->with('message', 'Post created successfully.');
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
            return redirect()->back()->with('message', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments', 'categories', 'photos', 'videos']);
        // dd($post);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required',
            'categories' => 'required',
        ]);

        $post->update($request->all());
        $post->categories()->sync($request->categories);

        return redirect()->route('posts.index')->with('message', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    //store comment
    public function storeComment(Post $post, Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',
            'files' => 'nullable|max:2048',
        ]);
        // dd($request->all());
        try {
            DB::beginTransaction();
            $comment = $post->comments()->create(array_merge($request->all(), ['user_id' => auth()->id(), 'post_id' => $post->id]));
            // dd(get_class($comment));
            if (count($request->files) > 0) {
                $this->handleFileUploads($request->file('files'), $comment);
            }
            DB::commit();
            return redirect()->back()->with('message', 'Comment created successfully.');
        } catch (\Exception $ex) {
            // dd($ex);
            DB::rollBack();
            return redirect()->back()->with('message', 'Something went wrong.');
            //throw $th;
        }
    }

    public function handleFileUploads($files, $model)
    {
        foreach ($files as $file) {
            if ($file->isValid()) {
                $mime = $file->getMimeType();
                $fileType = explode('/', $mime)[0];
                if ($fileType == 'image') {
                    $this->uploadImage($file, $model);
                } elseif ($fileType == 'video') {
                    $this->uploadVideo($file, $model);
                } else {
                    return redirect()->back()->with('message', 'File type is not supported');
                }
            }
        }
    }

    public function uploadImage($file, $model)
    {
        $fileName = time() . '-' . $file->getClientOriginalName();
        $path = $file->storeAs('public/images', $fileName);
        $photo = Photo::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'user_id' => auth()->id(),
        ]);

        DB::table('photoables')->insert([
            'photo_id' => $photo->id,
            'photoable_id' => $model->id,
            'photoable_type' => get_class($model),
        ]);
    }
    public function uploadVideo($file, $model)
    {
        $path = $file->storeAs('public/videos', $model->id . '_' . $file->getClientOriginalName());
        $video = Video::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'user_id' => auth()->id(),
        ]);

        DB::table('videoables')->insert([
            'video_id' => $video->id,
            'videoable_id' => $model->id,
            'videoable_type' => get_class($model),
        ]);
    }
}

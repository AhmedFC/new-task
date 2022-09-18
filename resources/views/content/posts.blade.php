@extends('master')

@section('content')
  <!-- Post content-->
  @foreach ($posts as $post )


  <article>
    <!-- Post header-->
    <header class="mb-4">
        <!-- Post title-->
        <h1 class="fw-bolder mb-1">{{$post->title}}</h1>
        <!-- Post meta content-->
        <div class="text-muted fst-italic mb-2">Posted on {{$post->created_at->toDayDateTimeString()}} by {{$post->user->name}}</div>
        @if($post->hashtag)
        <a class="text-muted fst-italic mb-2" href="{{route('posts.show',['post'=>$post->hashtag])}}"> #{{$post->hashtag}}</a>
        @endif
        @if(auth()->user()->id == $post->user_id)
        <small class="float-right">

        <form action="{{route('posts.destroy',['post'=>$post])}}" method="POST" style="display: inline-block" style="margin-left:60px">
            {{csrf_field()}}
            {{method_field('DELETE')}}

            <button type="submit" title="delete" class="btn btn-danger btn-sm delete" data-original-title="delete">
                <i class="fa fa-times"> delete</i>
            </button>
        </form>
        </small>
        @endif
    </header>
    <!-- Preview image figure-->
    <figure class="mb-4">
        @if($post->photos()->exists())
        <img class="img-fluid rounded" src="{{asset('images/posts').'/'.$post->photos()->first()->src}}" alt="..." />
        @else
        <img class="img-fluid rounded" src="https://dummyimage.com/900x400/ced4da/6c757d.jpg" alt="..." />
        @endif
    </figure>
    <!-- Post content-->
    <section class="mb-5">
        <p class="fs-5 mb-4">
         {{$post->description}}
        </p>

    </section>
</article>
<!-- Comments section-->

 {{-- Post Comments --}}
 <div class="card mt-4">
    <h5 class="card-header">Comments <span class="comment-count float-right badge badge-info" style="color: red">{{ count($post->comments) }}</span>
        <small class="float-right">
            <span title="Likes" id="saveLikeDislike" data-type="like" data-post="{{ $post->id}}" class="mr-2 btn btn-sm btn-outline-primary d-inline font-weight-bold">
                Like
                <span class="like-count">{{ $post->likes() }}</span>
            </span>
            <span title="Dislikes" id="saveLikeDislike" data-type="dislike" data-type="dislike" data-post="{{ $post->id}}" class="mr-2 btn btn-sm btn-outline-danger d-inline font-weight-bold">
                Dislike
                <span class="dislike-count">{{ $post->dislikes() }}</span>
            </span>
        </small>

    </h5>
    <div class="card-body">
        {{-- Add Comment --}}
        <div class="add-comment mb-3">
            @csrf
            <textarea class="form-control comment" placeholder="Enter Comment"></textarea>
            <button data-post="{{ $post->id }}" class="btn btn-dark btn-sm mt-2 save-comment">Submit</button>
        </div>
        <hr/>
        {{-- List Start --}}
        <div class="comments">
            @if(count($post->comments)>0)
                @foreach($post->comments as $comment)
                    <blockquote class="blockquote">
                      <small class="mb-0">{{ $comment->body }}</small>
                    </blockquote>
                    <hr/>
                @endforeach
            @else
            <p class="no-comments">No Comments Yet</p>
            @endif
        </div>
    </div>
</div>
{{-- ## End Post Comments --}}


@endforeach


@endsection


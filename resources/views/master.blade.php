<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Blog Post - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#!">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Blog</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
               @yield('content')
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">

                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Add post</div>
                        <div class="card-body">
                            <div class="row">
                                <form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                      <label for="title">title</label>
                                      <input type="text" class="form-control" id="title" name="title"  placeholder="Enter title">
                                    </div>
                                    <div class="form-group">
                                      <label for="description">description</label>
                                      <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="hashtag">hashtag</label>
                                        <input type="text" class="form-control" id="hashtag" name="hashtag"  placeholder="Enter hashtag">
                                      </div>
                                    <div class="form-group">
                                        <label for="image">image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                      </div>
                                    <button type="submit" class="btn btn-primary" style="margin-top: 10px">Add Post</button>
                                  </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2022</p></div>
        </footer>

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>


<script type="text/javascript">
// Save Comment
$(".save-comment").on('click',function(){
    var _comment=$(".comment").val();
    var _post=$(this).data('post');
    var vm=$(this);
    // Run Ajax
    $.ajax({
        url:"{{ url('save-comment') }}",
        type:"post",
        dataType:'json',
        data:{
            comment:_comment,
            post:_post,
            _token:"{{ csrf_token() }}"
        },
        beforeSend:function(){
            vm.text('Saving...').addClass('disabled');
        },
        success:function(res){
            var _html='<blockquote class="blockquote animate__animated animate__bounce">\
            <small class="mb-0">'+_comment+'</small>\
            </blockquote><hr/>';
            if(res.bool==true){
                $(".comments").prepend(_html);
                $(".comment").val('');
                $(".comment-count").text($('blockquote').length);
                $(".no-comments").hide();
            }
            vm.text('Save').removeClass('disabled');
        }
    });
});
</script>
<script type="text/javascript">
// Save Like Or Dislike
$(document).on('click','#saveLikeDislike',function(){
    var _post=$(this).data('post');
    var _type=$(this).data('type');
    var vm=$(this);
    // Run Ajax
    $.ajax({
        url:"{{ url('save-likedislike') }}",
        type:"post",
        dataType:'json',
        data:{
            post:_post,
            type:_type,
            _token:"{{ csrf_token() }}"
        },
        beforeSend:function(){
            vm.addClass('disabled');
        },
        success:function(res){
            if(res.bool==true){
                vm.removeClass('disabled').addClass('active');
                vm.removeAttr('id');
                var _prevCount=$("."+_type+"-count").text();
                _prevCount++;
                $("."+_type+"-count").text(_prevCount);
            }
        }
    });
});
// End
</script>

    </body>
</html>

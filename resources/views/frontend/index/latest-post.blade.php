<div class="posts-wrap">
    <div class="posts-list">
        @foreach ($latest_post as $value)
            <div class="posts-i">
                <a class="posts-i-img" href="post.html">
                    <span style="background: url({{asset('public/upload/post/'.$value->Post_Image)}})"></span>
                </a>
                <time class="posts-i-date" datetime="{{$value->created_at}}"><span>{{date_format(date_create($value->created_at),"d")}}</span>
                    {{date_format(date_create($value->created_at),"M, Y H:i:s")}}
                </time>
                <div class="posts-i-info">
                    <a href="blog.html" class="posts-i-ctg">Reviews</a>
                    <h3 class="posts-i-ttl">
                        <a href="post.html">{{$value->Post_Title}}</a>
                    </h3>
                </div>
            </div>
        @endforeach


    </div>
</div>




@foreach ($comments as $comment)
    <hr>
    <div class="media">
        <a href="" class="pull-left mr-2">
            <img width="60" src="{{ $comment->user->picture }}" alt="Image" class="media-object">
        </a>
        <div class="media-body">
            <h4 class="media-heading">{{ $comment->user->name }}</h4>
            @if ($comment->status != 0)
                <p class="text-danger">Bình luận vi phạm cộng đồng</p>
            @else
                <p>{{ $comment->content }}</p>
            @endif

            <p>
                @if (session()->has('user'))
                    <a href="" class=" btn-show-reply-form " data-id="{{ $comment->id }}"> Trả lời</a>
                @else
                    <a href="{{route('login')}}" > Trả lời</a>
                @endif

            </p>
            <form action="" style="display: none;" method="post" class="formReply form-reply-{{ $comment->id }}">


                <div class="form-group">


                    <textarea name="" id="content-reply-{{ $comment->id }}" class="form-control"
                        placeholder="Nhập nội dung bình luận...."></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-send-comment-reply" data-id="{{ $comment->id }}">Trả
                    lời bình luận</button>
                <hr>
            </form>




            {{-- bình luận cấp 2  --}}
            @foreach ($comment->replies as $child)
                <div class="media">
                    <a href="" class="pull-left mr-2">
                        <img width="60" src="{{ $child->user->picture }}" alt="Image" class="media-object">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{ $child->user->name }}</h4>
                        <p>
                            <span style="color: black; font-weight: bold">{{ $comment->user->name }}</span>

                            {{ $child->content }}
                        </p>
                        @if (session()->has('user'))
                            <a href="" class=" btn-show-reply-form " data-id="{{ $comment->id }}"> Trả lời</a>
                        @else
                            <button class="btn btn-xs" disabled>Trả lời</button>
                        @endif

                    </div>
                </div>
            @endforeach

        </div>

    </div>
@endforeach

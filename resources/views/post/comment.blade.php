<div class="comment" id="{{ $comment->id }}">
    @if ($comment->user->avatar)
                <div class="commentImg">
                    <img src="{{ asset($comment->user->avatar->path) }}" alt="">
                </div>
                @endif
    <div class="commentPost">
        <div class="commentAuthor">
            <a href="{{ route('user.show' , $comment->user->id) }}">{{ $comment->user->email }}</a>
        </div>
        <div class="commentContent"> 
            <p>
                {!! nl2br(e($comment->text)) !!}
            </p>
        </div> 
        <div class="commentTool">
            <a href="{{ route('comment.destroy' , $comment->id) }}" class="del">vymazať</a>
        </div>  
        <form id="del-{{ $comment->id }}" action="{{ route('comment.destroy' , $comment->id) }}" method="post" style="display: none">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
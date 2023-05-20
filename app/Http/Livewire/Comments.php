<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;
    public $perPage = 8;
    public $search;
    protected $listeners = [

        'deleteCommentAction',
        'editCommentAction',

    ];

    public function deleteComment($id, $post_id, $user_id, $reply_id)
    {
        $comment = Comment::find($id);
        $this->dispatchBrowserEvent('deleteComment', [
            'title' => 'Bạn có chắc ?',
            'html' => 'Bạn muốn xóa bình luận và bình luận liên quan : <br><b>' . $comment->content . '</b>',
            'id' => $id,

        ]);

    }

    public function deleteCommentAction($id)
    {

        $checkComment = Comment::where('id', $id)->first();

        $checkCommentsPost = Comment::where('post_id', $checkComment->post_id)->get();
        if ($checkCommentsPost) {
            foreach ($checkCommentsPost as $commentpost) {
                if ($checkComment->id == $commentpost->reply_id) {
                    $commentpost->delete();
                }

            }

            $checkComment->delete();

            $this->showToastr('Xóa bình luận thành công', 'success');


        } else {
            $this->showToastr('Không xóa bình luận được', 'error');
        }


    }


    public function editComment($id)
    {
        $comment = Comment::find($id);
        $this->dispatchBrowserEvent('editComment', [
            'title' => 'Bạn có chắc ?',
            'html' => 'Bình luận này vi phạm cộng đồng : <br><b>' . $comment->content . '</b>',
            'id' => $id,

        ]);

    }

    public function editCommentAction($id)
    {

        $checkComment = Comment::where('id', $id)->first();

        if ($checkComment) {

            $checkComment->status = 1;
            $saved = $checkComment->save();
            if ($saved) {
                $this->showToastr('Đã cập nhật trạng thái bình luận', 'success');
            } else {
                $this->showToastr('Không cập nhập được trạng thái bình luận', 'error');
            }



        } else {
            $this->showToastr('Không cập nhập được trạng thái bình luận', 'error');
        }


    }







    public function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToastr', [
            'type' => $type,
            'message' => $message
        ]);

    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::search(trim($this->search))
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage),
            'highlight' => $this->search
        ]);
    }

    protected function highlight($text)
    {
        return str_replace(trim($this->search), '<span style="background-color: yellow">' . $this->search . '</span>', $text);
    }
}
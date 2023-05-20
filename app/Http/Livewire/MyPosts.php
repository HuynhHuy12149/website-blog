<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;


class MyPosts extends Component
{
    use WithPagination;
    public $perPage = 8, $orderBy = 'desc';
    public $search = null, $author = null, $category = null;
    protected $listeners = [
        'deletePostAction'
    ];
    public function mount()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingCategory()
    {
        $this->resetPage();
    }
    public function updatingAuthor()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.my-posts', [
            'posts' =>  Post::search(trim($this->search))
                            ->when($this->category, function ($query) {
                                $query->where('category_id', $this->category);
                            })
                            ->join('users', 'users.id', '=', 'posts.author_id') // Thêm join với bảng users
                            ->where('author_id', auth()->id())
                            ->when($this->orderBy, function ($query) {
                                $query->orderBy('id', $this->orderBy);
                            })
                            ->where('status', '!=', 0)
                            ->select('posts.*', 'users.name as author_name') // Chỉ định cột name trong bảng users với alias là author_name
                            ->paginate($this->perPage),
                    'highlight' => $this->search
        ]);

    }

    protected function highlight($text)
    {
        return str_replace(trim($this->search), '<span style="background-color: yellow">' . $this->search . '</span>', $text);
    }

    public function deletePost($id)
    {
        $this->dispatchBrowserEvent('deletePost', [
            'title' => 'Bạn có chắc ?',
            'html' => ' Bạn muốn xóa bài viết.',
            'id' => $id
        ]);
    }

    public function deletePostAction($id)
    {
        $post = Post::find($id);
        $path = "images/post_images/";
        $featured_image = $post->featured_image;
        if (Storage::disk('public')->exists($path . 'thumbnails/resized_' . $featured_image)) {
            Storage::disk('public')->delete($path . 'thumbnails/resized_' . $featured_image);
        }

        if (Storage::disk('public')->exists($path . 'thumbnails/thumb_' . $featured_image)) {
            Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $featured_image);
        }

        Storage::disk('public')->delete($path . $featured_image);

        $delete_post = $post->delete();
        if ($delete_post) {
            $this->showToastr('Bài viết được Xóa thành công.', 'success');
        } else {
            $this->showToastr('Bài viết chưa được xóa', 'error');
        }

    }

    public function showToastr($message,$type){
        $this->dispatchBrowserEvent('showToastr',[
            'type'=>$type,
            'message'=>$message
        ]);
    }
}

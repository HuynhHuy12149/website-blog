<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;
use Illuminate\Support\Facades\Mail;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class Authors extends Component
{
    use WithPagination;
    public $name, $email, $username, $author_type;
    public $type = null;
    public $search;
    public $perPage = 8;
    public $selected_author_id;
    public $blocked = 0;

    // $listeners là một thuộc tính trong đối tượng Livewire cho phép bạn đăng ký các sự kiện
    public $listeners = [
        'resetForms',
        'deleteAuthorAction'
    ];

    public function resetForms()
    {
        $this->name = $this->email = $this->username = $this->author_type = null;
        $this->resetErrorBag(); //xóa tất cả các lỗi trong danh sách này
    }

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function addAuthor()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username|min:6|max:20',
            'author_type' => 'required',

        ], [
                'author_type.required' => 'Chọn loại tài khoản',
                'direct_publisher.required' => 'Chỉ rõ tài khoản có được kích hoạt hay không',
            ]);

        if ($this->isOnline()) {
            $default_password = Random::generate(8);

            $author = new User();
            $author->name = $this->name;
            $author->email = $this->email;
            $author->username = $this->username;
            $author->password = Hash::make($default_password);
            $author->type = $this->author_type;

            $saved = $author->save();

            $data = array(
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'password' => $default_password,
                'url' => route('author.profile'),
            );

            $author_email = $this->email;
            $author_name = $this->name;

            if ($saved) {
                Mail::send('new-author-email-template', $data, function ($message) use ($author_email, $author_name) {
                    $message->from('ykhoalx123@gmail.com', 'BlogSunshine');
                    $message->to($author_email, $author_name)
                        ->subject('Tạo tài khoản');
                });

                $this->showToastr('Thêm tác giả thành công', 'success');
                $this->name = $this->email = $this->username = $this->author_type = $this->direct_publisher = null;
                $this->dispatchBrowserEvent('hide_and_author_modal'); //gửi sự kiện 'hide_and_author_modal' đến trình duyệt
            } else {
                $this->showToastr('Thêm thất bại', 'error');
            }
        } else {
            $this->showToastr('Bạn đang offline, vui lòng kiểm tra lại kết nối internet và gửi lại biểu mẫu sau ít phút', 'error');
        }
    }

    // edit
    public function editAuthor($author)
    {
        $this->selected_author_id = $author['id'];
        $this->name = $author['name'];
        $this->email = $author['email'];
        $this->username = $author['username'];
        $this->author_type = $author['type'];
        // $this->direct_publisher = $author['direct_publish'];
        $this->blocked = $author['blocked'];
        $this->dispatchBrowserEvent('showEditAuthorModal');
    }

    public function updateAuthor()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->selected_author_id,
            'username' => 'required|min:6|max:20|unique:users,username,' . $this->selected_author_id,
        ]);

        if ($this->selected_author_id) {
            $author = User::find($this->selected_author_id);
            $author->update([
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'type' => $this->author_type,
                'blocked' => $this->blocked,
                // 'direct_publish'=>$this->direct_publisher,
            ]);

            $this->showToastr('Đã cập nhật thông tin tác giả thành công', 'success');
            $this->dispatchBrowserEvent('hide_edit_author_modal');
        }
    }

    // delete
    public function deleteAuthor($author)
    {
        $this->dispatchBrowserEvent('deleteAuthor', [
            'title' => 'Bạn có chắc?',
            'html' => 'Bạn muốn xóa tác giả:<br><b>' . $author['name'] . '</b>',
            'id' => $author['id'],
        ]);
    }

    public function deleteAuthorAction($id)
    {
        $author = User::find($id);
        $path = 'back/dist/img/authors/';
        $author_picture = $author->getAttributes()['picture'];
        $picture_full_path = $path . $author_picture;
        if ($author_picture != null || File::exists(public_path($picture_full_path))) {
            File::delete(public_path($picture_full_path));
        }
        $author->delete();
        $this->showToastr('Xóa tác giả thành công', 'success');
    }

    // sử dụng dispatchBrowserEvent để phát ra sự kiện showToastr
    public function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToastr', [
            'type' => $type,
            'message' => $message
        ]);
    }

    public function isOnline($site = "https://youtube.com/")
    {
        if (@fopen($site, "r")) {
            return true;
        } else {
            return false;
        }
    }

    public function render()
    {
        // //Phương thức này sẽ trả về tất cả các tài khoản người dùng trừ tài khoản đang đăng nhập
        // return view('livewire.authors',[
        //     'authors'=>User::search(trim($this->search))
        //                     ->where('id','!=',auth()->id())
        //                     ->where('type',$this->type)
        //                     ->paginate($this->perPage),//điều kiện id != auth()->id()
        //                     'highlight' => $this->search // truyền từ khóa tìm kiếm để highlight vào view
        // ]);

        // Tạo một biến $authorsQuery để lưu trữ câu truy vấn trước khi phân trang
        $authorsQuery = User::search(trim($this->search))
            ->where('id', '!=', auth()->id());

        // Nếu $this->type không rỗng, thêm điều kiện lọc theo loại tài khoản
        if (!empty($this->type)) {
            $authorsQuery = $authorsQuery->where('type', $this->type);
        }

        // Trả về view với dữ liệu tài khoản đã phân trang
        return view('livewire.authors', [
            'authors' => $authorsQuery->paginate($this->perPage),
            'highlight' => $this->search
        ]);
    }

    protected function highlight($text)
    {
        return str_replace(trim($this->search), '<span style="background-color: yellow">' . $this->search . '</span>', $text);
    }
}
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\Post;


class Categories extends Component
{
    use WithPagination;
    public $perPage = 8;
    public $category_name;
    public $selected_category_id;
    public $updateCategoryMode = false;

    public $subcategory_name;
    public $parent_category = 0;
    public $selected_subcategory_id;
    public $updateSubCategoryMode = false;

    protected $listeners = [
        'resetModalForm',
        'deleteCategoryAction',
        'deleteSubCategoryAction',
        'updateCategoryOrdering',
        'updateSubCategoryOrdering'
    ];

    public function resetModalForm(){
        $this->resetErrorBag();
        $this->category_name = null;
        $this->subcategory_name = null;
        $this->parent_category = null;
    }

    // category
    public function addCategory(){
        $this->validate([
            'category_name' => 'required|unique:categories,category_name',
        ]);

        $category = new Category();
        $category->category_name = $this->category_name;
        $saved = $category->save();

        if($saved){
            $this->dispatchBrowserEvent('hideCategoriesModel');
            $this->category_name = null;
            $this->showToastr('Thêm danh mục thành công.','success');
        }else {
            $this->showToastr('Thêm thất bại', 'error');
        }
    }
    
    public function editCategory($id){
        $category = Category::findOrFail($id);
        $this->selected_category_id = $category->id;
        $this->category_name = $category->category_name;
        $this->updateCategoryMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showCategoriesModal');
    }

    public function updateCategory(){
        $this->validate([
            'category_name' => 'required|unique:categories,category_name,'.$this->selected_category_id,
        ]);

        $category = Category::findOrFail($this->selected_category_id);
        $category->category_name = $this->category_name;
        $update = $category->save(); //khi muốn cập nhật thuộc tính cụ thể dùng update còn lại dùng save()

        if($update){
            $this->showToastr('Đã cập nhật danh mục thành công','success');
            $this->dispatchBrowserEvent('hideCategoriesModel');
            $this->updateCategoryMode = false;
        }else{
            $this->showToastr('Cập nhật Thất bại','success');
        }
    }

    //gọi form xoa và xóa bên category
    public function deleteCategory($id){
        $category = Category::find($id);
       $this->dispatchBrowserEvent('deleteCategory',[
            'title'=>'Bạn có chắc ?',
            'html'=>'Bạn muốn xóa danh mục : <br><b>'.$category->category_name.'</b>',
            'id'=>$id,
       ]);

    }
    
    public function deleteCategoryAction($id){
        
        $category = Category::where('id',$id)->first();
        $subcategories = SubCategory::where('parent_category',$category->id)->whereHas('posts')->with('posts')->get();
        if(!empty($subcategories ) && count($subcategories)>0){
            $totalPosts =  0;
            foreach($subcategories as $subcategory){
                $totalPosts += Post::where('category_id',$subcategory->id)->get()->count();
            }
            $this->showToastr('Danh mục này có ('.$totalPosts.') bài đăng liên quan, không thể xóa được.','error');
        }else {
            SubCategory::where('parent_category',$category->id)->delete();
            $category->delete();
            $this->showToastr('Xóa danh mục thành công','success');
        }
    }


    // Subcategories
    public function addSubCategory(){
        $this->validate([
            'parent_category' => 'required',
            'subcategory_name' => 'required|unique:sub_categories,subcategory_name',
        ]);

        $subcategory = new SubCategory();
        $subcategory->subcategory_name = $this->subcategory_name;
        $subcategory->slug = Str::slug($this->subcategory_name);// tạo một slug cho một danh mục con
        $subcategory->parent_category = $this->parent_category;
        $saved = $subcategory->save();

        if($saved){
            $this->dispatchBrowserEvent('hideSubCategoriesModel');
            $this->parent_category = null;
            $this->subcategory_name = null;
            $this->showToastr('Thêm danh mục con thành công.','success');
        }else {
            $this->showToastr('Thêm thất bại', 'error');
        }
    }

    public function editSubCategory($id){
        $subcategory = SubCategory::findOrFail($id);
        $this->selected_subcategory_id = $subcategory->id;
        $this->parent_category = $subcategory->parent_category;
        $this->subcategory_name = $subcategory->subcategory_name;
        $this->updateSubCategoryMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showSubCategoriesModal');
    }

    public function updateSubCategory(){
        if($this->selected_subcategory_id){
            $this->validate([
                'parent_category' => 'required',
                'subcategory_name' => 'required|unique:sub_categories,subcategory_name,'.$this->selected_subcategory_id,
            ]);
    
            $subcategory = SubCategory::findOrFail($this->selected_subcategory_id);
            $subcategory->subcategory_name = $this->subcategory_name;
            $subcategory->slug = Str::slug($this->subcategory_name);
            $subcategory->parent_category = $this->parent_category;
            $update = $subcategory->save(); //khi muốn cập nhật thuộc tính cụ thể dùng update còn lại dùng save
    
            if($update){
                $this->showToastr('Đã cập nhật danh mục  conthành công','success');
                $this->dispatchBrowserEvent('hideSubCategoriesModel');
                $this->updateSubCategoryMode = false;
            }else{
                $this->showToastr('Cập nhật Thất bại','success');
            }
        }
    }

    // // gọi form xoa và xóa bên subcategory
    public function deleteSubCategory($id){
        $subcategory = SubCategory::find($id);
       $this->dispatchBrowserEvent('deleteSubCategory',[
            'title'=>'Bạn có chắc ?',
            'html'=>'Bạn muốn xóa danh mục con : <br><b>'.$subcategory->subcategory_name.'</b> category',
            'id'=>$id,
       ]);

    }

    public function deleteSubCategoryAction($id){
    
        
        
        $subcategory = SubCategory::where('id',$id)->first();
        $posts = Post::where('category_id',$subcategory->id)->get()->toArray();

      
        if(!empty($posts) && count($posts)>0){
            
            $this->showToastr('Danh mục con này có ('.count($posts).') bài đăng liên quan, không thể xóa được.','error');
        }else {
            $subcategory->delete();
            $this->showToastr('Xóa danh mục con thành công','success');
        }
    }

    // thay đổi vị trí danh mục
    public function updateCategoryOrdering($positions){
        foreach($positions as $position){
            $index = $position[0];
            $newPosition = $position[1];
            Category::where('id',$index)->update([
                'ordering'=>$newPosition,
            ]);
            $this->showToastr('Thứ tự các danh mục đã được cập nhật thành công.','success');
        }
    }

    public function updateSubCategoryOrdering($positions){
       
        foreach($positions as $position){
            $index = $position[0];
            $newPosition = $position[1];
            SubCategory::where('id',$index)->update([
                'ordering'=>$newPosition,
            ]);
            $this->showToastr('Thứ tự các danh mục đã được cập nhật thành công.','success');
        }
    }

    // sử dụng dispatchBrowserEvent để phát ra sự kiện showToastr
    public function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToastr',[
            'type' => $type,
            'message' => $message
        ]);

    }

    public function render()
    {
        
        return view('livewire.categories',[
            'categories'=>Category::orderBy('ordering','asc')->get(),
            'subcategories'=>SubCategory::orderBy('ordering','asc')->paginate($this->perPage),
        ]);
    }


}

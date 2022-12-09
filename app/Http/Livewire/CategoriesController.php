<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $name, $description, $image, $search, $selected_id, $componentName, $pageTitle;
    private $pagination = 10;

    public function mount() {
        $this->componentName = 'Categorías';
        $this->pageTitle = 'Listado';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {

        if (strlen($this->search) > 0) {
            sleep(1);
            $data = Category::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $data = Category::orderBy('id', 'desc')->paginate($this->pagination);
        }
        

        return view('livewire.category.categories', ['categories' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id)
    {
        $record = Category::find($id, ['id', 'name', 'description', 'image']);
        $this->name = $record->name;
        $this->description = $record->description;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
        
    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:categories|min:3',
            'description' => 'required|min:5',
            'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048'
        ];

        $this->validate($rules);

        $category = Category::create([
            'name' => $this->name,
            'description' => $this->description
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        $this->ResetUI();
        $this->emit('category-added', 'categoría registrada');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}",
            'description' => 'required|min:5',
            'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048'
        ];

        $this->validate($rules);

        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name,
            'description' => $this->description
        ]);

        if ($this->image) {

            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();

            if ($imageName != NULL) {
                if (file_exists('storage/categories/' . $imageName)) {
                    unlink('storage/categories/' . $imageName);
                }
            }
        }

        $this->ResetUI();
        $this->emit('category-updated', 'Categoría actualizada.');
        
    }

    public function ResetUI()
    {
        $this->resetValidation();
        $this->name = '';
        $this->description = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
        $this->resetPage();
    }

    protected $listeners = [
        'deleteRecord' => 'Destroy'
    ];

    public function Destroy(Category $category)
    {
        $imageName = $category->image;
        $category->delete();

        if ($imageName != NULL) {
            unlink('storage/categories/' . $imageName);
        }

        $this->ResetUI();
        $this->emit('category-deleted', 'Categoría eliminada.');
    }
}

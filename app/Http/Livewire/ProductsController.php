<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductsController extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $name, $barcode, $cost, $price, $stock, $alert, $status, $categoryid, $search, $image, $actImage;
    public $selected_id, $pageTitle, $componentName;
    public $sortDirection, $sortField;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount() {

        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->status = 'Elegir';
        $this->categoryid = 'Elegir';
        $this->sortField = 'name';
        $this->sortDirection = 'asc';
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            sleep(1);
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                ->orWhere('c.name', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->pagination);
        } else {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
            ->select('products.*', 'c.name as category')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->pagination);
        }

        return view('livewire.products.component', [
            'data' => $products,
            'categories' => Category::orderBy('name', 'asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:products|min:3',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alert' => 'required',
            'status' => 'required|not_in:Elegir',
            'categoryid' => 'required|not_in:Elegir',
            'image' => 'image|max:1024'
        ];

        $this->validate($rules);

        $product = Product::create([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'cost' => $this->cost,
            'price' => $this->price,
            'stock' => $this->stock,
            'alert' => $this->alert,
            'status' => $this->status,
            'category_id' => $this->categoryid
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }

        $this->resetUI();
        $this->emit('product-added', 'Producto guardado.');
    }

    public function Edit(Product $product)
    {
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alert = $product->alert;
        $this->status = $product->status;
        $this->actImage = $product->image;
        $this->image = '';
        $this->categoryid = $product->category_id;

        $this->emit('show-modal', 'Show Modal');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alert' => 'required',
            'status' => 'required|not_in:Elegir',
            'categoryid' => 'required|not_in:Elegir',
            'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048'
        ];

        $this->validate($rules);

        $product = Product::find($this->selected_id);

        $product->update([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'cost' => $this->cost,
            'price' => $this->price,
            'stock' => $this->stock,
            'alert' => $this->alert,
            'status' => $this->status,
            'category_id' => $this->categoryid
        ]);

        if ($this->image) {
            
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $imageTemp = $product->image;
            $product->image = $customFileName;
            $product->save();

            if ($imageTemp != NULL) {
                if (file_exists('storage/products/' . $imageTemp)) {
                    unlink('storage/products/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('product-updated', 'Producto actualizado.');
    }

    public function ResetUI()
    {

        $this->resetValidation();
        $this->name = '';
        $this->barcode = '';
        $this->cost = '';
        $this->price = '';
        $this->stock = '';
        $this->alert = '';
        $this->search = '';
        $this->categoryid = 'Elegir';
        $this->status = 'Elegir';
        $this->image = null ;
        $this->selected_id = 0 ;
        $this->resetPage();
    }

    protected $listeners = ['deleteRecord' => 'Destroy'];

    public function Destroy(Product $product)
    {
        $imageTemp = $product->image;
        $product->delete();

        if ($imageTemp != NULL) {
            if (file_exists('storage/products/' . $imageTemp)) {
                unlink('storage/products/' . $imageTemp);
            }
        }

        $this->resetUI();
        $this->emit('product-deleted', 'Producto eliminado.');

    }
}

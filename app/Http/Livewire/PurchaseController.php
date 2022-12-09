<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PurchaseController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $supplierName, $supplierPhone, $quantity, $total, $supplierid, $checkProduct, $checkSupplier;
    public $oldSupplierName, $productName, $productid, $barcode, $cost, $price, $image, $stock, $alert, $categoryid;
    public $search, $searchp, $searchs, $pageTitle, $componentName;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->checkProduct = false;
        $this->checkSupplier = false;
        $this->supplierid = 0;
        $this->productid = 0;
        $this->categoryid = "Elegir";
        $this->pageTitle = "Listado";
        $this->componentName = "Compras";
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            sleep(1);
            $purchases = Purchase::join('suppliers as s', 's.id', 'purchases.supplier_id')
                ->join('products as p', 'p.id', 'purchases.product_id')
                ->join('users as u', 'u.id', 'purchases.user_id')
                ->select('purchases.quantity', 'purchases.total', 's.name as supplier', 'p.name as products', 'u.name as user', 'purchases.created_at as date')
                ->where('p.name', 'like', '%' . $this->search . '%')
                ->orWhere('s.name', 'like', '%' . $this->search . '%')
                ->orWhere('u.name', 'like', '%' . $this->search . '%')
                ->orderBy('products', 'asc')
                ->paginate($this->pagination);
        } else {
            $purchases = Purchase::join('suppliers as s', 's.id', 'purchases.supplier_id')
                ->join('products as p', 'p.id', 'purchases.product_id')
                ->join('users as u', 'u.id', 'purchases.user_id')
                ->select('purchases.quantity', 'purchases.total', 's.name as supplier', 'p.name as products', 'u.name as user', 'purchases.created_at as date')
                ->orderBy('products', 'asc')
                ->paginate($this->pagination);
        }

        return view('livewire.purchase.component', [
            'suppliers' => Supplier::where('name', 'like', '%' . $this->searchs . '%')
                                    ->limit(10)
                                    ->get(),
            'products' => Product::where('name', 'like', '%' . $this->searchp . '%')
                                    ->limit(10)
                                    ->get(),
            'categories' => Category::orderBy('name', 'asc')->get(),
            'purchases' => $purchases

        ])
        ->extends('layouts.theme.app')
        ->section('content');

    }

    public function SearchSupplier($supplierid)
    {
        $supplier = Supplier::find($supplierid);
        $this->oldSupplierName = $supplier->name;
        $this->supplierid = $supplierid;
        $this->searchs = null;
    }

    public function Store()
    {
        if ($this->checkSupplier == true AND $this->checkProduct == false) {

            $rules = [
                'supplierName' => 'required|unique:suppliers,name|min:3',
                'supplierPhone' => 'required|min:8|max:9',
                'productName' => "required|min:3|unique:products,name,{$this->productid}",
                'cost' => 'required',
                'price' => 'required',
                'alert' => 'required',
                'categoryid' => 'required|not_in:Elegir',
                'supplierid' => 'required|not_in:Elegir',
                'quantity' => 'required',
                'total' => 'required',
                'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048',
            ];

            $this->validate($rules);

            DB::beginTransaction();

            try {
                $product = Product::find($this->productid);

                
                $supplier = Supplier::create([
                    'name' => $this->supplierName,
                    'phone' => $this->supplierPhone
                ]);

                $supplierid = $supplier->id;
                
                $purchase = Purchase::create([
                    'quantity' => $this->quantity,
                    'total' => $this->total,
                    'product_id' => $this->productid,
                    'supplier_id' => $supplierid,
                    'user_id' => Auth()->user()->id
                ]);

                $newStock = $this->stock + $this->quantity;
    
                $product->update([
                    'name' => $this->productName,
                    'barcode' => $this->barcode,
                    'cost' => $this->cost,
                    'price' => $this->price,
                    'stock' => $newStock,
                    'alert' => $this->alert,
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
    
                DB::commit();

                $this->resetUI();
                $this->emit('purchase-updated', 'Compra agregada + producto actualizado.');

            } catch (Exception $e) {
                DB::rollback();
                $this->emit('purchase-error', $e->getMessage());
            }

        } elseif ($this->checkProduct == true AND $this->checkSupplier == false) {
            /* $data = 'Nuevo producto y Proveedor registrado';
            dd($data); */

            $rules = [
                'productName' => 'required|unique:products,name|min:3',
                'cost' => 'required',
                'price' => 'required',
                'alert' => 'required',
                'categoryid' => 'required|not_in:Elegir',
                'supplierid' => 'required|not_in:Elegir',
                'quantity' => 'required',
                'total' => 'required',
                'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048',
            ];
    
            $this->validate($rules);

            DB::beginTransaction();

            try {

                $product = Product::create([
                    'name' => $this->productName,
                    'barcode' => $this->barcode,
                    'cost' => $this->cost,
                    'price' => $this->price,
                    'stock' => $this->quantity,
                    'alert' => $this->alert,
                    'category_id' => $this->categoryid
                ]);

                $productid = $product->id;

                if ($this->image) {
                    $customFileName = uniqid() . '_.' . $this->image->extension();
                    $this->image->storeAs('public/products', $customFileName);
                    $product->image = $customFileName;
                    $product->save();
                }

                $purchase = Purchase::create([
                    'quantity' => $this->quantity,
                    'total' => $this->total,
                    'product_id' => $productid,
                    'supplier_id' => $this->supplierid,
                    'user_id' => Auth()->user()->id
                ]);
        
                DB::commit();
                
                $this->resetUI();
                $this->emit('purchase-updated', 'Compra agregada + producto agregado + proveedor registrado.');

            } catch (Exception $e) {
                DB::rollback();
                $this->emit('purchase-error', $e->getMessage());
            }

        } elseif ($this->checkSupplier == true AND $this->checkProduct == true) {
            /* $data = 'Nuevo producto y Nuevo proveedor';
            dd($data); */

            $rules = [
                'productName' => 'required|unique:products,name|min:3',
                'supplierName' => 'required|unique:suppliers,name|min:3',
                'supplierPhone' => 'required|min:8|max:9',
                'cost' => 'required',
                'price' => 'required',
                'alert' => 'required',
                'categoryid' => 'required|not_in:Elegir',
                'quantity' => 'required',
                'total' => 'required',
                'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048'
            ];
    
            $this->validate($rules);

            DB::beginTransaction();

            try {

                $supplier = Supplier::create([
                    'name' => $this->supplierName,
                    'phone' => $this->supplierPhone
                ]);
                

                $supplierid = $supplier->id;

                $product = Product::create([
                    'name' => $this->productName,
                    'barcode' => $this->barcode,
                    'cost' => $this->cost,
                    'price' => $this->price,
                    'stock' => $this->quantity,
                    'alert' => $this->alert,
                    'category_id' => $this->categoryid
                ]);

                $productid = $product->id;

                if ($this->image) {
                    $customFileName = uniqid() . '_.' . $this->image->extension();
                    $this->image->storeAs('public/products', $customFileName);
                    $product->image = $customFileName;
                    $product->save();
                }

                $purchase = Purchase::create([
                    'quantity' => $this->quantity,
                    'total' => $this->total,
                    'product_id' => $productid,
                    'supplier_id' => $supplierid,
                    'user_id' => Auth()->user()->id
                ]);

                DB::commit();
                
                $this->resetUI();
                $this->emit('purchase-updated', 'Compra agregada + producto nuevo + proveedor nuevo.');

            } catch (Exception $e) {
                DB::rollback();
                $this->emit('purchase-error', $e->getMessage());
            }
        } else {
            /* $data = 'Producto registrado y Proveedor registrado';
            dd($data); */

            $rules = [
                'productName' => "required|min:3|unique:products,name,{$this->productid}",
                'cost' => 'required',
                'price' => 'required',
                'alert' => 'required',
                'categoryid' => 'required|not_in:Elegir',
                'supplierid' => 'required|not_in:Elegir',
                'quantity' => 'required',
                'total' => 'required',
                'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048',
            ];

            $this->validate($rules);

            DB::beginTransaction();

            try {
                $product = Product::find($this->productid);
                
                $purchase = Purchase::create([
                    'quantity' => $this->quantity,
                    'total' => $this->total,
                    'product_id' => $this->productid,
                    'supplier_id' => $this->supplierid,
                    'user_id' => Auth()->user()->id
                ]);

                $newStock = $this->stock + $this->quantity;
    
                $product->update([
                    'name' => $this->productName,
                    'barcode' => $this->barcode,
                    'cost' => $this->cost,
                    'price' => $this->price,
                    'stock' => $newStock,
                    'alert' => $this->alert,
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
    
                DB::commit();

                $this->resetUI();
                $this->emit('purchase-updated', 'Compra agregada + producto actualizado + proveedor registrado.');

            } catch (Exception $e) {
                DB::rollback();
                $this->emit('purchase-error', $e->getMessage());
            }
        }

    }

    public function Edit(Product $product)
    {
        $this->productid = $product->id;
        $this->productName = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alert = $product->alert;
        $this->image = null;
        $this->searchp = null;
        $this->categoryid = $product->category_id;

        $this->emit('show-modal', 'Show Modal');
    }

    protected $listeners = [
        'clear-product' => 'clearProduct',
        'clear-supplier' => 'clearSupplier'
    ];

    public function clearProduct()
    {
        $this->resetValidation();
        $this->resetExcept('pageTitle', 'componentName', 'supplierName', 'supplierPhone', 'supplierid', 'checkProduct', 'checkSupplier');
        $this->resetPage();
        $this->productid = 0;
        $this->categoryid = "Elegir";
        $this->emit('form-product', 'Clear form');
    }

    public function clearSupplier()
    {
        $this->resetValidation();
        $this->resetExcept('pageTitle', 'componentName', 'productName', 'productid', 'barcode', 'cost', 'price', 'image', 'stock', 'alert', 'categoryid', 'checkProduct', 'checkSupplier');
        $this->resetPage();
        $this->supplierid = 0;
        $this->emit('form-supplier', 'Clear form');
    }

    public function ResetUI()
    {

        $this->resetValidation();
        $this->resetExcept('pageTitle', 'componentName');
        $this->resetPage();
        $this->supplierid = 0;
        $this->productid = 0;
        $this->categoryid = "Elegir";
        $this->checkProduct = false;
        $this->checkSupplier = false;
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class PosController extends Component
{

    public $total, $itemsQuantity, $efectivo, $change, $discTotal;

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }
    
    public function render()
    {
        $this->denominations = Denomination::all();
        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'cart' => Cart::getContent()->sortBy('name')
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function ACash($value)
    {
        $this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }

    public function updateCash($ucash)
    {
        $this->efectivo = $ucash;
        $this->change = ($this->efectivo - $this->total);
    }

    protected $listeners = [
        'scan-code' => 'scanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale',
        'scan-code-byId' => 'scanCodeById'
    ];

    public function discount($productId, $discount)
    {
        $product = Product::find($productId);

        $discount;

        $getCart = Cart::get($productId);

        $cant = $getCart->quantity;

        Cart::add($product->id, $product->name, $product->price, $cant, [$product->stock, $discount]);
        Cart::update($productId, array(
            'quantity' => array(
                'relative' => false,
                'value' => $cant
            )
        ));
        
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Se aplico el descuento al producto: ' . $product->name);

    }

    public function scanCodeById(Product $product)
    {
        $this->increaseQty($product->id);
    }

    public function scanCode($barcode, $cant = 1)
    {
        $product = Product::where('barcode', $barcode)->first();
        
        if ($product == null) {
            
            $this->emit('scan-notfound', 'No se encontró el producto.');
        } else {
            if ($this->InCart($product->id)) {
                $this->increaseQty($product->id);
                return;
            }

            if ($product->stock < 1) {
                $this->emit('no-stock', 'Existencias no disponibles del producto.');
                return;
            }
            
            if ($product->status == 0) {
                $this->emit('no-stock', 'Producto desactivado.');
                return;
            }

            Cart::add($product->id, $product->name, $product->price, $cant, [$product->stock, $product->discount]);
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->total = Cart::getTotal();
    
            $this->emit('scan-ok', 'Se agregó el producto.');

        }


    }

    public function InCart($productId)
    {
        $exist = Cart::get($productId);

        if ($exist) {
            return true;
        } else {
            return false;
        }
        
    }

    public function increaseQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);

        if ($exist) {
            $title = 'Se actualizo la cantidad.';
        } else {
            $title = 'Producto agregado.';
        }
        
        if ($exist) {
            $discount = $exist->attributes[1];
            if ($product->stock < ($cant + $exist->quantity)) {
                $this->emit('no-stock', 'Existencias no disponibles del producto.');
                return;
            }
        } else {
            $discount = 0;
        }
        
        Cart::add($product->id, $product->name, $product->price, $cant, [$product->stock, $discount]);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->emit('scan-ok', $title);

    }

    public function updateQty($productId, $cant = 1, $discount = 0)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);

        if ($exist) {
            $title = 'Se actualizo la cantidad.';
        } else {
            $title = 'Producto agregado.';
        }

        if ($exist) {
            if ($product->stock < $cant) {
                $this->emit('no-stock', 'Existencias no disponibles del producto.');
                return;
            }
        }

        $this->removeItem($productId);

        if ($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant, [$product->stock, $discount]);
        }
        
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        
        $this->emit('scan-ok', $title);
        
    }

    public function removeItem($productId)
    {
        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Producto eliminado.');
    }

    public function decreaseQty($productId, $discount = 0)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);

        $newQty = ($item->quantity) - 1;

        if ($newQty > 0) {
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes);
        }

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Se actualizo la cantidad.');

    }

    public function clearCart()
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Carrito vacío');
    }

    public function saveSale()
    {
        if ($this->total <= 0) {
            $this->emit('sale-error', 'Agrega productos a la venta');
            return;
        }

        if ($this->efectivo <= 0) {
            $this->emit('sale-error', 'Ingresar el efectivo');
            return;
        }

        if ($this->total > $this->efectivo) {
            $this->emit('sale-error', 'El efectivo debe ser mayor o igual al total');
            return;
        }

        $stockCheck = Cart::getContent();

        foreach ($stockCheck as $check) {

            $product = Product::find($check->id);

            if ($product->stock <= 0) {
                Cart::remove($check->id);
                $this->emit('sale-error', 'El producto: ' . $product->name . ' se quedó sin existencias.');
                $this->total = Cart::getTotal();
                $this->itemsQuantity = Cart::getTotalQuantity();
                return;
            }

        }
        

        DB::beginTransaction();

        try {

            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,
                'user_id' => Auth()->user()->id
            ]);

            if ($sale) {
                $items = Cart::getContent();
                foreach ($items as $item) {
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'discount' => $item->attributes[1],
                        'product_id' => $item->id,
                        'sale_id' => $sale->id
                    ]);

                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }
            }

            DB::commit();

            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->emit('sale-ok', 'Venta registrada con exito');
            return Redirect::to("ventas/$sale->id");

        } catch (Exception $e) {
            
            DB::rollback();
            $this->emit('sale-error', $e->getMessage());
        }
    }

}

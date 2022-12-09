<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ModalSearch extends Component
{
    public $search, $products = [];

    public function liveSearch()
    {

        if (strlen($this->search) > 0) {

            $this->products = Product::join('categories as c', 'products.category_id', 'c.id')
            ->select('products.*', 'c.name as category')
            ->where('products.stock', '>', 0)
            ->where('products.status', '>', 0)
            ->where(function($query) {
                $query->orWhere('products.name', 'like', '%' . $this->search . '%')
                      ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                      ->orWhere('c.name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('products.name', 'asc')
            ->get();
        } else {
            return $this->products = [];
        }
    }

    public function render()
    {
        $this->liveSearch();
        return view('livewire.modalsearch.component');
    }

    public function addAll()
    {
        if (count($this->products) > 0) {
            sleep(1);
            foreach ($this->products as $product) {
                $this->emit('scan-code-byId', $product->id);
            }
        }
    }

    public function ResetUI()
    {
        $this->search = null;
        $this->products = [];
    }
}

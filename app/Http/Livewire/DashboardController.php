<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardController extends Component
{
    public $names = [], $sales = [], $stockProducts = [], $topProducts = [];

    public function render()
    {
        return view('livewire.dashboard.component')
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function mount()
    {

        $byCategories = SaleDetail::join('products AS p', 'sale_details.product_id', 'p.id')
                                ->join('categories AS c', 'p.category_id', 'c.id')
                                ->select('c.name as name',DB::raw('SUM(sale_details.quantity) AS sales'))
                                ->groupBy(['c.id','c.name'])
                                ->orderByRaw('sales DESC')
                                ->limit(3)
                                ->get();

        foreach ($byCategories as $byCategory) {
            array_push($this->names, $byCategory->name);
        }

        foreach ($byCategories as $byCategory) {
            array_push($this->sales, $byCategory->sales);
        }

        $this->topProducts = Product::join('sale_details AS sd','products.id','sd.product_id')
                                ->select('products.name','sd.price','sd.discount',DB::raw('SUM(sd.quantity) AS sold'))
                                ->groupBy(['products.id','products.name','sd.price','sd.discount'])
                                ->orderByRaw('sold DESC')
                                ->limit(10)
                                ->get();

        //DB::enableQueryLog();
        
        $this->stockProducts = Product::select('products.name', 'products.stock', 'products.alert')
                                ->where('products.stock','=',0)
                                ->orWhere('products.stock','<=',DB::raw('products.alert'))
                                ->orderBy('products.stock', 'ASC')
                                ->get();

        //dd($this->stockProducts);
        //dd(DB::getQueryLog());
    }
}

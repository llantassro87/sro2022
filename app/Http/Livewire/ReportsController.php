<?php

namespace App\Http\Livewire;

use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class ReportsController extends Component
{

    public $componentName, $data, $details, $sumDetails, $countDetails,
    $reportType, $userId, $fromDate, $toDate, $saleId, $purchaseReport;

    public function mount()
    {
        $this->componentName = 'Reporte de ventas';
        $this->data = [];
        $this->details = [];
        $this->countDetails = 0;
        $this->sumDetails = 0;
        $this->reportType = 0;
        $this->purchaseReport = 0;
        $this->userId = 0;
        $this->saleId = 0;

    }

    public function render()
    {
        if ($this->purchaseReport == 0) {
            $this->SalesByDate();
        } else {
            $this->PurchasesByDate();
        }
        

        return view('livewire.reports.component', [
            'users' => User::orderBy('name', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function SalesByDate()
    {
        if ($this->reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';
        }

        if ($this->reportType == 1 && ($this->fromDate == '' || $this->toDate == '')) {
            $this->emit('report-error', 'Debe seleccionar las fechas');
        }

        if ($this->userId == 0) {
            $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.*', 'u.name as user')
            ->whereBetween('sales.created_at', [$from, $to])
            ->get();
        } else {
            $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.*', 'u.name as user')
            ->whereBetween('sales.created_at', [$from, $to])
            ->where('user_id', $this->userId)
            ->get();
        }
    }

    public function getDetails($saleId)
    {
        $this->details = SaleDetail::join('products as p', 'p.id', 'sale_details.product_id')
        ->select('sale_details.id', 'sale_details.price', 'sale_details.quantity', 'sale_details.discount', 'p.name as product')
        ->where('sale_details.sale_id', $saleId)
        ->get();

        $suma = $this->details->sum(function ($item) {
            if ($item->discount > 0) {
                $disc = ((100 - $item->discount) * $item->price) / 100;
                return $disc * $item->quantity;
            } else {
                return $item->price * $item->quantity;
            }
        });

        $this->sumDetails = $suma;
        $this->countDetails = $this->details->sum('quantity');
        $this->saleId = $saleId;

        $this->emit('show-modal' , 'show modal');
    }

    public function PurchasesByDate()
    {
        if ($this->reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';
        }

        if ($this->reportType == 1 && ($this->fromDate == '' || $this->toDate == '')) {
            $this->emit('report-error', 'Debe seleccionar las fechas');
        }

        if ($this->userId == 0) {
            $this->data = Purchase::join('suppliers as s', 's.id', 'purchases.supplier_id')
                ->join('products as p', 'p.id', 'purchases.product_id')
                ->join('users as u', 'u.id', 'purchases.user_id')
                ->select('purchases.quantity', 'purchases.total', 's.name as supplier', 'p.name as products', 'u.name as user', 'purchases.created_at as date')
                ->whereBetween('purchases.created_at', [$from, $to])
                ->get();
        } else {
            $this->data = Purchase::join('suppliers as s', 's.id', 'purchases.supplier_id')
                ->join('products as p', 'p.id', 'purchases.product_id')
                ->join('users as u', 'u.id', 'purchases.user_id')
                ->select('purchases.quantity', 'purchases.total', 's.name as supplier', 'p.name as products', 'u.name as user', 'purchases.created_at as date')
                ->whereBetween('purchases.created_at', [$from, $to])
                ->where('user_id', $this->userId)
                ->get();
        }
    }
}

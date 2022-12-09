<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class ReportsPurchasesController extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails,
    $reportType, $userId, $fromDate, $toDate, $saleId;

    public function mount()
    {
        $this->componentName = 'Reporte de compras';
        $this->data = [];
        $this->details = [];
        $this->countDetails = 0;
        $this->sumDetails = 0;
        $this->reportType = 0;
        $this->userId = 0;
        $this->saleId = 0;

    }

    public function render()
    {

        return view('livewire.reports.reports-purchases', [
            'users' => User::orderBy('name', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
}

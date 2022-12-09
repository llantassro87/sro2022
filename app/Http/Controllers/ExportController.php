<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Exports\PurchasesExport;
use App\Models\Company;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function reportPDF($userId, $reportType, $fromDate = null, $toDate = null)
    {
        $data = [];

        if ($reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($toDate)->format('Y-m-d') . ' 23:59:59';
        }

        if ($userId == 0) {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.*', 'u.name as user')
            ->whereBetween('sales.created_at', [$from, $to])
            ->get();
        } else {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.*', 'u.name as user')
            ->whereBetween('sales.created_at', [$from, $to])
            ->where('user_id', $userId)
            ->get();
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;

        $dateReportPDF = $fromDate == null && $toDate == null ? Carbon::parse(Carbon::now())->format('d-m-Y') : Carbon::parse($fromDate)->format('d-m-Y') . ' al ' . Carbon::parse($toDate)->format('d-m-Y');
        $reportNamePDF = 'Reporte de ventas_' . $dateReportPDF . '.pdf';

        $pdf = PDF::loadView('pdf.reporte', compact('data', 'reportType', 'user', 'fromDate', 'toDate'));

        return $pdf->stream($reportNamePDF);
        return $pdf->download($reportNamePDF);

    }

    public function reportExcel($userId, $reportType, $fromDate = null, $toDate = null)
    {
        $dateReportExcel = $fromDate == null && $toDate == null ? Carbon::parse(Carbon::now())->format('d-m-Y') : Carbon::parse($fromDate)->format('d-m-Y') . ' al ' . Carbon::parse($toDate)->format('d-m-Y');
        $reportNameExcel = 'Reporte de ventas_' . $dateReportExcel . '.xlsx';

        return Excel::download(new SalesExport($userId, $reportType, $fromDate, $toDate), $reportNameExcel);
    }

    public function reportPurchasePDF($userId, $reportType, $fromDate = null, $toDate = null)
    {
        $data = [];

        if ($reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($toDate)->format('Y-m-d') . ' 23:59:59';
        }

        if ($userId == 0) {
            $data = Purchase::join('suppliers as s', 's.id', 'purchases.supplier_id')
                ->join('products as p', 'p.id', 'purchases.product_id')
                ->join('users as u', 'u.id', 'purchases.user_id')
                ->select('purchases.quantity', 'purchases.total', 's.name as supplier', 'p.name as products', 'u.name as user', 'purchases.created_at as date')
                ->whereBetween('purchases.created_at', [$from, $to])
                ->get();
        } else {
            $data = Purchase::join('suppliers as s', 's.id', 'purchases.supplier_id')
                ->join('products as p', 'p.id', 'purchases.product_id')
                ->join('users as u', 'u.id', 'purchases.user_id')
                ->select('purchases.quantity', 'purchases.total', 's.name as supplier', 'p.name as products', 'u.name as user', 'purchases.created_at as date')
                ->whereBetween('purchases.created_at', [$from, $to])
                ->where('user_id', $userId)
                ->get();
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;

        $dateReportPDF = $fromDate == null && $toDate == null ? Carbon::parse(Carbon::now())->format('d-m-Y') : Carbon::parse($fromDate)->format('d-m-Y') . ' al ' . Carbon::parse($toDate)->format('d-m-Y');
        $reportNamePDF = 'Reporte de compras_' . $dateReportPDF . '.pdf';

        $pdf = PDF::loadView('pdf.reportec', compact('data', 'reportType', 'user', 'fromDate', 'toDate'));

        return $pdf->stream($reportNamePDF);
        return $pdf->download($reportNamePDF);

    }

    public function reportPurchaseExcel($userId, $reportType, $fromDate = null, $toDate = null)
    {
        $dateReportExcel = $fromDate == null && $toDate == null ? Carbon::parse(Carbon::now())->format('d-m-Y') : Carbon::parse($fromDate)->format('d-m-Y') . ' al ' . Carbon::parse($toDate)->format('d-m-Y');
        $reportNameExcel = 'Reporte de compras_' . $dateReportExcel . '.xlsx';

        return Excel::download(new PurchasesExport($userId, $reportType, $fromDate, $toDate), $reportNameExcel);
    }

    public function FacturaPDF($saleID)
    {
        $sale = Sale::find($saleID);

        $user = User::find($sale->user_id);
        $products = Sale::join('sale_details as sd', 'sales.id', 'sd.sale_id')
            ->join('products as p', 'sd.product_id', 'p.id')
            ->select('sd.price', 'sd.quantity', 'sd.discount', 'p.name')
            ->where('sd.sale_id', $sale->id)
            ->get();

        $reportNamePDF = 'Factura Consumidor Final.pdf';

        $pdf = PDF::loadView('livewire.invoice.factura', compact('user', 'products', 'sale'))->setPaper("a5", 'portrait');

        return $pdf->stream($reportNamePDF);
        return $pdf->download($reportNamePDF);
    }

    public function creditoPDF($saleID)
    {
        $sale = Sale::find($saleID);

        $user = User::find($sale->user_id);
        $products = Sale::join('sale_details as sd', 'sales.id', 'sd.sale_id')
            ->join('products as p', 'sd.product_id', 'p.id')
            ->select('sd.price', 'sd.quantity', 'sd.discount', 'p.name')
            ->where('sd.sale_id', $sale->id)
            ->get();

        $reportNamePDF = 'Factura Credito Fiscal.pdf';

        $pdf = PDF::loadView('livewire.invoice.credito', compact('user', 'products', 'sale'))->setPaper("a5", 'portrait');

        return $pdf->stream($reportNamePDF);
        return $pdf->download($reportNamePDF);
    }
}

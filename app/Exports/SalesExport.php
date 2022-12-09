<?php

namespace App\Exports;

use App\Models\Sale;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles, WithColumnWidths, WithColumnFormatting, WithMapping, ShouldAutoSize
{
    
    protected $userId, $reportType, $fromDate, $toDate;

    public function __construct($userId, $reportType, $f1, $f2) {

        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->fromDate = $f1;
        $this->toDate = $f2;

    }

    public function collection()
    {
        $data = [];

        if ($this->reportType == 1) {
            $from = Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        }

        if ($this->userId == 0) {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'u.name as user', 'sales.created_at')
            ->whereBetween('sales.created_at', [$from, $to])
            ->get();
        } else {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'u.name as user', 'sales.created_at')
            ->whereBetween('sales.created_at', [$from, $to])
            ->where('user_id', $this->userId)
            ->get();
        }

        return $data;
    }

    public function headings() : array
    {
        return ["FOLIO", "IMPORTE", "ITEMS", "ESTADO", "USUARIO", "FECHA"];
    }

    public function startCell() : string
    {
        return 'A2';
    }

    public function styles(Worksheet $worksheet)
    {
        $worksheet->getStyle('2')->getFont()->setBold(true);
        $worksheet->getStyle('A:F')->getAlignment()->setHorizontal('center');
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->total,
            $data->items,
            $data->status,
            $data->user,
            Date::dateTimeToExcel($data->created_at)
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 7,
            'C' => 7,            
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'F' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }

    public function title() : string
    {
        return 'Reporte de ventas';
    }
}

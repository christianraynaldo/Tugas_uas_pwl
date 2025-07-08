<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrderExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    // Mapping setiap baris data (supaya lebih rapi dan bisa format tanggal/uang)
    public function map($order): array
    {
        return [
            $order->kode_order,
            $order->konsumen->nama,
            \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y'),
            ucfirst($order->status),
            $order->ekspedisi,
            'Rp ' . number_format($order->total + $order->ongkir, 0, ',', '.'),
        ];
    }

    // Judul kolom (header)
    public function headings(): array
    {
        return [
            'Kode Order',
            'Konsumen',
            'Tanggal',
            'Status',
            'Ekspedisi',
            'Total + Ongkir',
        ];
    }

    // Styling kolom (header bold & background abu)
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [ // baris ke-1 (header)
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFEFEFEF']
                ],
                'alignment' => ['horizontal' => 'center']
            ]
        ];
    }
}

<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class DailyOrdersExport implements
    FromCollection,
    WithMapping,
    ShouldAutoSize,
    WithHeadings,
    WithColumnFormatting,
    WithDrawings,
    WithCustomStartCell
{
    private $date;

    /**
     * @param string $date
     */
    public function __construct(string $date)
    {
        $this->date = $date;
    }

    /**
     * Defines the start cell for the collection
     *
     * @return string
     */
    public function startCell(): string
    {
        return 'A6';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        /** @var Collection */
        return Order::with(['items.dish', 'table'])
            ->where('paid_at', '<>', null)
            ->whereDate('created_at', $this->date)
            ->get();
    }

    /**
     * @var Order $invoice
     */
    public function map($order): array
    {
        return [
            'time' => $order->created_at->format('H:s'),
            'paidAt' => $order->paid_at->format('H:s'),
            'table' => $order->table->name,
            'total' => $order->items->sum('dish.price')
        ];
    }

    /**
     * Header
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tijd',
            'Betaald op',
            'Tafel',
            'Totaal'
        ];
    }

    /**
     * Formats the columns
     *
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }

    /**
     * Drawing a logo to the doc
     *
     * @return void
     */
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(\base_path('resources/frontend/app/src/assets/images/goodpay.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('A1');

        return $drawing;
    }
}

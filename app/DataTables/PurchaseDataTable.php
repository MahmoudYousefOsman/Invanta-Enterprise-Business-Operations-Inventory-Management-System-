<?php

namespace App\DataTables;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;


class PurchaseDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Purchase> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('supplier', function ($purchase) {
                return $purchase->supplier?->name ?? 'غير محدد';
            })
            ->addColumn('invoice_type', function ($purchase) {
                return match ($purchase->invoice_type) {
                    'paid' => 'مدفوع',
                    'unpaid' => 'آجل',
                    'partial' => 'مدفوع جزئياً',
                    default => 'غير محدد',
                };
            })
            ->addColumn('actions', function ($purchase) {
                return view('admin.purchases.partials.actions', compact('purchase'))->render();
            })
            ->rawColumns(['actions'])
            ->setRowId('id');
    }


    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Purchase>
     */
    public function query(Purchase $model): QueryBuilder
    {
        return $model->newQuery()->with('supplier');
    }


    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('purchase-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('#'),
            Column::make('code')->title('كود الطلب'),
            Column::make('invoice_type')->title('نوع فاتورة المشتريات'),

            Column::make('date')->title('التاريخ'),
            Column::make('supplier')->title('المورد'),
            column::make('total_price')->title('الاجمالي'),
            Column::computed('actions')
                ->title('التحكم')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Purchase_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\InvoiceReturn;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReturnInvoiceDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<InvoiceReturn> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('type_id', function ($query) {
                if ($query->type == 'client') {
                    return $query->client->name;
                } else {
                    return $query->supplier->name;
                }
            })
            ->addColumn('actions', function ($returnInvoice) {
                return view('admin.invoice_return.partials.actions', [
                    'return_invoice' => $returnInvoice
                ]);
            })
            ->rawColumns(['actions'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<InvoiceReturn>
     */
    public function query(InvoiceReturn $model): QueryBuilder
    {
        return $model->with('client','supplier')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('returninvoice-table')
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
            Column::make('type')->title('نوع المرتجع'),
            Column::make('type_id')->title('العميل/المورد'),
            Column::make('total_price')->title('إجمالي السعر'),
            Column::make('created_at')->title('تاريخ الإنشاء'),
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
        return 'ReturnInvoice_' . date('YmdHis');
    }
}

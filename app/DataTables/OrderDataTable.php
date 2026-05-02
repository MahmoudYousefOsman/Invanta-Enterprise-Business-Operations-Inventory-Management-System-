<?php

    namespace App\DataTables;

    use App\Models\Order;
    use Yajra\DataTables\EloquentDataTable;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class OrderDataTable extends DataTable
    {
        /**
         * Build DataTable class.
         */
        public function dataTable($query)
        {
            return (new EloquentDataTable($query))
                ->addIndexColumn()
                ->addColumn('client', function ($order) {
                    return $order->client->name ?? '-';
                })
                ->addColumn('actions', function ($order) {
                    return view('admin.orders.partials.actions', compact('order'))->render();
                })
                ->rawColumns(['actions'])
                ->setRowId('id');
        }

        /**
         * Get query source of dataTable.
         */
        public function query(Order $model)
        {
            return $model->newQuery()->with('client');
        }

        /**
         * Optional method if you want to use HTML builder.
         */
        public function html()
        {
            return $this->builder()
                ->setTableId('orders-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->dom(
                    "<'row mb-2'<'col-md-9'B><'col-md-3'f>>"."tr"."ip"
                )
                ->orderBy(0)
                ->buttons([
                    'excel',
                    'print',
                ]);
        }

        /**
         * Get columns.
         */
        protected function getColumns()
        {
            return [
                Column::make('id')->title('#'),
                Column::make('code')->title('كود الطلب'),
                Column::make('client')->title('العميل'),
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
         * Get filename for export.
         */
        protected function filename(): string
        {
            return 'Orders_' . date('YmdHis');
        }
    }

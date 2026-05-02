<?php

    namespace App\DataTables;

    use App\Models\Client;
    use Illuminate\Database\Eloquent\Builder as QueryBuilder;
    use Yajra\DataTables\EloquentDataTable;
    use Yajra\DataTables\Html\Builder as HtmlBuilder;
    use Yajra\DataTables\Html\Button;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class ClientDataTable extends DataTable
    {
        public function dataTable(QueryBuilder $query): EloquentDataTable
        {
            return (new EloquentDataTable($query))
                ->addIndexColumn()
                ->editColumn('type', function ($client) {
                    if ($client->type === 'repair') {
                        return '<span class="badge bg-warning-lt">صيانة</span>';
                    }
                    return '<span class="badge bg-primary-lt">شراء</span>';
                })
                ->editColumn('new_client', function ($client) {
                    if ($client->new_client) {
                        return '<span class="badge bg-success-lt">عميل جديد</span>';
                    }
                    return '<span class="badge bg-primary-lt">عميل سابق</span>';
                })
                ->addColumn('actions', 'admin.client.partials.actions')
                ->rawColumns(['actions','type','new_client'])
                ->setRowId('id');
        }

        public function query(Client $model): QueryBuilder
        {
            return $model->newQuery();
        }

        public function html(): HtmlBuilder
        {
            return $this->builder()
                ->setTableId('client-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
//                ->dom('Bfrtip')
                ->orderBy(0);
//                ->selectStyleSingle()
//                ->buttons([
//                    Button::make('excel'),
//                    Button::make('csv'),
//                    Button::make('pdf'),
//                    Button::make('print'),
//                    Button::make('reset'),
//                    Button::make('reload'),
//                ]);
        }

        public function getColumns(): array
        {
            return [
                Column::make('id')->title('#')->addClass('text-center'),
                Column::make('name')->title('الاسم')->addClass('text-center'),
                Column::make('phone')->title('رقم الهاتف')->addClass('text-center'),
                Column::make('address')->title('العنوان')->addClass('text-center'),
                Column::make('type')->title('النوع')->addClass('text-center'),
                Column::make('new_client')->title('عميل جديد؟')->addClass('text-center'),
                Column::computed('actions')
                    ->title('الإجراءات')
                    ->exportable(false)
                    ->printable(false)
                    ->width(200)
                    ->addClass('text-center'),
            ];
        }

        protected function filename(): string
        {
            return 'Client_' . date('YmdHis');
        }
    }

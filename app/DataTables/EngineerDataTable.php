<?php

    namespace App\DataTables;

    use App\Models\Engineer;
    use Illuminate\Database\Eloquent\Builder as QueryBuilder;
    use Yajra\DataTables\EloquentDataTable;
    use Yajra\DataTables\Html\Builder as HtmlBuilder;
    use Yajra\DataTables\Html\Button;
    use Yajra\DataTables\Html\Column;
    use Yajra\DataTables\Services\DataTable;

    class EngineerDataTable extends DataTable
    {
        /**
         * Build DataTable class.
         */
        public function dataTable(QueryBuilder $query): EloquentDataTable
        {
            return (new EloquentDataTable($query))
                ->addIndexColumn()
                ->addColumn('actions', 'admin.engineers.partials.actions')
                ->rawColumns(['actions'])
                ->setRowId('id');
        }

        /**
         * Get query source.
         */
        public function query(Engineer $model): QueryBuilder
        {
            return $model->newQuery();
        }

        /**
         * HTML builder.
         */
        public function html(): HtmlBuilder
        {
            return $this->builder()
                ->setTableId('engineer-table')
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
                    Button::make('reload'),
                ]);
        }

        /**
         * Get columns.
         */
        public function getColumns(): array
        {
            return [
                Column::make('id')->title('#')->addClass('text-center'),
                Column::make('name')->title('الاسم')->addClass('text-center'),
                Column::make('phone')->title('رقم الهاتف')->addClass('text-center'),
                Column::make('address')->title('العنوان')->addClass('text-center'),
                Column::make('current_balance')->title('الرصيد الحالي')->addClass('text-center'),
                Column::make('salary')->title('الرتب')->addClass('text-center'),
                Column::make('notes')->title('ملاحظات')->addClass('text-center'),

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
            return 'Engineer_' . date('YmdHis');
        }
    }

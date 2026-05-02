<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Product> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('type', function ($row) {
                return $row->type == 'phone' ? 'بيع' : 'صيانة';
            })
            ->addColumn('category_id', function ($query) {
                return $query->category ? $query->category->name : '-';

            })
            ->addColumn('photo', 'admin.products.partials.images')
            ->addColumn('action', 'admin.products.partials.actions')
            ->rawColumns(['photo', 'action'])
            ->setRowId('id');
    }


    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Product>
     */
    public function query(Product $model): QueryBuilder
    {
        // قراءة نوع المنتج من الـ URL
        $type = request()->segment(3); // = iphone أو fix

        // تحويل iphone → phone   (لو الاسم مختلف في DB)
        if ($type === 'iphone') {
            $type = 'phone';
        }
        if ($type === 'maintenance') {
            $type = 'fix';
        }

        // لو النوع موجود في الـ URL اعمل فلترة
        if (in_array($type, ['phone', 'fix'])) {
            return $model->newQuery()->where('type', $type);
        }

        // لو مفيش، هنعرض كل المنتجات
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
//            ->selectStyleSingle()
            ->selectStyleMulti() // <-- enable multi-row select
//            ->dom('Bfrtip') //
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
                Button::make('printBarcode')

            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('select')
                ->exportable(false)
                ->printable(false)
                ->width(20)
                ->addClass('text-center')
                ->title('<input type="checkbox" id="select-all">')
                ->render("function() { return '<input type=\"checkbox\" class=\"row-select\">'; }"),

            Column::make('id'),
            Column::make('name')->title('اسم المنتج'),
            Column::make('category_id')->title('القسم'),
            Column::make('type')->title('نوع المنتج'),
            Column::make('code')->title('الكود'),
            Column::make('description')->title('الوصف'),
            Column::make('purchase_price')->title('سعر الشراء'),
            Column::make('sale_price')->title('سعر البيع'),
            Column::make('quantity')->title('الكمية'),
            Column::make('photo')->title('الصورة'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}

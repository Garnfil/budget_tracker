<?php

namespace App\DataTables;

use App\Models\IncomeCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IncomeCategoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('budget_id', function ($row) {
                return $row->budget->user->name ?? null;
            })
            ->addColumn('action', function ($row) {
                return '<a href="' .route('income-categories.edit', $row->id). '" class="btn btn-sm btn-primary"><i class="feather icon-edit"></i></a>
                        <button data-id="' .$row->id. '" class="btn btn-sm btn-danger"><i class="feather icon-trash"></i></button>';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(IncomeCategory $model): QueryBuilder
    {
        return $model->with('budget', 'budget.user');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('income-category-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->responsive()
                    ->serverSide(true)
                    ->searching(false)
                    ->ordering(false)
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
            Column::make('id'),
            Column::make('budget_id')->data('budget_id')->name('budget_id')->title('Client Budget'),
            Column::make('name'),
            Column::make('goal_amount'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(70)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'IncomeCategory_' . date('YmdHis');
    }
}

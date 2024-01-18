<?php

namespace App\DataTables;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BudgetDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTables = (new EloquentDataTable($query))
            ->addColumn('action', 'budget.action')->addColumn('action', function ($row) {
                return '<a href="' .route('budgets.edit', $row->id). '" class="btn btn-sm btn-primary"><i class="feather icon-edit"></i></a>
                        <button data-id="' .$row->id. '" class="btn btn-sm btn-danger"><i class="feather icon-trash"></i></button>';
            })
            ->editColumn('user_id', function ($row) {
                return optional($row->user)->name ?? optional($row->user)->email;
            })
            ->editColumn('initial_balance', function($row) {
                return '₱' . ' ' . number_format($row->initial_balance, 2);
            })
            ->editColumn('net_disposable_income', function($row) {
                return '₱' . ' ' . number_format($row->net_disposable_income, 2);
            })
            ->editColumn('date_duration', function ($row) {
                $output = '';
                if($row->start_date) {
                    $output .= $row->start_date->format('M d, Y');
                }

                $output .= ' - ';

                if($row->end_date) {
                    $output .= $row->end_date->format('M d, Y');
                }
                
                return $output;
            })
            ->setRowId('id');

        $dataTables->rawColumns(['action']);

        return $dataTables;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Budget $model): QueryBuilder
    {
        return $model->with('user');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('budget-table')
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
            Column::make('client')->data('user_id')->name('user_id')->title('Client'),
            Column::make('initial_balance'),
            Column::make('net_disposable_income'),
            Column::make('date_duration')->date('date_duration')->name('date_duration')->title('Date Duration'),
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
        return 'Budget_' . date('YmdHis');
    }
}

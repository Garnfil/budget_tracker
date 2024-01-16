<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use App\Models\ClientDetail;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTables = (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<a href="#" class="btn btn-md btn-primary"><i class="feather icon-edit"></i></a>';
            })
            ->editColumn('user_id', function ($row) {
                return optional($row->user)->email;
            })
            ->editColumn('email_verified_at', function ($row) {
                return $row->user->email_verified_at ? $row->user->email_verified_at->format('F d, Y') : 'Not Verified';
            })
            ->editColumn('created_at', function ($row) {
                return $row->user->created_at->format('F d, Y');
            })
            ->setRowId('id');

        $dataTables->rawColumns(['action']);

        return $dataTables;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ClientDetail $model): QueryBuilder
    {
        $model = $model->with('user');

        if (request('searchText') != '') {
            $model->whereHas('user', function ($q) {
                $q->where('email', 'like', '%' . request('searchText') . '%');
            });
        }

        return $model;
    }





    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('client-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->destroy(true)
            ->responsive()
            ->stateSave(false)
            ->orderBy(0)
            ->serverSide()
            ->processing()
            ->searching(false)
            ->lengthChange(false)
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
            Column::make('email_verified_at'),
            Column::make('created_at'),
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
        return 'Client_' . date('YmdHis');
    }
}

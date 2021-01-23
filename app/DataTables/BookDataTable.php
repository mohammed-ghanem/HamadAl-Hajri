<?php

namespace App\DataTables;

// use App\DataTables\UserDataTable;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BookDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('checkbox', 'admin.books.btn.checkbox')
            ->addColumn('edit', 'admin.books.btn.edit')
            ->addColumn('delete', 'admin.books.btn.delete')
            ->addColumn('status',  function (Book $book) {

        return $book->status == 1 ? trans('admin/books/create.text_published') : trans('admin/books/create.text_hidden') ;

            })
            ->addColumn('category_id', function (Book $book) {

                return $book->category->name;

            })
            ->addColumn('image',  function (Book $book) {
                
                $url= asset('/files/books/images/'.$book->image);
                return !empty($book->image) ? '<img src="'.$url.'" style="width:50px;height: 50px;" />' : '' ;
        
                    })
                   
                    
			->rawColumns([
                'checkbox',
                'edit',
                'delete',
                'category_id',
                'status',
                'image',
                
               
			]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\UserDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Book::query()->with('category');

    }

   

    

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->setTableId('roledatatable-table')
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->parameters(
                    [
                        // 'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 'All Record']],
                        'buttons'      => 
                     [
                        [ 'text'  => '<i class="fa fa-plus"></i> '.trans('admin/template/common.text_create_book'),'className'=>'addBtn',
                        "action"=>"function(){
                            window.location.href='".URL::current()."/create';
                        }"
                           
                       ],
                       
                    //     ['extend' =>'print' , 'text' => ' <i class="fa fa-print"></i> ' . trans('admin/template/common.text_print')],
                    //     ['extend' =>'excel' , 'text' => '<i class="fa fa-file"></i> '.trans('admin/template/common.text_ex_excel')],
                    //     ['extend' =>'csv' , 'text' => '<i class="fa fa-file"></i> '.trans('admin/template/common.text_ex_csv')],
                    //    // ['extend' =>'pdf' , 'text' => '<i class="fa fa-file"></i> '.trans('admin/template/common.text_ex_pdf')],
                    //     ['extend' => 'reload', 'text' => '<i class="fa fa-refresh"></i>'.trans('admin/template/common.text_reload')],
                        [ 'text'  => '<i class="fa fa-trash"></i> '.trans('admin/template/common.text_delete_all'), 'className'=>'delBtn'],
                    ],
                   


                    'initComplete' => "function () {
                        this.api().columns([]).every(function () {
                            var column = this;
                            var input = document.createElement(\"input\");
                            $(input).appendTo($(column.footer()).empty())
                            .on('keyup', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                        });
                    }",
                    'language'         => datatable_lang(),
    
                    ]);
                    
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [ [
				'name'  => 'checkbox',
				'data'  => 'checkbox',
                'title' => '<input type="checkbox" class="check_all" onclick="check_all()" />',
                'exportable' => false,
				'printable'  => false,
				'orderable'  => false,
				'searchable' => false,
			],[
				'name'  => 'id',
				'data'  => 'id',
				'title' => 'ID',
            ], 
            [
				'name'  => 'name',
				'data'  => 'name',
				'title' => trans('admin/template/common.text_name'),
            ], 
            [
				'name'  => 'category_id',
				'data'  => 'category_id',
				'title' => trans('admin/template/common.text_category_id'),
            ], 
            [
                	'name'  => 'publish_date',
                	'data'  => 'publish_date',
                	'title' => trans('admin/template/common.text_publish_date'),
            ], 
            [
                'name'  => 'status',
                'data'  => 'status',
                'title' => trans('admin/template/common.text_status'),
            ], 
            [
                'name'  => 'image',
                'data'  => 'image',
                'title' => trans('admin/template/common.text_image'),
            ], 
       
            [
				'name'       => 'edit',
				'data'       => 'edit',
				'title'      => trans('admin/template/common.text_edit'),
				'exportable' => false,
				'printable'  => false,
				'orderable'  => false,
				'searchable' => false,
            ],
            
             [
				'name'       => 'delete',
				'data'       => 'delete',
				'title'      => trans('admin/template/common.text_delete'),
				'exportable' => false,
				'printable'  => false,
				'orderable'  => false,
                'searchable' => false,
            ],
            
             

		];
            
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ِBook_' . date('YmdHis');
    }

    
}
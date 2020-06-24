<?php

namespace Rohitpavaskar\ColumnSelection\Http\Controllers;

use \Illuminate\Support\Facades\DB;
use Rohitpavaskar\ColumnSelection\Models\DefaultColumns;
use Rohitpavaskar\ColumnSelection\Models\ColumnSelection;

class DefaultColumnsController {

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($column_name) {
        DefaultColumns::where('append_additional', '1')->update(
                ['default_hidden_columns' => DB::raw("CONCAT_WS(',',default_hidden_columns, CONCAT(prefix, '" . $column_name . "'))")]
        );
        $defaultColumns = DefaultColumns::where('append_additional', '1')->get();
        foreach ($defaultColumns as $col) {
            ColumnSelection::where('table_name', $col->table_name)->update(
                    ['columns' => DB::raw("CONCAT_WS(',',columns,  '" . $col->prefix . $column_name . "')")]
            );
        }

        return response(
                array(
            "message" => __('crud.updated_msg', array('entity' => trans('common.column'))),
            "status" => true,
                ), 200);
    }

}

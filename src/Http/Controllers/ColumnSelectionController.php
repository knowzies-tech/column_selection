<?php

namespace Rohitpavaskar\ColumnSelection\Http\Controllers;

use Rohitpavaskar\ColumnSelection\Models\DefaultColumns;
use Rohitpavaskar\ColumnSelection\Models\ColumnSelection;
use Rohitpavaskar\ColumnSelection\Http\Requests\UpdateColumnSelectionRequest;

class ColumnSelectionController {

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $column = ColumnSelection::where('table_name', $id)
                ->where('user_id', auth()->user()->id)
                ->first();
        if ($column) {
            return explode(',', $column->columns);
        } else {
            $column = DefaultColumns::where('table_name', $id)->first();
            if ($column) {
                return explode(',', $column->default_hidden_columns);
            } else {
                return array();
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateColumnSelectionRequest $request, $id) {
        ColumnSelection::updateOrCreate(
                ['table_name' => $id, 'user_id' => auth()->user()->id], ['columns' => implode(',', $request->columns)]
        );
        return response(
                array(
            "message" => __('crud.updated_msg', array('entity' => trans('common.column'))),
            "status" => true,
                ), 200);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteTranslationRequest $request, $id) {
        $columns = ColumnSelection::where('table_name', $id)
                ->where('user_id', auth()->user()->id)
                ->first();
        $columns->delete();

        return response(
                array(
            "message" => __('crud.deleted_msg', array('entity' => trans('common.columns'))),
            "status" => true,
                ), 200);
    }

}

<?php

namespace Rohitpavaskar\ColumnSelection\Http\Controllers;

use Rohitpavaskar\ColumnSelection\Models\DefaultColumns;
use Rohitpavaskar\ColumnSelection\Models\ColumnSelection;
use Rohitpavaskar\ColumnSelection\Http\Requests\UpdateColumnSelectionRequest;

class ColumnSelectionController
{
    // Add these properties
    protected $connection = null;
    protected $userId = null;

    // Add onConnection() method
    public function onConnection(string $connection): self
    {
        $this->connection = $connection;
        return $this;
    }

    // Add forUser() method
    public function forUser(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }
    // Reset after use
    private function reset(): void
    {
        $this->connection = null;
        $this->userId = null;
    }

    // Get user id — from forUser() or auth()
    private function getUserId()
    {
        return $this->userId ?? auth()->user()->id;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id) {
    //     $column = ColumnSelection::where('table_name', $id)
    //             ->where('user_id', auth()->user()->id)
    //             ->first();
    //     if ($column) {
    //         return explode(',', $column->columns);
    //     } else {
    //         $column = DefaultColumns::where('table_name', $id)->first();
    //         if ($column) {
    //             return explode(',', $column->default_hidden_columns);
    //         } else {
    //             return array();
    //         }
    //     }
    // }

    public function show($id)
    {
        $columnModel = new ColumnSelection();
        if ($this->connection) {
            $columnModel->setConnection($this->connection);
        }

        $column = $columnModel
            ->where('table_name', $id)
            ->where('user_id', $this->getUserId())
            ->first();

        if ($column) {
            $this->reset();
            return explode(',', $column->columns);
        }

        $defaultModel = new DefaultColumns();
        if ($this->connection) {
            $defaultModel->setConnection($this->connection);
        }

        $column = $defaultModel
            ->where('table_name', $id)
            ->first();

        $this->reset();

        if ($column) {
            return explode(',', $column->default_hidden_columns);
        }

        return array();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(UpdateColumnSelectionRequest $request, $id) {
    //     ColumnSelection::updateOrCreate(
    //             ['table_name' => $id, 'user_id' => auth()->user()->id], ['columns' => implode(',', $request->columns)]
    //     );
    //     return response(
    //             array(
    //         "message" => __('crud.updated_msg', array('entity' => trans('common.column'))),
    //         "status" => true,
    //             ), 200);
    // }

    public function update(UpdateColumnSelectionRequest $request, $id)
    {
        $columnModel = new ColumnSelection();
        if ($this->connection) {
            $columnModel->setConnection($this->connection);
        }

        $columnModel->updateOrCreate(
            ['table_name' => $id, 'user_id' => $this->getUserId()],
            ['columns' => implode(',', $request->columns)]
        );

        $this->reset();

        return response(
            array(
                "message" => __('crud.updated_msg', array('entity' => trans('common.column'))),
                "status" => true,
            ),
            200
        );
    }


    /**
     * Remove the specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(DeleteTranslationRequest $request, $id) {
    //     $columns = ColumnSelection::where('table_name', $id)
    //             ->where('user_id', auth()->user()->id)
    //             ->first();
    //     $columns->delete();

    //     return response(
    //             array(
    //         "message" => __('crud.deleted_msg', array('entity' => trans('common.columns'))),
    //         "status" => true,
    //             ), 200);
    // }

    public function destroy(DeleteTranslationRequest $request, $id)
    {
        $columnModel = new ColumnSelection();
        if ($this->connection) {
            $columnModel->setConnection($this->connection);
        }

        $columns = $columnModel
            ->where('table_name', $id)
            ->where('user_id', $this->getUserId())
            ->first();

        $this->reset();

        $columns->delete();

        return response(
            array(
                "message" => __('crud.deleted_msg', array('entity' => trans('common.columns'))),
                "status" => true,
            ),
            200
        );
    }
}
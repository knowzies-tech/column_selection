<?php

namespace Rohitpavaskar\ColumnSelection;

use Illuminate\Support\Facades\Route;

class ColumnSelection {

    /**
     * Binds the Column selection routes into the controller.
     *
     * @param  callable|null  $callback
     * @param  array  $options
     * @return void
     */
    public static function routes() {
        Route::resource('/column-selections', '\Rohitpavaskar\ColumnSelection\Http\Controllers\ColumnSelectionController');
        Route::resource('/default-columns', '\Rohitpavaskar\ColumnSelection\Http\Controllers\DefaultColumnsController');
    }

}

<?php

namespace Rohitpavaskar\ColumnSelection;

use Illuminate\Support\ServiceProvider;

class ColumnSelectionServiceProvider extends ServiceProvider {

    /**
     * Publishes configuration file.
     *
     * @return  void
     */
    public function boot() {
        $this->publishes([
            __DIR__ . '/config/column_selection.php' => config_path('column_selection.php'),
                ], 'column_selection');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ]);
    }

    /**
     * Make config publishment optional by merging the config from the package.
     *
     * @return  void
     */
    public function register() {
        $this->mergeConfigFrom(
                __DIR__ . '/config/column_selection.php', 'column_selection'
        );
    }
}

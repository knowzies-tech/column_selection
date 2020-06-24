<?php

namespace Rohitpavaskar\ColumnSelection\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultColumns extends Model {

    protected $fillable = ['table_name', 'default_hidden_columns', 'prefix', 'append_additional'];

}

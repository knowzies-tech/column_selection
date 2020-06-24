<?php

namespace Rohitpavaskar\ColumnSelection\Models;

use Illuminate\Database\Eloquent\Model;

class ColumnSelection extends Model {

    protected $fillable = ['table_name', 'columns', 'user_id'];

}

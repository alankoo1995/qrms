<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class CodeModel extends Model
{
    protected $table = 'code_list';
    protected $primaryKey = 'id';
    public $timestamps = false;
}

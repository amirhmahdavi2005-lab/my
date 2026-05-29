<?php

namespace Modules\Categories\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryKeyword extends Model
{
    protected $table = 'categories__keywords';
    protected $guarded = [];
    public $timestamps = false;
}

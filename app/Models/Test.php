<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\InsertIgnoreOnDuplicate;

class Test extends Model
{
    use HasFactory;
    use InsertIgnoreOnDuplicate;

    protected $guarded = [];

}

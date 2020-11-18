<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemUser extends Pivot
{
    public $table = 'item_user';
}

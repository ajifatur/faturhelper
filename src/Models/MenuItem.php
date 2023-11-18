<?php

namespace Ajifatur\FaturHelper\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'route', 'routeparams', 'icon', 'visible_conditions', 'active_conditions', 'parent', 'num_order'
    ];

    /**
     * Get the menu parent.
     */
    public function menu_parent()
    {
        return $this->hasOne(MenuItem::class, 'id', 'parent');
    }
}

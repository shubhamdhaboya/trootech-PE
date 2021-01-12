<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
	protected $hidden = ['pivot'];

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 'parent_id'
    ];

	public function products()
	{
		return $this->belongsToMany(Product::class, 'product_categories');
	}

	public function children()
	{
		return $this->hasMany(self::class, 'parent_id');
	}

	public function parent()
	{
		return $this->belongsTo(self::class);
	}
}

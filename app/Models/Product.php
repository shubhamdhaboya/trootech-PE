<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 'price'
    ];

    public function categories()
    {
    	return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function addCategories(array $categoriesIds = [])
    {
        $categories = $this->categories->pluck('id')->toArray();
        $catIds = [];

        foreach ($categoriesIds as $categoriesId) {
            if (!in_array($categoriesId, $categories)) {
                $catIds[] = $categoriesId;
            }
        }

        if ($catIds) {
            $this->categories()->attach($catIds);
        }
    }

    public function removeCategories(array $categoriesIds = [])
    {
        $categories = $this->categories->pluck('id')->toArray();
        $catIds = [];

        foreach ($categoriesIds as $categoriesId) {
            if (in_array($categoriesId, $categories)) {
                $catIds[] = $categoriesId;
            }
        }

        if ($catIds) {
            $this->categories()->detach($catIds);
        }
    }
}

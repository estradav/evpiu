<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * Las publicaciones que pertenecen a la categoría.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_posts')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(5);
    }
}

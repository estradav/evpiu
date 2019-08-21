<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
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
     * Las publicaciones que pertenecen a la etiqueta.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(5);
    }
}

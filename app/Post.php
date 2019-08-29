<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    /**
     * El directorio donde se guardan las imágenes de
     * las publicaciones.
     *
     * @var string $directory
     */
    public $directory = 'images/posts/';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'body',
        'status',
        'posted_by',
        'image'
    ];

    /**
     * Obtiene el usuario que posee el artículo.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * Obtiene las categorías que posee el artículo.
     *
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_posts');
    }

    /**
     * Obtiene las etiquetas que posee el artículo.
     *
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    /**
     * Obtiene la ruta de la imagen.
     *
     * @param  $value
     * @return string
     */
    public function getImagePathAttribute($value)
    {
        return $this->directory . $value;
    }

    /**
     * Borra el archivo de imagen y el modelo.
     *
     * @return bool|null     *
     * @throws Exception
     */
    public function delete()
    {
        $this->deleteImage();
        return parent::delete();
    }

    /**
     * Borra el archivo de imagen de una publicación.
     *
     * @return bool
     */
    public function deleteImage()
    {
        if ((Storage::disk('public')->exists($this->image))) {
            return Storage::disk('public')->delete(($this->image));
        }
        return FALSE;
    }
}

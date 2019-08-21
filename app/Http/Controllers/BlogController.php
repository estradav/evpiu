<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;

class BlogController extends Controller
{
    /**
     * Muestra el blog principal con cinco publicaciones
     * por cada página ordenadas por fecha de creación
     * descendente.
     *
     * @return \Illuminate\Http\Request
     */
    public function index()
    {
        $posts = Post::where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(5);

        return view('blog.index', compact('posts'));
    }

    /**
     * @todo: Upgrade pagination, tags and
     * categories appearance.
     * Muestra la publicación especificada.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Request
     */
    public function post(Post $post)
    {
        return view('blog.post', compact('post'));
    }

    /**
     * @todo: Upgrade pagination appearance.
     * Muestra cinco publicaciones por cada página,
     * relacionadas con una categoría en específico y
     * ordenadas por fecha de creación descendente.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Request
     */
    public function category(Category $category)
    {
        $posts = $category->posts();

        return view('blog.index', compact('posts'));
    }

    /**
     * @todo: Upgrade pagination appearance.
     * Muestra cinco publicaciones por cada página,
     * relacionadas con una etiqueta en específico y
     * ordenadas por fecha de creación descendente.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Request
     */
    public function tag(Tag $tag)
    {
        $posts = $tag->posts();

        return view('blog.index', compact('posts'));
    }
}

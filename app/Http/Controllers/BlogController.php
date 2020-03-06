<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Muestra el blog principal con cinco publicaciones
     * por cada página ordenadas por fecha de creación
     * descendente.
     *
     * @return Factory|View
     */
    public function index()
    {
        $posts = Post::where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(5);

        return view('blog.index', compact('posts'));
    }

    /**
     * @param Post $post
     * @return Factory|View
     * @todo: Upgrade pagination, tags and
     * categories appearance.
     * Muestra la publicación especificada.
     *
     */
    public function post(Post $post)
    {
        return view('blog.post', compact('post'));
    }

    /**
     * @param Category $category
     * @return Factory|View
     * @todo: Upgrade pagination appearance.
     * Muestra cinco publicaciones por cada página,
     * relacionadas con una categoría en específico y
     * ordenadas por fecha de creación descendente.
     *
     */
    public function category(Category $category)
    {
        $posts = $category->posts();

        return view('blog.index', compact('posts'));
    }

    /**
     * @param Tag $tag
     * @return Factory|View
     * @todo: Upgrade pagination appearance.
     * Muestra cinco publicaciones por cada página,
     * relacionadas con una etiqueta en específico y
     * ordenadas por fecha de creación descendente.
     *
     */
    public function tag(Tag $tag)
    {
        $posts = $tag->posts();

        return view('blog.index', compact('posts'));
    }
}

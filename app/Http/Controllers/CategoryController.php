<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryFormRequest;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Protege los métodos del controlador por medio de permisos
     * y utilizando el middleware del paquete de roles y permisos.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:categories.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:categories.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:categories.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:categories.destroy', ['only' => ['destroy']]);
    }

    /**
     * Muestra un listado de las categorías existentes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('category.index', compact('categories'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * @todo: Make throw exceptions.
     * Almacena una nueva categoría en la base de datos.
     *
     * @param  \App\Http\Requests\CategoryFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryFormRequest $request)
    {
        $formData = $request->all();
        $category = Category::create($formData);

        return redirect()
            ->route('categories.index')
            ->with([
                'message'    => 'Categoría creada con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Muestra una categoría en específico.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Muestra el formulario para editar una categoría
     * en especifico.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * @todo: Make throw exceptions.
     * Actualiza la categoría especificada en la base de datos.
     *
     * @param  \App\Http\Requests\CategoryFormRequest  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryFormRequest $request, Category $category)
    {
        $formData = $request->all();
        $category->update($formData);

        return redirect()
            ->route('categories.index')
            ->with([
                'message'    => 'Categoría actualizada con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Retira la categoría especificada de la base de datos.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with([
                'message'    => 'Categoría eliminada con éxito.',
                'alert-type' => 'success',
            ]);
    }
}

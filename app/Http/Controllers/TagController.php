<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TagFormRequest;
use App\Tag;

class TagController extends Controller
{
    /**
     * Protege los métodos del controlador por medio de permisos
     * y utilizando el middleware del paquete de roles y permisos.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:tags.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:tags.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tags.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tags.destroy', ['only' => ['destroy']]);
    }

    /**
     * Muestra un listado de las etiquetas existentes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();

        return view('tag.index', compact('tags'));
    }

    /**
     * Muestra el formulario para crear una nueva etiqueta.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * @todo: Make throw exceptions.
     * Almacena una nueva etiqueta en la base de datos.
     *
     * @param  \App\Http\Requests\TagFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagFormRequest $request)
    {
        $formData = $request->all();
        $tag = Tag::create($formData);

        return redirect()
            ->route('tags.index')
            ->with([
                'message'    => 'Etiqueta creada con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Muestra una etiqueta en específico.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Muestra el formulario para editar una etiqueta
     * en específico.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('tag.edit', compact('tag'));
    }

    /**
     * @todo: Make throw exceptions.
     * Actualiza la etiqueta especificada en la base de datos.
     *
     * @param  \App\Http\Requests\TagFormRequest  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagFormRequest $request, Tag $tag)
    {
        $formData = $request->all();
        $tag->update($formData);

        return redirect()
            ->route('tags.index')
            ->with([
                'message'    => 'Etiqueta actualizada con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Retira la etiqueta especificada de la base de datos.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->with([
                'message'    => 'Etiqueta eliminada con éxito.',
                'alert-type' => 'success',
            ]);
    }
}

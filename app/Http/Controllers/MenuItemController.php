<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\MenuItem;

class MenuItemController extends Controller
{
    /**
     * Protege los métodos del controlador por medio de permisos
     * y utilizando el middleware del paquete de roles y permisos.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:menus.items.list', ['only' => ['builder']]);
        $this->middleware('permission:menus.items.create', ['only' => ['store']]);
        $this->middleware('permission:menus.items.edit', ['only' => ['update']]);
        $this->middleware('permission:menus.items.destroy', ['only' => ['destroy']]);
    }

    /**
     * Almacena un nuevo item en un menu específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = new Menu();
        $menuItem = new MenuItem();

        $data = $this->prepareParameters(
            $request->all()
        );

        unset($data['id'], $data['type']);
        $data['order'] = $menuItem->highestOrderMenuItem();

        $menuItem = MenuItem::create($data);

        return redirect()
            ->route('menus.builder', [$data['menu_id']])
            ->with([
                'message'    => 'Item creado con éxito.',
                'alert-type' => 'success',
            ]);
    }

    /**
     * Actualiza un item específico de un menu específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = $request->input('id');
        $data = $this->prepareParameters(
            $request->except(['id'])
        );

        $menuItem = MenuItem::findOrFail($id);

        $menuItem->update($data);

        return redirect()
            ->route('menus.builder', [$menuItem->menu_id])
            ->with([
                'message'    => 'Item actualizado con éxito.',
                'alert-type' => 'success',
            ]);
    }

    /**
     * Elimina un item específico del menu.
     *
     * @param  int  $menu
     * @param  int  $item_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu, $item_id)
    {
        $item = MenuItem::findOrFail($item_id);

        $item->destroy($item_id);

        return redirect()
            ->route('menus.builder', [$menu])
            ->with([
                'message'    => 'Item eliminado con éxito.',
                'alert-type' => 'success',
            ]);
    }

    /**
     * Muestra la estructura de un menu en específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function builder($id)
    {
        $menu = Menu::findOrFail($id);

        return view('menu.builder', compact('menu'));
    }

    protected function prepareParameters($parameters)
    {
        switch (array_get($parameters, 'type')) {
            case 'route':
                $parameters['url'] = null;
                break;
            default:
                $parameters['route'] = null;
                $parameters['parameters'] = '';
                break;
        }

        if (isset($parameters['type'])) {
            unset($parameters['type']);
        }

        return $parameters;
    }
}

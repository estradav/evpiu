<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\MenuItem;
use App\User;

class MenuController extends Controller
{
    /**
     * Protege los métodos del controlador por medio de permisos
     * y utilizando el middleware del paquete de roles y permisos.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:menus.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:menus.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:menus.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:menus.destroy', ['only' => ['destroy']]);
    }

    /**
     * Muestra todos los menus.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();

        return view('menu.index', [
            'menus' => $menus
        ]);
    }

    /**
     * Muestra el formulario para almacenar un nuevo menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Almacena un nuevo menu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required'
        ]);

        $menu = new Menu();
        $menu->name = $validData['name'];
        $menu->save();

        return redirect()
            ->route('menus.index')
            ->with([
                'message'    => 'Menu creado con éxito.',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Muestra el formulario para editar la información de un menu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        return view('menu.edit', [
            'menu' => $menu
        ]);
    }

    /**
     * Actualiza la información de un menu específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $validData = $request->validate([
            'name' => 'required'
        ]);

        $menu = Menu::findOrFail($id);
        $menu->name = $validData['name'];
        $menu->save();

        return redirect()
            ->route('menus.index')
            ->with([
                'message'    => 'Menu actualizado con éxito.',
                'alert-type' => 'success',
            ]);
    }

    /**
     * Elimina un menu específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->with([
                'message'    => 'Menu eliminado con éxito.',
                'alert-type' => 'success',
            ]);
    }

    public function sort_item(Request $request)
    {
        $menuItemOrder = json_decode($request->input('order'));

        $this->orderMenu($menuItemOrder, null);
    }

    private function orderMenu(array $menuItems, $parentId)
    {
        foreach ($menuItems as $index => $menuItem) {
            $item = MenuItem::findOrFail($menuItem->id);
            $item->order = $index + 1;
            $item->parent_id = $parentId;
            $item->save();

            if (isset($menuItem->children)) {
                $this->orderMenu($menuItem->children, $item->id);
            }
        }
    }
}

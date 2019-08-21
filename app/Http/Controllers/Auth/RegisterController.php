<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Spatie\Permission\Models\Role;
use App\Menu;
use App\MenuItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'min:4', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        $user = $this->setDefaultRole($user);
        $menu = $this->setDefaultMenuToNewUser($user);
        $menuItem = $this->setDefaultMenuItemsToNewUser($menu);

        return $user;
    }

    /**
     * Sets a default role for each new registered user.
     *
     * @param  \App\User  $user
     * @return \App\User
     */
    protected function setDefaultRole(User $user)
    {
        $role = Role::where('name', 'user')->firstOrFail();
        return $user->assignRole($role);
    }

    /**
     * Sets a default menu for each new registered user.
     *
     * @param  \App\User  $user
     * @return \App\Menu
     */
    protected function setDefaultMenuToNewUser(User $user)
    {
        $menu = new Menu();
        return $menu->createDefaultMenu($user->username);
    }

    /**
     * Sets a default menu item for each new registered user.
     *
     * @param  \App\Menu  $menu
     * @return \App\MenuItem
     */
    protected function setDefaultMenuItemsToNewUser(Menu $menu)
    {
        $menuItem = new MenuItem();
        return $menuItem->createDefaultMenuItem($menu->id);
    }
}

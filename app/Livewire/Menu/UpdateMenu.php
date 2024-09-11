<?php

namespace App\Livewire\Menu;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UpdateMenu extends Component
{
    /**
     * Define public property $roles
     * @var array|object
     */
    public $roles;

    /**
     * Define public property $menu
     */
    public $menu;

    /**
     * Define public property $parent_menus;
     * @var array|object|null
     */
    public $parent_menus = null;

    public $name      = '';
    public $parent_id = null;
    public $route     = '';
    public $url       = '';
    public $icon      = '';
    public $role;
    public $status    = '';

    /**
     * Define public function mount()
     */
    public function mount(): void
    {
        $this->name = $this->menu->name;
        $this->parent_id = $this->menu->parent_id;
        $this->route = $this->menu->route;
        $this->url = $this->menu->url;
        $this->icon = $this->menu->icon;
        $this->role = $this->menu->role;
        $this->status = $this->menu->status;
    }
    /**
     * Define public method update()
     * @return void
     */
    public function update()
    {
        dd($this);
        array_push($this->role, 'super-admin');
        $this->menu->update([
            "name"      => $this->name,
            "slug"      => Str::slug($this->name),
            "user_id"   => Auth::id(),
            "parent_id" => $this->parent_id ?? null,
            "route"     => $this->route,
            "url"       => $this->url,
            "icon"      => $this->icon,
            "roles"     => json_encode($this->role),
            "status"    => $this->status,
        ]);
        flash()->success('Menu Updated!');
        return back();
    }

    public function render()
    {
        return view('livewire.menu.update-menu');
    }
}

<?php

namespace App\Livewire\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateMenu extends Component {

    public $roles;
    public $parent_menus = null;

    // #[Validate]
    public $name      = '';
    public $parent_id = null;
    public $route     = '';
    public $url       = '';
    public $icon      = '';
    public $role      = [];
    public $status    = 'active';

    public function rules() {
        return [
            'name' => 'required|min:4',
        ];
    }

    public function saveMenu() {
        // $this->validate();
        array_push($this->role, 'super-admin');
        Menu::create([
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
        flash()->success('Menu Created!');
        return redirect()->to('/dashboard/menu/create');
    }

    public function render() {
        return view('livewire.menu.create-menu');
    }
}

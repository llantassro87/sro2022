<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosController extends Component
{
    use WithPagination;

    public $permissionName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            sleep(1);
            $permisos = Permission::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $permisos = Permission::orderBy('name', 'asc')->paginate($this->pagination);
        }

        return view('livewire.permisos.component',[
                'permisos' => $permisos
            ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function CreatePermission()
    {
        $rules = [
            'permissionName' => 'required|min:2|unique:permissions,name'
        ];

        $message = [
            'permissionName.required' => 'Debe escribir un nombre para el permiso.',
            'permissionName.min' => 'El nombre permiso debe tener más de 2 caracteres.',
            'permissionName.unique' => 'Nombre del permiso ya existe.'
        ];

        $this->validate($rules, $message);

        Permission::create(['name' => $this->permissionName]);


        $this->emit('permiso-added', 'Se registró el permiso');
        $this->ResetUI();
    }

    public function Edit(Permission $permiso)
    {

        $this->selected_id = $permiso->id;
        $this->permissionName = $permiso->name;

        $this->emit('show-modal', 'show modal');
    }

    public function UpdatePermission()
    {
        $rules = [
            'permissionName' => "required|min:2|unique:permissions,name, {$this->selected_id}"
        ];

        $message = [
            'permissionName.required' => 'Debe escribir un nombre para el permiso.',
            'permissionName.min' => 'El nombre permiso debe tener más de 2 caracteres.',
            'permissionName.unique' => 'Nombre del permiso ya existe.'
        ];

        $this->validate($rules, $message);

        $permiso = Permission::find($this->selected_id);
        $permiso->name = $this->permissionName;
        $permiso->save();

        $this->emit('permiso-updated', 'Se actualizo el rol');
        $this->ResetUI();
    }

    protected $listeners = ['deleteRecord' => 'Destroy'];

    public function Destroy($id)
    {
        $rolesCount = Permission::find($id)->getRoleNames()->count();

        if ($rolesCount > 0) {
            $this->emit('permiso-error', 'No se puede eliminar el permiso, porque tiene permisos asociados');
            return;
        }

        Permission::find()->delete();
        $this->emit('permiso-deleted', 'Se eliminó el permiso');
    }

    public function ResetUI()
    {
        $this->resetValidation();
        $this->permissionName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetPage();
    }
}
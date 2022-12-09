<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Component
{
    use WithPagination;

    public $roleName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            sleep(1);
            $roles = Role::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $roles = Role::orderBy('name', 'asc')->paginate($this->pagination);
        }

        return view('livewire.roles.component',[
                'roles' => $roles
            ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function CreateRole()
    {
        $rules = [
            'roleName' => 'required|min:2|unique:roles,name'
        ];

        $message = [
            'roleName.required' => 'Debe escribir un nombre para el rol.',
            'roleName.min' => 'El nombre rol debe tener más de 2 caracteres.',
            'roleName.unique' => 'Nombre del rol ya existe.'
        ];

        $this->validate($rules, $message);

        Role::create(['name' => $this->roleName]);


        $this->emit('role-added', 'Se registró el rol');
        $this->ResetUI();
    }

    public function Edit(Role $role)
    {

        $this->selected_id = $role->id;
        $this->roleName = $role->name;

        $this->emit('show-modal', 'show modal');
    }

    public function UpdateRole()
    {
        $rules = [
            'roleName' => "required|min:2|unique:roles,name, {$this->selected_id}"
        ];

        $message = [
            'roleName.required' => 'Debe escribir un nombre para el rol.',
            'roleName.min' => 'El nombre rol debe tener más de 2 caracteres.',
            'roleName.unique' => 'Nombre del rol ya existe.'
        ];

        $this->validate($rules, $message);

        $role = Role::find($this->selected_id);
        $role->name = $this->roleName;
        $role->save();

        $this->emit('role-updated', 'Se actualizo el rol');
        $this->ResetUI();
    }

    protected $listeners = ['deleteRecord' => 'Destroy'];

    public function Destroy($id)
    {
        $permissionCount = Role::find($id)->permissions->count();

        if ($permissionCount > 0) {
            $this->emit('role-error', 'No se puede eliminar el rol, porque tiene permisos asociados');
            return;
        }

        Role::find()->delete();
        $this->emit('role-deleted', 'Se eliminó el rol');
    }

    public function ResetUI()
    {
        $this->resetValidation();
        $this->roleName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetPage();
    }
}

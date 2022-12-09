<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersController extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $name, $phone, $email, $status, $image, $password, $selected_id, $profile;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Usuarios";
        $this->status = "Elegir";
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            sleep(1);
            $data = User::where('name', 'like', '%' . $this->search . '%')
            ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = User::select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        }
        

        return view('livewire.users.component', [
            'data' => $data,
            'roles' => Role::orderBy('name', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function ResetUI()
    {

        $this->resetValidation();
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->password = '';
        $this->search = '';
        $this->status = 'Elegir';
        $this->profile = 'Elegir';
        $this->image = null ;
        $this->selected_id = 0 ;
        $this->resetPage();
    }

    public function Edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->password = '';

        $this->emit('show-modal', 'show modal');
    }

    protected $listeners = [
        'deleteRecord' => 'Destroy',
        'ResetUI' => 'ResetUI'
    ];

    public function Store()
    {
        $rules = [
            'name' => 'required|min:3',
            'phone' => 'required|min:8|max:9',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3',
            'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048'
        ];

        $this->validate($rules);

        $user = User::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)
        ]);

        $user->syncRoles($this->profile);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }

        $this->resetUI();
        $this->emit('user-added', 'Usuario registrado');
    }

    public function Update()
    {
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'phone' => 'required|min:8|max:9',
            'name' => 'required|min:3',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3',
            'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048'
        ];

        $this->validate($rules);

        $user = User::find($this->selected_id);

        $user->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)
        ]);

        $user->syncRoles($this->profile);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $imageTemp = $user->image;
            $user->image = $customFileName;
            $user->save();

            if ($imageTemp != NULL) {
                if (file_exists('storage/users/' . $imageTemp)) {
                    unlink('storage/users/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('user-updated', 'Datos del usuario actualizados.');
    }

    public function Destroy(User $user)
    {

        if ($user) {
            $sale = Sale::where('user_id', $user->id)->count();
            if ($sale > 0) {
                $this->emit('user-with', 'No se puede eliminar al usuario porque tiene ventas asociadas'); 
            }
        } else {
            $imageTemp = $user->image;
            $user->delete();
    
            if ($imageTemp != NULL) {
                if (file_exists('storage/users/' . $imageTemp)) {
                    unlink('storage/users/' . $imageTemp);
                }
            }
    
            $this->resetUI();
            $this->emit('user-deleted', 'Usuario eliminado.');  
        } 
    }
}

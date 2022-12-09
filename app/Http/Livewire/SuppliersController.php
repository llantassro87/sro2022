<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class SuppliersController extends Component
{

    use WithPagination;

    public $name, $phone, $contactname, $contactphone, $address, $description, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = "Listado";
        $this->componentName = "Proveedores";
        $this->status = "Elegir";
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            sleep(1);
            $data = Supplier::where('name', 'like', '%' . $this->search . '%')
            ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = Supplier::select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        }
        

        return view('livewire.supplier.component', [
            'data' => $data
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function ResetUI()
    {

        $this->resetValidation();
        $this->name = '';
        $this->phone = '';
        $this->selected_id = 0 ;
        $this->resetPage();
    }

    public function Edit(Supplier $supplier)
    {
        $this->selected_id = $supplier->id;
        $this->name = $supplier->name;
        $this->phone = $supplier->phone;

        $this->emit('show-modal', 'show modal');
    }

    protected $listeners = [
        'deleteRecord' => 'Destroy',
        'ResetUI' => 'ResetUI'
    ];

    public function Store()
    {
        $rules = [
            'name' => 'required|min:5',
            'phone' => 'required|min:8|max:9',
        ];


        $this->validate($rules);

        $supplier = Supplier::create([
            'name' => $this->name,
            'phone' => $this->phone
        ]);

        $this->resetUI();
        $this->emit('supplier-added', 'Proveedor registrado');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:5|unique:suppliers,name,{$this->selected_id}",
            'phone' => 'required|min:8|max:9'
        ];

        $this->validate($rules);

        $supplier = Supplier::find($this->selected_id);

        $supplier->update([
            'name' => $this->name,
            'phone' => $this->phone
        ]);


        $this->resetUI();
        $this->emit('supplier-updated', 'Datos del proveedor actualizados.');
    }

    public function Destroy(Supplier $supplier)
    {

        $supplier->delete();

    
        $this->resetUI();
        $this->emit('Supplier-deleted', 'Proveedor eliminado.');  
    }
}
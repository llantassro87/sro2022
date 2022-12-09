<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class CoinsController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $type, $value, $image, $search, $selected_id, $componentName, $pageTitle;
    private $pagination = 10;

    public function mount() {
        $this->componentName = 'Denominaciones';
        $this->pageTitle = 'Listado';
        $this->type = 'Elegir';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {

        if (strlen($this->search) > 0) {
            sleep(1);
            $data = Denomination::where('type', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $data = Denomination::orderBy('id', 'desc')->paginate($this->pagination);
        }
        

        return view('livewire.denominations.component', ['data' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id)
    {
        $record = Denomination::find($id, ['id', 'type', 'value', 'image']);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
        
    }

    public function Store()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => 'required|unique:denominations',
            'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048'
        ];

        $this->validate($rules);

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        $this->ResetUI();
        $this->emit('item-added', 'denominación registrada');
    }

    public function Update()
    {
        $rules = [
            'type' => "required|not_in:Elegir",
            'value' => "required|unique:denominations,value,{$this->selected_id}",
            'image' => 'nullable|mimes:jpg,gif,png,jpeg|image|max:2048'
        ];

        $this->validate($rules);

        $denomination = Denomination::find($this->selected_id);
        $denomination->update([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if ($this->image) {

            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $imageName = $denomination->image;

            $denomination->image = $customFileName;
            $denomination->save();

            if ($imageName != NULL) {
                if (file_exists('storage/denominations/' . $imageName)) {
                    unlink('storage/denominations/' . $imageName);
                }
            }
        }

        $this->ResetUI();
        $this->emit('item-updated', 'Categoría actualizada.');
        
    }

    public function ResetUI()
    {
        $this->resetValidation();
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
        $this->resetPage();
    }

    protected $listeners = [
        'deleteRecord' => 'Destroy'
    ];

    public function Destroy(Denomination $denomination)
    {
        $imageName = $denomination->image;
        $denomination->delete();

        if ($imageName != NULL) {
            unlink('storage/denominations/' . $imageName);
        }

        $this->ResetUI();
        $this->emit('item-deleted', 'Categoría eliminada.');
    }
}

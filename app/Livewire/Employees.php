<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Employees extends Component
{


    use WithPagination;
    public $search = "";


    public function render()
    {
        return view('livewire.employees', [
            'users' => User::query()
                ->where('is_superadmin', null)
                ->when(auth()->user()->divisions_id, function ($query) {
                    $query->where('divisions_id', auth()->user()->divisions_id);
                })
                ->when(strlen($this->search) >= 1, function ($query) {
                    $query->where('name', 'like', "%" . $this->search . "%");
                })
                ->paginate(20),
        ]);
    }
}

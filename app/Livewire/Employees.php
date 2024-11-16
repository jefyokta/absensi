<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Employees extends Component
{


    public $search = "";


    public function render()
    {

        $users = User::where('is_superadmin', null);
        if (auth()->user()->divisions_id) {
            $users = $users->where('divisions_id', auth()->user()->divisions_id);
        }

        if (strlen($this->search >= 1)) {
            $users =  $users->where('name', 'like', "%" . $this->search . "%");
        }
        $users =  $users->get();

        return view('livewire.employees', ['users' => $users]);
    }
}

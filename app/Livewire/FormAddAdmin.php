<?php

namespace App\Livewire;

use App\Models\SubDivisions;
use Livewire\Component;

class FormAddAdmin extends Component
{

    public bool $showPassword = false;
    public bool $showConfirmPassword = false;

    public $password = "";
    public $confirmpassword = "";

    public function setpassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function setconfirmpassword()
    {
        $this->showConfirmPassword = !$this->showConfirmPassword;
    }

    public function render()
    {
        $showpassword = $this->showPassword;
        $showconfirmpassword = $this->showConfirmPassword;
        $divisions = SubDivisions::all();

        $confirmerror = false;
        if (strlen($this->confirmpassword) >= 1) {
            if ($this->password !== $this->confirmpassword) {
                $confirmerror = true;
            } else {
                $confirmerror = false;
            }
        }
        return view('livewire.form-add-admin', compact("divisions", "showpassword", "showconfirmpassword", "confirmerror"));
    }
}

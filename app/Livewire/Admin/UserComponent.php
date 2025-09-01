<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class UserComponent extends Component
{

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function assignRole(User $user, $value)
    {
        if ($value == '1') {
            $user->assignRole('admin');
        }
        else{
            $user->removeRole('admin');
        }
    }

    public function render()
    {

        $users = User::where('name','LIKE', '%' . $this->search . '%')
        ->orWhere('email','LIKE', '%' . $this->search . '%')
        ->paginate();

        return view('livewire.admin.user-component',compact('users'))->layout('layouts.admin');
    }
}

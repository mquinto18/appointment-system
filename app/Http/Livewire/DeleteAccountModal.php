<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteAccountModal extends Component
{
    public $confirmingDeletion = false;

    public function confirmDelete()
    {
        $this->confirmingDeletion = true;
    }

    public function deleteAccount()
    {
        // Delete the user's account
        $user = Auth::user();
        $user->delete();

        // Log the user out
        Auth::logout();

        // Redirect after account deletion
        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }

    public function render()
    {
        return view('livewire.delete-account-modal');
    }
}
    

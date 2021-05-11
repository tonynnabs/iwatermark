<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;

    public $photo;

    public function save()
    {
        dd($this->photo);
    }

    public function render()
    {
        return view('livewire.file-upload');
    }
}

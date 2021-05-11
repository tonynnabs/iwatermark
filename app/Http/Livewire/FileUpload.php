<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Component
{
    use WithFileUploads;

    public $photo;
    public $showDownloadModal = false;
    public $downloadUrl ='';


    public function save()
    {

        $this->validate([
            'photo' => 'image|max:25000',
        ]);

        ini_set('max_execution_time', 600);
        $filename = $this->photo->store('/', 'watermark');
        $fileUrl = Storage::disk('watermark')->path($filename);
        $photo = fopen($fileUrl, 'r');

        $mask = Storage::disk('watermark')->path('mask.png');
        $maskUrl = fopen($mask, 'r');

        /**uploading image and mask to server */
        $response = Http::attach(
            'image', $photo, $fileUrl
        )->attach(
            'mask', $maskUrl, $mask
        )->post('http://3.20.22.15:8080/predict')->json();

        /** formating response to a proper JSON format */
        $response = $this->formatResponse($response);

        /** parsing JSON file to get image url */
        $response = json_decode($response, true);
        foreach($response['watermarks'] as $image => $path){
            $this->downloadUrl = $path['output_image'];
        }
        $this->showDownloadModal = true;
        Storage::disk('watermark')->delete($filename);
        $this->photo = '';

    }


    private function formatResponse($response)
    {
        $response = str_replace("'", '"', $response);
        $response = str_replace("T", 't', $response);
        return $response;
    }



    public function render()
    {
        return view('livewire.file-upload');
    }
}

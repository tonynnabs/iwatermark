<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WatermarkController extends Controller
{
    public function remove(Request $request)
    {
        $watermarkedImage = 'storage/' .$request->markImage->store('watermark');
        $photo = fopen($watermarkedImage, 'r');

        $mask = 'storage/watermark/mask.png';
        $mask_photo = fopen($mask, 'r');

        /**uploading image and mask to server */
        $response = Http::attach(
            'image', $photo, $watermarkedImage
        )->attach(
            'mask', $mask_photo, $mask
        )->post('http://3.20.22.15:8080/predict')->json();

        /** formating response to a proper JSON format */
        $response = $this->formatResponse($response);

        /** parsing JSON file to get image url */
        $response = json_decode($response, true);
        foreach($response['watermarks'] as $image => $path){
            dd($path['output_image']);
        }

        return view('remove');
    }

    /**
     * formatting string response to correct json format
     *
     * @param string $response
     * @return string
     */
    private function formatResponse($response)
    {
        $response = str_replace("'", '"', $response);
        $response = str_replace("T", 't', $response);
        return $response;
    }
}

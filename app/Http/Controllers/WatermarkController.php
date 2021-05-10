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
        $response = Http::attach(
            'image', $photo, $watermarkedImage
        )->attach(
            'mask', $mask_photo, $mask
        )->post('http://3.20.22.15:8080/predict')->json();

        dd($response);

        return view('remove');
    }

    /**
     * formatting string response to correct json format
     *
     * @param string $response
     * @return JSON
     */
    private function formatResponse($response)
    {
        $response = str_replace("'", '"', $response);
        $response = str_replace("T", 't', $response);
        return $response;
    }

    /**
     * creating json file and saving response to it
     *
     * @param JSON $response
     * @return mixed
     */
    private function createJsonFile($data)
    {
        $file = fopen('storage/watermark/predict.json','w');
        fwrite($file, $data);
        fclose($file);
        return $jsonUrl = 'storage/watermark/predict.json';

    }
}

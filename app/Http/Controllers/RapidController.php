<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RapidController extends Controller
{
    public  function run(Request $request)
    {
        $uploadedImage = 'storage/'.$request->markImage->store('watermark');
        // $uploadedImage = $request->markImage;
        $photo = fopen($uploadedImage, 'r');
        // dd(asset($uploadedImage));
        $response = Http::attach(
            'file', $photo, $uploadedImage
        )->withHeaders([
            'content-type' => 'multipart/form-data; boundary=---011000010111000001101001',
            'x-rapidapi-key' => 'a9b0ef90c7msh893212751ea361fp1c7586jsn60a1b14ad51b',
            'x-rapidapi-host' => 'watermark-removal-ai.p.rapidapi.com'
        ])->post('https://watermark-removal-ai.p.rapidapi.com/tensor')->json();

        dd($response);

        return view('remove');
    }
}
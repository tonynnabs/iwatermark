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

        /**
         * API Call to the first server function
         */
        $response = Http::attach(
            'image', $photo, $watermarkedImage
        )->post(config('services.iwatermark.server_1_url'))->json();
        $response = $this->formatResponse($response); //formatting string response to json
        $firstJsonUrl = $this->createJsonFile($response); //saving json response to a file


        /**
         * API Call to the second server function
         */
        $response = $this->secondServer($firstJsonUrl, $watermarkedImage);
        $response = $this->formatResponse($response); //formatting string response to json
        $secondJsonUrl = $this->createJsonFile($response); //saving json response to a file


        /**
         * API Call to the third server function
         */
        $response = $this->thirdServer($secondJsonUrl);
        dd($response);

        return view('remove');
    }

    /**
     * second server api call
     *
     * @param string $jsonUrl
     * @param string $image
     * @return string
     */
    private function secondServer($jsonUrl, $image)
    {
        $json_url_open = fopen($jsonUrl, 'r');
        $photo = fopen($image, 'r');

        return $response = Http::attach(
            'image', $photo, $image
        )->attach(
            'upload_file', $json_url_open, $jsonUrl
        )->post(config('services.iwatermark.server_2_url'))->json();

        return $response;
    }

    /**
     * Api call
     *
     * @param string $secondJson
     * @return string
     */
    private function thirdServer($secondJson)
    {
        $json_url_open = fopen($secondJson, 'r');
        $response = Http::attach(
            'upload_file',  $json_url_open, $secondJson
        )->post(config('services.iwatermark.server_3_url'))->json();

        return $response;
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
     * @return string
     */
    private function createJsonFile($response)
    {
        $file = fopen('storage/watermark/predict.json','w');
        fwrite($file, $response);
        fclose($file);
        return $jsonUrl = 'storage/watermark/predict.json';

    }
}

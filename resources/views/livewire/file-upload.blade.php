<div
    style="border-radius: 2.5rem; background-image: url('/img/strokes.svg')"
    class="bg-center cover h-4/5 bg-green-50 w-4/5 flex flex-col justify-start items-center p-9">
    <h1 class="text-gray-800 md:text-5xl text-2xl  text-center font-bold leading-tight">Watermark <br> Removal Tool
    </h1>

    @if ($photo)
        @error('photo')
            <p class="m-5 text-red-500 text-sm">{{$message}}</p>
        @enderror
    @endif


    <div class="bg-white h-72 sm:w-3/4 md:w-1/3 bottom-5 p-7 absolute shadow-md rounded-2xl ">

        <div class="border-dashed border-4 p-1 border-gray-200 h-full w-full rounded-2xl">
            <div
                @if ($photo)
                    style="background-image: url('{{$photo->temporaryUrl()}}')"
                @endif
                for="photo"
                class="rounded-2xl bg-cover h-full w-full relative">
                @if ($photo)
                        <span class="z-50 pointer-events-auto top-4 right-4 absolute" wire:click="$set('photo', '')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" class="text-red-600" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                        </span>
                    @endif

                <label for="photo" class=" h-full w-full flex flex-col justify-center items-center">
                    @if ($photo)
                        <div class="flex bg-white opacity-70 rounded-2xl h-full w-full absolute"></div>
                    @else
                        <div class="flex bg-main opacity-10 rounded-2xl h-full w-full absolute"></div>
                    @endif

                    <input class="hidden" type="file" id="photo" wire:model="photo">
                    <button
                        wire:click="save"
                        class="z-50 text-white bg-main py-3 px-7 rounded-xl focus:outline-none flex justify-center items-center"
                        @if (!$photo)
                            style="pointer-events: none;"
                        @endif>
                        <span class="spinner mr-5" wire:loading></span>
                        @if ($photo)
                            Remove Watermark
                        @else
                            Upload Image
                        @endif
                    </button>
                </label>


            </div>
        </div>

        {{-- Download Modal starts here --}}
        <x-download-modal maxWidth='md' wire:model="showDownloadModal">
                <div class="flex flex-col justify-center items-center">
                    <div class="bg-green-50 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" class="text-green-500" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h1 class="font-bold my-4 text-lg text-center" >Process Completed Successfully</h1>
                    <p class="text-center">Thank you for using Iwatermark, please feel free to share the website with your friends</p>
                    <x-button class="mt-5" size="lg" href="{{$downloadUrl}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                          </svg>
                          Download
                    </x-button>
                </div>
        </x-download-modal>

        {{-- Download Modal Ends here --}}
    </div>

</div>


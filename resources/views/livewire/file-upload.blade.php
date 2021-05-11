<div class="bg-white h-72 sm:w-3/4 md:w-1/3 bottom-5 p-7 absolute shadow-md rounded-2xl ">
    <div class="border-dashed border-2 p-1 border-gray-500 h-full w-full rounded-2xl">
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
</div>

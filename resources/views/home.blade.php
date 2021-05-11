<x-app-layout>
    <header>
        <nav class="flex container mx-auto justify-between items-center px-3 py-5">
            <h1>Iwatermark</h1>
            <ul class="md:flex justify-between font-medium hidden">
                <li class="px-5 hover:text-main transition ease-in-out duration-300">Home</li>
                <li class="px-5 hover:text-main transition ease-in-out duration-300" >How it works</li>
                <li class="px-5 hover:text-main transition ease-in-out duration-300">Developers</li>
            </ul>
            <div>
                <button
                    class="font-bold">Login</button>
                <button
                    class="hover:bg-main-dark rounded-lg px-4 font-bold text-sm ml-3 py-3 bg-main transition ease-in-out duration-300 text-white">Register</button>
            </div>
        </nav>
    </header>
    <main>
        <section class=" h-screen flex justify-center items-center relative">
            <div
                style="border-radius: 2.5rem; background-image: url('/img/strokes.svg')"
                class="bg-center cover h-4/5 bg-green-50 w-4/5 flex flex-col justify-start items-center p-9">
                <h1 class="text-gray-800 md:text-5xl text-2xl  text-center font-bold leading-tight">Watermark <br> Removal Tool
                </h1>

                @livewire('file-upload')
            </div>
        </section>

        {{-- <div class="container bg-white h-96 w-full mx-auto flex mt-10 justify-center items-center">
            <div class=" example-image h-full bg-cover bg-center  w-1/2"
                style="background-image: url('/img/before.jpg') ">

            </div>
            <div class="w-1/2 p-10">
                <form action="{{ route('mark.run') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" class="h-full w-full " name="markImage" id="markImage">
                    <button type="submit" class="bg-blue-500 px-3 py-2 text-white rounded-md mt-3">Submit</button>
                </form>

            </div>
        </div> --}}
    </main>

</x-app-layout>

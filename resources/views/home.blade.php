<x-guest-layout>
    <header class="bg-main">
        <nav class="flex container mx-auto justify-between  px-3 py-3">
            <img src="/img/main-logo.svg" alt="Logo" class="w-60">
            <div>
                <button
                    class="rounded-md px-3 font-medium text-sm py-2 hover:bg-gray-200 transition ease-in-out duration-300 bg-white text-black-500">Login</button>
                <button
                    class="rounded-md px-3 font-medium text-sm ml-3 py-2 bg-white transition ease-in-out duration-300 text-black-500">Register</button>
            </div>
        </nav>
    </header>
    <main>
        <div class="container bg-white h-96 w-full mx-auto flex mt-10 justify-center items-center">
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
        </div>
    </main>

</x-guest-layout>

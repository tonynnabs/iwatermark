@props([
    'size' => 'sm'
])

<a {{$attributes->merge(['class' => "hover:bg-main-dark flex flex-row justify-center items-center rounded-lg px-4 font-bold text-$size ml-3 py-3 bg-main transition ease-in-out duration-300 text-white"])}}>
    {{$slot}}
</a>

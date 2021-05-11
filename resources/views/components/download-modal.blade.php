@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="p-10">
        <div class="mt-4">
            {{ $slot }}
        </div>
    </div>
</x-jet-modal>

<div>
    {{-- Render Tema Secara Dinamis --}}
    {{-- Kita kirimkan data invitation dan guest ke dalam tema --}}

    <x-dynamic-component :component="$componentName" :invitation="$invitation" :guest="$guest" />
</div>

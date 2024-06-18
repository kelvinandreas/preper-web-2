@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'pl-2 border-accent focus:border-btnaccent focus:ring-red-500 rounded-md shadow-sm py-2']) !!}>

@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'pl-2 border-gray-300 border-indigo-500 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-2']) !!}>

@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-[#1a1a1a] dark:text-gray-300 focus:border-[#e4ff4a] dark:focus:border-[#e4ff4a] focus:ring-[#cce443] dark:focus:ring-[#cce443] rounded-md shadow-sm w-full']) !!}>

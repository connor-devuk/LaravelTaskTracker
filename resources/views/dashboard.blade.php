<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row md:flex-wrap">
            <img src="https://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?s=48" alt="logo" class="rounded-full">
            <div class="user-info ml-3 my-auto">
                <h4 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Welcome back') }}, {{ auth()->user()->name }}
                </h4>
                <p class="font-regular text-md text-gray-800 dark:text-gray-300">Here you can track and create new tasks!</p>
            </div>
        </div>
    </div>
    <div class="py-12 tasks">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            Tasks Here
        </div>
    </div>
</x-app-layout>

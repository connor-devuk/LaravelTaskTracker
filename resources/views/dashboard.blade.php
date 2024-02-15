<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-12 pb-6">
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
    <div class="py-6 tasks">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="title flex">
                <h4 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight my-auto">
                    {{ __('Tasks') }}
                </h4>
                <x-primary-button class="ms-auto my-auto" x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-task')">{{ __('Create Task') }}</x-primary-button>
            </div>

            <div class="task-box mt-3">
                <ul class="task-list list-none p-0 m-0 max-h-[500px] overflow-y-scroll flex flex-col">
                    @foreach(auth()->user()->tasks as $task)
                        <li class="task-card {{ ($task->status === 'complete') ? 'completed' : '' }} border-b border-gray-100 dark:border-gray-700" id="{{$task->id}}">
                            <div class="flex flex-col md:flex-row md:flex-wrap">
                                <i class="fa-light fa-circle-check text-gray-400 mt-2"></i>
                                <div class="text-white text-xl font-semibold ml-2">
                                    <small class="mb-1">{{ $task->name }}</small>
                                </div>
                                <div class="date mb-auto ml-auto text-end">
                                    <p class="text-white mb-3">
                                        Due {{ \Carbon\Carbon::parse($task->due_by)->diffForHumans(['parts' => 1]) }}</p>
                                    <span
                                        class="bg-red-700 text-white p-1 rounded font-semibold text-sm {{ (Carbon\Carbon::parse($task->due_by)->isPast()) ? '' : 'hidden' }}">Overdue</span>
                                   @if($task->status === 'completed')
                                    <span
                                        class="badge bg-success">Completed</span>
                                    @endif
                                </div>

                                <div class="task-desc w-full mt-1">
                                    <p class="font-regular text-md text-gray-800 dark:text-gray-300">{{$task->description}}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <x-modal name="create-task" :show="$errors->taskCreation->isNotEmpty()" focusable>
        <form method="post" action="{{ route('tasks.create') }}" class="p-6">
            <h4 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight my-auto">
                {{ __('Create Task') }}
            </h4>
            @csrf

            <div class="mt-6">
                <x-input-label for="name" value="{{ __('Title') }}"/>

                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-3 block w-3/4"
                    placeholder="{{ __('Cook dinner') }}"
                    required
                />

                <x-input-error :messages="$errors->taskCreation->get('name')" class="mt-2" />
            </div>
            <div class="mt-6">
                <x-input-label for="description" value="{{ __('Description') }}"/>

                <x-text-input
                    id="description"
                    name="description"
                    type="text"
                    class="mt-3 block w-3/4"
                    placeholder="{{ __('Preheat the oven to 120 degrees and put pizza inside!') }}"
                    required
                />

                <x-input-error :messages="$errors->taskCreation->get('description')" class="mt-2"/>
            </div>
            <div class="mt-6">
                <x-input-label for="due_by" value="{{ __('Due Date') }}"/>

                <x-text-input
                    id="due_by"
                    name="due_by"
                    type="date"
                    class="mt-3 block w-3/4"
                    placeholder="{{ __('DD/MM/YYYY') }}"
                    required
                />

                <x-input-error :messages="$errors->taskCreation->get('due_by')" class="mt-2"/>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Submit') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

</x-app-layout>

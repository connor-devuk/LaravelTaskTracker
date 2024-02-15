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
                <ul class="task-list">
                    @foreach(auth()->user()->tasks as $task)
                        <li class="task-card {{ ($task->status === 'complete') ? 'completed' : '' }}" id="{{$task->id}}">
                            <div class="d-flex">
                                <i class="fa-light fa-circle-check"></i>
                                <div class="date mb-auto ms-auto text-end">
                                    <p class="mb-0">
                                        Due {{ \Carbon\Carbon::parse($task->due_by)->diffForHumans(['parts' => 1]) }}</p>
                                    <span
                                        class="badge bg-danger {{ (Carbon\Carbon::parse($task->due_by)->isPast()) ? '' : 'd-none' }}">Overdue</span>
                                    <span
                                        class="badge bg-success {{ ($task->due_by) ?? 'd-none' }}">Completed</span>
                                </div>
                            </div>
                            <div class="task-desc w-100 mt-1">
                                <p class="mb-0">{{$task->description}}</p>
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
                <x-input-label for="title" value="{{ __('Title') }}"/>

                <x-text-input
                    id="title"
                    name="title"
                    type="text"
                    class="mt-3 block w-3/4"
                    placeholder="{{ __('Cook dinner') }}"
                    required
                />

                <x-input-error :messages="$errors->userDeletion->get('title')" class="mt-2" />
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

                <x-input-error :messages="$errors->userDeletion->get('description')" class="mt-2"/>
            </div>
            <div class="mt-6">
                <x-input-label for="due_by" value="{{ __('Due Date') }}"/>

                <x-text-input
                    id="due_by"
                    name="due_by"
                    type="date"
                    class="mt-3 block w-3/4"
                    placeholder="{{ __('DD/MM/YY') }}"
                    required
                />

                <x-input-error :messages="$errors->userDeletion->get('due_by')" class="mt-2"/>
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

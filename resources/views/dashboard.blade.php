<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row md:flex-wrap">
            <img src="https://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?s=48" alt="logo"
                 class="rounded-full">
            <div class="user-info ml-3 my-auto">
                <h4 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Welcome back') }}, {{ auth()->user()->name }}
                </h4>
                <p class="font-regular text-md text-gray-800 dark:text-gray-300">Here you can track and create new
                    tasks!</p>
            </div>
        </div>
    </div>
    <div class="py-6 tasks">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="title flex">
                <h4 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight my-auto">
                    {{ __('Tasks') }}
                </h4>
                <x-primary-button class="ms-auto my-auto" x-data=""
                                  x-on:click.prevent="$dispatch('open-modal', 'create-task')">{{ __('Create Task') }}</x-primary-button>
            </div>

            <div class="task-box mt-3">
                <ul class="task-list list-none p-0 m-0 max-h-[500px] overflow-y-scroll flex flex-col rounded-md">
                    @foreach(auth()->user()->tasks as $task)
                        <li class="task-card {{ ($task->status === 'complete') ? 'dark:bg-[#242424]' : '' }} border-b border-gray-100 dark:border-gray-700 dark:hover:bg-[#242424] py-4 px-5"
                            id="{{$task->id}}">
                            <a href="{{ route('tasks.update.status', ['task' => $task->id, 'status' => ($task->status === 'complete') ? 'pending' : 'complete']) }}">
                                <div class="flex flex-col md:flex-row md:flex-wrap">
                                    <i class="fa-light fa-circle-check mt-2 {{ ($task->status === 'complete') ? 'text-green-500' : 'text-gray-400' }}"></i>
                                    <div class="text-white text-xl font-semibold ml-2">
                                        <small class="mb-1 {{ ($task->status === 'complete') ? 'line-through' : '' }}">
                                            {{ $task->name }}
                                            <a href="#"
                                               class="ml-1 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-[#e4ff4a] rounded-md focus:outline-none"
                                               onclick="editTask({{$task->id}})" x-data=""
                                               x-on:click.prevent="$dispatch('open-modal', 'edit-task')">
                                                <i class="fa-light fa-pen-to-square"></i>
                                            </a>
                                        </small>
                                    </div>
                                    <div class="date mb-auto ml-auto text-end">
                                        @if($task->status === 'complete')
                                            <span
                                                class="bg-green-500 text-white py-1 px-2 rounded font-semibold text-sm">Completed</span>
                                        @else
                                            <p class="text-white mb-3">
                                                Due {{ \Carbon\Carbon::parse($task->due_by)->diffForHumans(['parts' => 1]) }}</p>
                                            <span
                                                class="bg-red-700 text-white py-1 px-2 rounded font-semibold text-sm {{ (Carbon\Carbon::parse($task->due_by)->isPast()) ? '' : 'hidden' }}">Overdue</span>
                                        @endif
                                    </div>

                                    <div
                                        class="task-desc w-full mt-1 {{ ($task->status === 'complete') ? 'line-through' : '' }}">
                                        <p class="font-regular text-md text-gray-800 dark:text-gray-300">{{$task->description}}</p>
                                    </div>
                                </div>
                            </a>
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

                <x-input-error :messages="$errors->taskCreation->get('name')" class="mt-2"/>
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

    <x-modal name="edit-task" :show="$errors->taskUpdate->isNotEmpty()" focusable>
        <form method="post" action="#" class="p-6" id="edit-task">
            <h4 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight my-auto">
                {{ __('Edit Task') }}
            </h4>
            @csrf
            @method('patch')

            <div class="mt-6">
                <x-input-label for="edit_name" value="{{ __('Title') }}"/>

                <x-text-input
                    id="edit_name"
                    name="name"
                    type="text"
                    class="mt-3 block w-3/4"
                    placeholder="{{ __('Cook dinner') }}"
                    required
                />

                <x-input-error :messages="$errors->taskUpdate->get('name')" class="mt-2"/>
            </div>
            <div class="mt-6">
                <x-input-label for="edit_description" value="{{ __('Description') }}"/>

                <x-text-input
                    id="edit_description"
                    name="description"
                    type="text"
                    class="mt-3 block w-3/4"
                    placeholder="{{ __('Preheat the oven to 120 degrees and put pizza inside!') }}"
                    required
                />

                <x-input-error :messages="$errors->taskUpdate->get('description')" class="mt-2"/>
            </div>
            <div class="mt-6">
                <x-input-label for="edit_due_by" value="{{ __('Due Date') }}"/>

                <x-text-input
                    id="edit_due_by"
                    name="due_by"
                    type="date"
                    class="mt-3 block w-3/4"
                    placeholder="{{ __('DD/MM/YYYY') }}"
                    required
                />

                <x-input-error :messages="$errors->taskUpdate->get('due_by')" class="mt-2"/>
            </div>

            <div class="mt-6 flex justify-end">
                <x-danger-button class="mr-auto" id="delete-button" type="button">
                    {{ __('Delete Task') }}
                </x-danger-button>
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3" type="submit">
                    {{ __('Submit') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
    <script>
        const tasks = @json(auth()->user()->tasks)

            // Fetch task and generate prefilled fields
            function editTask(id) {
                const task = tasks.find(task => task.id === id);
                if (task) {
                    // Cool the task exists lets prefill the fields
                    document.getElementById('edit_name').value = task.name;
                    document.getElementById('edit_description').value = task.description;
                    document.getElementById('edit_due_by').value = formatDate(task.due_by);

                    // Set the urls
                    document.getElementById('edit-task').action = "/tasks/" + id;
                    document.getElementById('delete-task').action = "/tasks/" + id;
                } else {
                    // Task not found :(
                    console.log("Task not found for id:", id);
                }
            }

        // format date to a string digestable by the date field
        function formatDate(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Listen for when we click delete and set the method to delete
        document.getElementById('delete-button').addEventListener('click', function () {
            document.querySelector('input[name="_method"]').value = 'DELETE';
            document.getElementById('edit-task').submit();
        });
    </script>
</x-app-layout>

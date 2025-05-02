<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Мои задачи</h2>

    <form wire:submit.prevent="createTask" class="mb-4 space-y-2">
        <input wire:model="title" type="text" placeholder="Новая задача" class="border rounded p-2">

        <select wire:model="status" class="border rounded p-2 pr-9">
            <option value="">Выберите статус</option>
            @foreach(\App\Enums\Status::options() as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 ml-2 rounded">Добавить</button>
    </form>

    <ul>
        @foreach($tasks as $task)
            <li class="flex justify-between items-center py-1 border-b">
                @if ($editingTaskId === $task->id)
                    <div class="flex-1 mr-2 bg-blue-200">
                        <input
                            type="text"
                            wire:model="editingTaskTitle"
                            class="border rounded p-2"
                            wire:keydown.enter="updateTask"
                            wire:keydown.escape="cancelEdit"
                        >
                        <select wire:model="editingTaskStatus" class="border rounded p-2 pr-9">
                            <option value="">Выберите статус</option>
                            @foreach (\App\Enums\Status::options() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-1">
                        <button wire:click="updateTask" class="text-green-600">💾</button>
                        <button wire:click="cancelEdit" class="text-gray-600">✖</button>
                    </div>

                @else
                    <div class="relative">
                        <strong class="align-middle">{{ $task->title }}</strong>

                        <span class="absolute top-1/2 transform -translate-y-1/2 left-32 text-sm whitespace-nowrap {{ $task->status->colorClass() }}">
                            {{ $task->status->label() }}
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <small class="text-gray-400">
                            Обновлено: {{ $task->updated_at->diffForHumans() }}
                        </small>
                        <button wire:click="editTask({{ $task->id }})" style="color: blue">Редактировать</button>
                        <button wire:click="deleteTask({{ $task->id }})" class="text-red-500">Удалить</button>
                    </div>

                @endif
            </li>

        @endforeach
    </ul>
</div>

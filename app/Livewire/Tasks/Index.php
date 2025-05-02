<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use App\Enums\Status;
#[Layout('layouts.app')]
class Index extends Component
{
    public $title;
    public $status;
    public $tasks = [];
    public $editingTaskId = null;
    public $editingTaskTitle = '';
    public $editingTaskStatus;

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $this->tasks = Auth::check()
            ? Auth::user()->tasks()->get()
            : collect();
    }

    public function createTask()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'status' => 'required',
        ]);

        Task::create([
            'title' => $this->title,
            'user_id' => Auth::id(),
            'status' => $this->status,
        ]);

        $this->title = '';
        $this->status = Status::PENDING;
        $this->loadTasks(); // Перезагружаем список
    }

    public function deleteTask($id)
    {
        Task::where('id', $id)->where('user_id', Auth::id())->delete();
        $this->loadTasks();
    }

    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        $this->editingTaskId = $task->id;
        $this->editingTaskTitle = $task->title;
        $this->editingTaskStatus = $task->status;
    }

    public function updateTask()
    {
        $this->validate([
            'editingTaskTitle' => 'required|string|max:255',
            'editingTaskStatus' => 'required',
        ]);

        $task = Task::where('id', $this->editingTaskId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $task->title = $this->editingTaskTitle;
        $task->status = $this->editingTaskStatus;
        $task->save();

        $this->editingTaskId = null;
        $this->editingTaskTitle = '';
        $this->editingTaskStatus = Status::PENDING;
        $this->loadTasks();
    }

    public function cancelEdit()
    {
        $this->editingTaskId = null;
        $this->editingTaskTitle = '';
    }

    public function render()
    {
        return view('livewire.tasks.index');
    }
}


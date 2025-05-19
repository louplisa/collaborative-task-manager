<?php

namespace App\Livewire;

use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class BoardTasks extends Component
{
    public Project $project;
    public $tasksPerStatus = [];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->loadingTasks();
    }

    public function loadingTasks()
    {
        $this->tasksPerStatus = [
            'todo' => $this->project->tasks()->where('status', TaskStatus::TODO)->with('user')->get(),
            'in_progress' => $this->project->tasks()->where('status', TaskStatus::IN_PROGRESS)->with('user')->get(),
            'done' => $this->project->tasks()->where('status', TaskStatus::DONE)->with('user')->get(),
            'cancelled' => $this->project->tasks()->where('status', TaskStatus::CANCELLED)->with('user')->get(),
            'blocked' => $this->project->tasks()->where('status', TaskStatus::BLOCKED)->with('user')->get(),
        ];
    }

    public function updateStatus($taskId, $newStatus)
    {
        $task = Task::find($taskId);
        if ($task && $task->project_id === $this->project->id) {
            $task->status = $newStatus;
            $task->save();
            $this->loadingTasks();
        }
    }
    public function render()
    {
        return view('livewire.board-tasks');
    }
}

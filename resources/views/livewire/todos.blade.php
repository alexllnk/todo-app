<?php

use App\Mail\TodoCreated;
use App\Models\Todo;
use Illuminate\Support\Facades\Mail;

use function Livewire\Volt\{state, with};

state(['task']);

with([
    'todos' => fn () => auth()->user()->todos
]);

$add = function () {
    $task = auth()->user()->todos()->create(['body' => $this->task]);
    Mail::to(auth()->user()->email)->queue(new TodoCreated($task));
    $this->task = '';
};

$delete = fn (Todo $todo) => $todo->delete();
?>

<div>
    <form wire:submit="add">
        <input type="text" wire:model="task" class="text-blue-600">
        <button type="submit" class="p-4 rounded bg-blue-400 hover:bg-blue-600">Add</button>
    </form>
    <hr class="p-2 my-2 border-t-gray-500">
    @forelse($todos as $todo)
        <div class="flex items-center space-x-2">
            <span>{{ $todo->body }}</span>
            <button wire:click="delete({{ $todo->id }})">
                <svg class="w-[24px] h-[24px]" fill="red" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink"
                     viewBox="0 0 460.775 460.775" xml:space="preserve">
<path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55
	c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55
	c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505
	c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55
	l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719
	c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"/>
</svg>
            </button>
        </div>
    @empty
        <p class="text-gray-500">No todos yet</p>
    @endforelse
</div>

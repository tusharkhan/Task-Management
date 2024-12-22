<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::guard('api')->user();
        $priorities = $request->input('priorities');
        $statuses = $request->input('statuses');

        $tasks = Task::where('user_id', $user->id);

        if ($priorities){
            $tasks = $tasks->whereIn('priority', $priorities);
        }

        if ($statuses){
            $tasks = $tasks->whereIn('status', $statuses);
        }

        $tasks = $tasks->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('status');

        return sendSuccess(
            'Tasks fetched successfully',
            $tasks,
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $taskRequest)
    {
        $user = Auth::guard('api')->user();
        $task = $this->processTaskData(new Task(), $taskRequest);
        $task->user_id = $user->id;
        $task->save();

        return sendSuccess(
            'Task created successfully',
            $task,
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return sendError('Task not found', [], Response::HTTP_NOT_FOUND);
        }

        return sendSuccess(
            'Task fetched successfully',
            $task,
            Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $taskRequest, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return sendError('Task not found', [], Response::HTTP_NOT_FOUND);
        }

        $task = $this->processTaskData($task, $taskRequest);
        $task->save();

        return sendSuccess(
            'Task updated successfully',
            $task,
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        $task = Task::where('user_id', $user->id)->find($id);

        if (!$task) {
            return sendError('Task does not belongs to you', [], Response::HTTP_UNAUTHORIZED);
        }

        $task->delete();

        return sendSuccess(
            'Task deleted successfully',
            [],
            Response::HTTP_OK
        );
    }

    private function processTaskData($task,FormRequest $request)
    {
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->priority = $request->priority;
        $task->is_completed = $request->is_completed;
        $task->due_date = Carbon::parse($request->due_date)->format('Y-m-d');

        if($request->is_completed ) $task->status = 'completed';

        return $task;
    }
}

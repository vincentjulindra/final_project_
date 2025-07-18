<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskOwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $taskId = $request->route('task'); // pastikan route parameternya 'task'
        $task = Task::find($taskId);

        if (!$task || $task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized - not the owner'], 403);
        }

        return $next($request);
    }
}



<?php

namespace App\Tasks;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class MarkOverdueTasks
{
    public function __invoke()
    {
        
         Task::where('due_date', '<', now()) 
            ->where('status', '!=', 'overdue') 
            ->update(['status' => 'overdue']); 

    }
}

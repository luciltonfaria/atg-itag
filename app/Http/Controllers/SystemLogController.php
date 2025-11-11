<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;
use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = SystemLog::with('user')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('audit.system-logs', compact('logs'));
    }
}
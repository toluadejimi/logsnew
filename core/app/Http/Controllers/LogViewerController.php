<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class LogViewerController extends Controller
{
    public function index()
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = File::exists($logPath) ? File::get($logPath) : 'No logs found.';

        return view('logs', ['logs' => $logs]);
    }
}

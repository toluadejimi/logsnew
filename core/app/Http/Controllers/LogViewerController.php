<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class LogViewerController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = File::exists($logFile) ? File::get($logFile) : 'Log file does not exist.';

        return view('logs.index', ['logs' => $logs]);
    }
}

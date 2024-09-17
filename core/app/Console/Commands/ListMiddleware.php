<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class ListMiddleware extends Command
{
    protected $signature = 'middleware:list';
    protected $description = 'List active middleware for all routes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $routes = app('router')->getRoutes();

        foreach ($routes as $route) {
            if ($route instanceof Route) {
                $this->info('URI: ' . $route->uri());
                $this->info('Middleware: ' . implode(', ', $route->middleware()));
                $this->info('-------------------');
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Decorators\DashboardDecorator;

class DashboardController extends Controller
{
    /**
     * Invoke the dashboard page
     * @return View
     */
    public function __invoke(): View
    {
        $chart = DashboardDecorator::chart();
        $state = DashboardDecorator::state();
        $traffic = DashboardDecorator::traffic();
        $agents = DashboardDecorator::agents();
        $categories = DashboardDecorator::categories();
        $teams = DashboardDecorator::teams();
        return view('dashboard', compact('chart', 'state', 'traffic', 'agents', 'categories', 'teams'));
    }
}

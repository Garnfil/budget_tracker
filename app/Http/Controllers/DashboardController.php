<?php

namespace App\Http\Controllers;

use App\Traits\AdminDashboard;
use App\Traits\ClientDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    use AdminDashboard, ClientDashboard;

    public function dashboard() {
        $user = Auth::user();

        if($user->role == 'client') {
            return $this->clientDashboard();
        }

        return $this->adminDashboard();
    }
}

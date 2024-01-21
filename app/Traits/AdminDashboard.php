<?php

namespace App\Traits;

trait AdminDashboard {
    public function adminDashboard() {
        return view('dashboard.admin.admin-dashboard');
    }
}
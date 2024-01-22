<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateRequest;
use App\Models\User;
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

    public function profile(Request $request) {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function updateProfile(UpdateRequest $request, $id) {
        $data = $request->validated();
        $user = User::findOrFail($id);

        $user->update($data);
        
        if($user->role == 'client') {
            $user->client_details->update($data);
        } else {
            $user->admin_details->update($data);
        }

        return back()->withSuccess('Profile updated successfully');
    }
}

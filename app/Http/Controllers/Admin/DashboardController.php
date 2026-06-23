<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $unreadMessages = ContactMessage::whereNull('admin_reply')->count();

        return view('admin.dashboard', compact('unreadMessages'));
    }
}

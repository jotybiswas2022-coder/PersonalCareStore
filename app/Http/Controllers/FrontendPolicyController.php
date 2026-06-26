<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;

class FrontendPolicyController extends Controller
{
    public function privacy()
    {
        return $this->showPage('privacy_policy');
    }

    public function terms()
    {
        return $this->showPage('terms_of_service');
    }

    public function cookie()
    {
        return $this->showPage('cookie_policy');
    }

    private function showPage($type)
    {
        $policy = Policy::active()->byType($type)->firstOrFail();
        return view('frontend.policies.show', compact('policy'));
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Project;
use App\Models\Service;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\Post;
use App\Models\Faq;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $account     = Account::first();
        $usersCount  = User::count();

        $accountsCount    = Account::count();
        $contactsCount    = Contact::count();
        $projectsCount    = Project::count();
        $servicesCount    = Service::count();
        $experiencesCount = Experience::count();
        $skillsCount      = Skill::count();
        $testimonialsCount = Testimonial::count();
        $postsCount       = Post::count();
        $faqsCount        = Faq::count();

        $contacts    = Contact::latest()->take(5)->get();
        $recentProjects = Project::latest()->take(5)->get();
        $recentPosts    = Post::latest()->take(5)->get();
        $recentServices = Service::latest()->take(5)->get();
        $recentMessages = Contact::latest()->take(5)->get();

        $activeProjects    = Project::where('is_active', true)->count();
        $activeServices    = Service::where('is_active', true)->count();
        $activeExperiences = Experience::where('is_active', true)->count();
        $activeSkills      = Skill::where('is_active', true)->count();
        $activeTestimonials = Testimonial::where('is_active', true)->count();
        $publishedPosts    = Post::where('is_published', true)->count();
        $activeFaqs        = Faq::where('is_active', true)->count();

        return view('backend.index', compact(
            'account',
            'usersCount',
            'accountsCount',
            'contactsCount',
            'projectsCount',
            'servicesCount',
            'experiencesCount',
            'skillsCount',
            'testimonialsCount',
            'postsCount',
            'faqsCount',
            'contacts',
            'recentProjects',
            'recentPosts',
            'recentServices',
            'recentMessages',
            'activeProjects',
            'activeServices',
            'activeExperiences',
            'activeSkills',
            'activeTestimonials',
            'publishedPosts',
            'activeFaqs',
        ));
    }
}
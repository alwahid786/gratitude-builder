<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminSetting;
use App\Models\User;
use App\Models\GratitudeStory;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // new code
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalStories = GratitudeStory::count();
        $recentStories = GratitudeStory::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalUsers', 'totalStories', 'recentStories'));
    }

    public function settings()
    {
        $aiSettings = AdminSetting::getGroupSettings('ai');
        $generalSettings = AdminSetting::getGroupSettings('general');
        return view('admin.settings', compact('aiSettings', 'generalSettings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'openai_model' => 'required|string',
            'max_tokens' => 'required|integer|min:1|max:4000',
            'temperature' => 'required|numeric|min:0|max:2',
            'ai_review_prompt' => 'required|string',
            'default_story_title' => 'required|string|max:255',
            'default_story_content' => 'required|string',
        ]);

        foreach ($request->except(['_token', '_method']) as $key => $value) {
            AdminSetting::setValue($key, $value);
        }

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully!');
    }

    public function users()
    {
        $users = User::withCount('gratitudeStories')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function userStories($userId)
    {
        $user = User::findOrFail($userId);
        $stories = GratitudeStory::where('session_id', 'LIKE', '%')->orWhere('id', '!=', null)
                    ->latest()
                    ->paginate(10);
        
        // Get all stories (since we don't have user_id foreign key)
        $allStories = GratitudeStory::latest()->paginate(20);
        
        return view('admin.user-stories', compact('user', 'allStories'));
    }

    public function stories()
    {
        $stories = GratitudeStory::latest()->paginate(20);
        return view('admin.stories', compact('stories'));
    }

    public function deleteStory($id)
    {
        $story = GratitudeStory::findOrFail($id);
        $story->delete();
        
        return redirect()->back()->with('success', 'Story deleted successfully!');
    }

    public function exportStoriesPdf()
    {
        $usersWithStories = User::with(['gratitudeStories' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->whereHas('gratitudeStories')->get();

        $storiesWithoutUser = GratitudeStory::whereNull('user_id')->get();

        $data = [
            'usersWithStories' => $usersWithStories,
            'storiesWithoutUser' => $storiesWithoutUser,
            'generatedAt' => now(),
            'totalUsers' => $usersWithStories->count(),
            'totalStories' => GratitudeStory::count(),
        ];

        return Pdf::loadView('admin.pdf.stories-export', $data)
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'Georgia',
                'dpi' => 150,
                'defaultPaperSize' => 'A4',
                'chroot' => public_path(),
            ])
            ->download('gratitude-stories-from-our-hearts-' . now()->format('Y-m-d') . '.pdf');
    }
}

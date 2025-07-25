{{-- new code - Beautiful Dashboard --}}
@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Total Users</div>
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-number">{{ $totalUsers }}</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i> Active
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Stories Generated</div>
            <div class="stat-icon green">
                <i class="fas fa-book-open"></i>
            </div>
        </div>
        <div class="stat-number">{{ $totalStories }}</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i> {{ $recentStories->count() }} recent
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Today's Stories</div>
            <div class="stat-icon purple">
                <i class="fas fa-calendar-day"></i>
            </div>
        </div>
        <div class="stat-number">{{ $recentStories->where('created_at', '>=', today())->count() }}</div>
        <div class="stat-change positive">
            <i class="fas fa-clock"></i> Last 24h
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-title">Average Daily</div>
            <div class="stat-icon orange">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <div class="stat-number">{{ round($totalStories / max(1, now()->diffInDays(now()->subDays(30))), 1) }}</div>
        <div class="stat-change">
            <i class="fas fa-calculator"></i> Per day
        </div>
    </div>
</div>

<!-- Recent Stories -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clock"></i>
            Recent Stories
        </h3>
        <a href="{{ route('admin.stories') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-right"></i>
            View All Stories
        </a>
    </div>
    <div class="card-body" style="padding: 0;">
        @if($recentStories->count() > 0)
            <div class="table-container" style="border: none; border-radius: 0;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>User Prompt</th>
                            <th>Word Count</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentStories as $story)
                        <tr>
                            <td>
                                <span class="badge badge-blue">#{{ $story->id }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">
                                    {{ Str::limit($story->title, 40) }}
                                </div>
                            </td>
                            <td>
                                <div style="color: #64748b; font-size: 13px; line-height: 1.4;">
                                    {{ Str::limit($story->user_prompt, 60) }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-green">
                                    {{ str_word_count(strip_tags($story->generated_story)) }} words
                                </span>
                            </td>
                            <td>
                                <div style="font-size: 13px; color: #64748b;">
                                    {{ $story->created_at->format('M d, Y') }}<br>
                                    <small style="color: #9ca3af;">{{ $story->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <button type="button" 
                                        class="btn btn-outline btn-sm" 
                                        onclick="viewStory({{ $story->id }})" 
                                        title="View Story">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                <i class="fas fa-book-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h4 style="color: #64748b; margin-bottom: 8px; font-weight: 600;">No Stories Yet</h4>
                <p style="color: #9ca3af; margin: 0;">Stories will appear here once users start creating them</p>
            </div>
        @endif
    </div>
</div>

<!-- System Overview -->
<div class="admin-grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i class="fas fa-chart-line"></i>
                Activity Overview
            </h4>
        </div>
        <div class="card-body">
            <div style="space-y: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">This Week</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $recentStories->where('created_at', '>=', now()->startOfWeek())->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">This Month</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $recentStories->where('created_at', '>=', now()->startOfMonth())->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0;">
                    <span style="color: #64748b; font-weight: 500;">Total Words</span>
                    <span style="font-weight: 600; color: #3b82f6;">{{ $recentStories->sum(function($story) { return str_word_count(strip_tags($story->generated_story)); }) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i class="fas fa-cogs"></i>
                System Status
            </h4>
        </div>
        <div class="card-body">
            <div style="space-y: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">AI Integration</span>
                    <span style="color: #22c55e; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                        <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%;"></div>
                        Active
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">Database</span>
                    <span style="color: #22c55e; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                        <div style="width: 8px; height: 8px; background: #22c55e; border-radius: 50%;"></div>
                        Connected
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0;">
                    <span style="color: #64748b; font-weight: 500;">Last Updated</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ now()->format('M d, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            <i class="fas fa-bolt"></i>
            Quick Actions
        </h4>
    </div>
    <div class="card-body">
        <div class="admin-grid-actions" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <a href="{{ route('admin.settings') }}" class="btn btn-primary" style="justify-content: center;">
                <i class="fas fa-robot"></i>
                Configure AI Settings
            </a>
            <a href="{{ route('admin.users') }}" class="btn btn-outline" style="justify-content: center;">
                <i class="fas fa-users"></i>
                Manage Users
            </a>
            <a href="{{ route('admin.stories') }}" class="btn btn-outline" style="justify-content: center;">
                <i class="fas fa-book-open"></i>
                Browse All Stories
            </a>
            <a href="{{ route('admin.stories.export-pdf') }}" class="btn btn-outline" style="justify-content: center;">
                <i class="fas fa-file-pdf"></i>
                Export Stories PDF
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline" style="justify-content: center;">
                <i class="fas fa-arrow-left"></i>
                Back to App
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewStory(storyId) {
    const stories = @json($recentStories);
    const story = stories.find(s => s.id === storyId);
    
    if (story) {
        Swal.fire({
            title: story.title,
            html: `
                <div style="text-align: left; max-height: 400px; overflow-y: auto;">
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                        <h6 style="color: #374151; margin-bottom: 8px; font-weight: 600;">User Prompt:</h6>
                        <p style="color: #6b7280; margin: 0; line-height: 1.6;">${story.user_prompt}</p>
                    </div>
                    <div style="background: #ffffff; padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <h6 style="color: #374151; margin-bottom: 8px; font-weight: 600;">Generated Story:</h6>
                        <div style="color: #1f2937; line-height: 1.6;">${story.generated_story}</div>
                    </div>
                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e2e8f0; text-align: center;">
                        <small style="color: #9ca3af;">
                            <strong>Created:</strong> ${new Date(story.created_at).toLocaleDateString()} at ${new Date(story.created_at).toLocaleTimeString()}
                        </small>
                    </div>
                </div>
            `,
            width: '600px',
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                popup: 'swal2-popup',
                title: 'swal2-title'
            }
        });
    }
}
</script>
@endsection
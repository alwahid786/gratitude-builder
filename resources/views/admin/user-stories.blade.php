@extends('admin.layout')

@section('title', 'User Stories')
@section('page-title', $user->name . ' Stories')

@section('content')
<!-- User Profile Header -->
<div class="card">
    <div class="card-body">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 24px; flex-shrink: 0;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div style="flex: 1;">
                <h2 style="margin: 0 0 8px 0; font-size: 24px; font-weight: 600; color: #1e293b;">{{ $user->name }}</h2>
                <div style="color: #64748b; font-size: 14px; margin-bottom: 8px;">{{ $user->email }}</div>
                <div style="display: flex; gap: 12px; align-items: center;">
                    @if($user->role === 'admin')
                        <span class="badge" style="background: #dc2626; color: white;">Administrator</span>
                    @else
                        <span class="badge" style="background: #6b7280; color: white;">User</span>
                    @endif
                    <span style="color: #64748b; font-size: 13px;">
                        Member since {{ $user->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
            <div style="text-align: right;">
                <a href="{{ route('admin.users') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Back to Users
                </a>
            </div>
        </div>
    </div>
</div>

<!-- User Stories -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-book-open"></i>
            Stories by {{ $user->name }}
        </h3>
        <span class="badge badge-blue">{{ $allStories->total() }} stories</span>
    </div>
    
    <div class="card-body" style="padding: 0;">
        @if($allStories->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Title</th>
                            <th>User Prompt</th>
                            <th style="width: 100px;">Words</th>
                            <th style="width: 120px;">Created</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allStories as $story)
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
                                    {{ Str::limit($story->user_prompt, 80) }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-green">
                                    {{ str_word_count(strip_tags($story->generated_story)) }}
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
                                    <i class="fas fa-eye" style="font-size: 12px;"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($allStories->hasPages())
                <div style="padding: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: center;">
                    {{ $allStories->links() }}
                </div>
            @endif
        @else
            <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                <i class="fas fa-book-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h4 style="color: #64748b; margin-bottom: 8px; font-weight: 600;">No Stories Yet</h4>
                <p style="color: #9ca3af; margin: 0;">{{ $user->name }} hasn't created any stories yet</p>
            </div>
        @endif
    </div>
</div>

<!-- User Stats -->
<div class="admin-grid-3" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px;">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i class="fas fa-chart-bar"></i>
                Story Statistics
            </h4>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">Total Stories</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $allStories->total() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">Total Words</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $allStories->sum(function($story) { return str_word_count(strip_tags($story->generated_story)); }) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                    <span style="color: #64748b; font-weight: 500;">Avg per Story</span>
                    <span style="font-weight: 600; color: #1e293b;">
                        {{ $allStories->count() > 0 ? round($allStories->sum(function($story) { return str_word_count(strip_tags($story->generated_story)); }) / $allStories->count()) : 0 }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i class="fas fa-calendar"></i>
                Activity Timeline
            </h4>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">First Story</span>
                    <span style="font-weight: 600; color: #1e293b;">
                        {{ $allStories->count() > 0 ? $allStories->sortBy('created_at')->first()->created_at->format('M d, Y') : 'N/A' }}
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">Latest Story</span>
                    <span style="font-weight: 600; color: #1e293b;">
                        {{ $allStories->count() > 0 ? $allStories->sortByDesc('created_at')->first()->created_at->format('M d, Y') : 'N/A' }}
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                    <span style="color: #64748b; font-weight: 500;">This Month</span>
                    <span style="font-weight: 600; color: #22c55e;">
                        {{ $allStories->where('created_at', '>=', now()->startOfMonth())->count() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i class="fas fa-user"></i>
                User Profile
            </h4>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">User ID</span>
                    <span style="font-weight: 600; color: #1e293b; font-family: monospace;">#{{ $user->id }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">Status</span>
                    @if($user->email_verified_at)
                        <span style="font-weight: 600; color: #22c55e;">✓ Verified</span>
                    @else
                        <span style="font-weight: 600; color: #f59e0b;">⚠ Unverified</span>
                    @endif
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                    <span style="color: #64748b; font-weight: 500;">Joined</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const storiesData = @json($allStories->items());

function viewStory(storyId) {
    const story = storiesData.find(s => s.id === storyId);
    
    if (story) {
        const wordCount = story.generated_story.trim().split(/\s+/).length;
        
        Swal.fire({
            title: story.title,
            html: `
                <div style="text-align: left; max-height: 500px; overflow-y: auto;">
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div>
                                <h6 style="color: #374151; margin-bottom: 4px; font-weight: 600; font-size: 12px;">STORY ID</h6>
                                <p style="color: #6b7280; margin: 0; font-family: monospace;">#${story.id}</p>
                            </div>
                            <div>
                                <h6 style="color: #374151; margin-bottom: 4px; font-weight: 600; font-size: 12px;">WORD COUNT</h6>
                                <p style="color: #6b7280; margin: 0;">${wordCount} words</p>
                            </div>
                        </div>
                        
                        <div>
                            <h6 style="color: #374151; margin-bottom: 8px; font-weight: 600; font-size: 12px;">CREATED</h6>
                            <p style="color: #6b7280; margin: 0; font-size: 13px;">${new Date(story.created_at).toLocaleDateString()} at ${new Date(story.created_at).toLocaleTimeString()}</p>
                        </div>
                    </div>
                    
                    <div style="background: #fef3c7; padding: 16px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid #f59e0b;">
                        <h6 style="color: #92400e; margin-bottom: 8px; font-weight: 600; font-size: 12px;">USER PROMPT</h6>
                        <p style="color: #78350f; margin: 0; line-height: 1.6;">${story.user_prompt}</p>
                    </div>
                    
                    <div style="background: #ffffff; padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <h6 style="color: #374151; margin-bottom: 12px; font-weight: 600; font-size: 12px;">GENERATED STORY</h6>
                        <div style="color: #1f2937; line-height: 1.7; text-align: justify;">${story.generated_story.replace(/\n/g, '<br>')}</div>
                    </div>
                </div>
            `,
            width: '700px',
            showCloseButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Close',
            confirmButtonColor: '#3b82f6',
            customClass: {
                popup: 'swal2-popup',
                title: 'swal2-title'
            }
        });
    }
}
</script>
@endsection
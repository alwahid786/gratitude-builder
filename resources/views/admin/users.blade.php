@extends('admin.layout')

@section('title', 'Users Management')
@section('page-title', 'User Management')

@section('content')
<!-- Header -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i>
            Registered Users
        </h3>
        <div style="display: flex; gap: 8px;">
            <span class="badge badge-blue">Total: {{ $users->total() }}</span>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($users->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>User</th>
                            <th>Email</th>
                            <th style="width: 80px;">Role</th>
                            <th style="width: 100px;">Stories</th>
                            <th style="width: 120px;">Registered</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <span class="badge badge-blue">#{{ $user->id }}</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; flex-shrink: 0;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #1e293b;">{{ $user->name }}</div>
                                        @if($user->role === 'admin')
                                            <div style="font-size: 11px; color: #dc2626; font-weight: 500;">Administrator</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="color: #64748b; font-size: 13px;">{{ $user->email }}</div>
                                @if($user->email_verified_at)
                                    <div style="font-size: 11px; color: #22c55e;">✓ Verified</div>
                                @else
                                    <div style="font-size: 11px; color: #f59e0b;">⚠ Unverified</div>
                                @endif
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge" style="background: #dc2626; color: white;">Admin</span>
                                @else
                                    <span class="badge" style="background: #6b7280; color: white;">User</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-green">{{ $user->gratitude_stories_count ?? 0 }}</span>
                            </td>
                            <td>
                                <div style="font-size: 13px; color: #64748b;">
                                    {{ $user->created_at->format('M d, Y') }}<br>
                                    <small style="color: #9ca3af;">{{ $user->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; gap: 4px;">
                                    <button type="button" 
                                            class="btn btn-outline btn-sm" 
                                            onclick="viewUser({{ $user->id }})" 
                                            title="View User Details">
                                        <i class="fas fa-eye" style="font-size: 12px;"></i>
                                    </button>
                                    @if($user->gratitude_stories_count > 0)
                                        <a href="{{ route('admin.users.stories', $user->id) }}" 
                                           class="btn btn-outline btn-sm" 
                                           title="View User Stories">
                                            <i class="fas fa-book" style="font-size: 12px;"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
                <div style="padding: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: center;">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                <i class="fas fa-users" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h4 style="color: #64748b; margin-bottom: 8px; font-weight: 600;">No Users Yet</h4>
                <p style="color: #9ca3af; margin: 0;">Registered users will appear here</p>
            </div>
        @endif
    </div>
</div>

<!-- User Stats Grid -->
<div class="admin-grid-3" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px;">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i class="fas fa-chart-bar"></i>
                User Statistics
            </h4>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">Total Users</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $users->total() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">Admins</span>
                    <span style="font-weight: 600; color: #dc2626;">{{ $users->where('role', 'admin')->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                    <span style="color: #64748b; font-weight: 500;">Regular Users</span>
                    <span style="font-weight: 600; color: #3b82f6;">{{ $users->where('role', '!=', 'admin')->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i class="fas fa-calendar"></i>
                Recent Activity
            </h4>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">Today</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $users->where('created_at', '>=', today())->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">This Week</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $users->where('created_at', '>=', now()->startOfWeek())->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                    <span style="color: #64748b; font-weight: 500;">This Month</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i class="fas fa-book-open"></i>
                Content Activity
            </h4>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">Active Writers</span>
                    <span style="font-weight: 600; color: #22c55e;">{{ $users->where('gratitude_stories_count', '>', 0)->count() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="color: #64748b; font-weight: 500;">Total Stories</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $users->sum('gratitude_stories_count') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0;">
                    <span style="color: #64748b; font-weight: 500;">Avg per User</span>
                    <span style="font-weight: 600; color: #1e293b;">{{ $users->count() > 0 ? round($users->sum('gratitude_stories_count') / $users->count(), 1) : 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const usersData = @json($users->items());

function viewUser(userId) {
    const user = usersData.find(u => u.id === userId);
    
    if (user) {
        const isAdmin = user.role === 'admin';
        const isVerified = user.email_verified_at;
        const storyCount = user.gratitude_stories_count || 0;
        
        Swal.fire({
            title: `${user.name}`,
            html: `
                <div style="text-align: left; max-height: 400px; overflow-y: auto;">
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div>
                                <h6 style="color: #374151; margin-bottom: 4px; font-weight: 600; font-size: 12px;">USER ID</h6>
                                <p style="color: #6b7280; margin: 0; font-family: monospace;">#${user.id}</p>
                            </div>
                            <div>
                                <h6 style="color: #374151; margin-bottom: 4px; font-weight: 600; font-size: 12px;">ROLE</h6>
                                <span style="background: ${isAdmin ? '#dc2626' : '#6b7280'}; color: white; padding: 2px 8px; border-radius: 4px; font-size: 11px;">
                                    ${isAdmin ? 'ADMIN' : 'USER'}
                                </span>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 16px;">
                            <h6 style="color: #374151; margin-bottom: 8px; font-weight: 600; font-size: 12px;">EMAIL ADDRESS</h6>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="color: #6b7280;">${user.email}</span>
                                <span style="color: ${isVerified ? '#22c55e' : '#f59e0b'}; font-size: 12px;">
                                    ${isVerified ? '✓ Verified' : '⚠ Unverified'}
                                </span>
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <h6 style="color: #374151; margin-bottom: 4px; font-weight: 600; font-size: 12px;">REGISTERED</h6>
                                <p style="color: #6b7280; margin: 0; font-size: 13px;">${new Date(user.created_at).toLocaleDateString()}</p>
                            </div>
                            <div>
                                <h6 style="color: #374151; margin-bottom: 4px; font-weight: 600; font-size: 12px;">STORIES CREATED</h6>
                                <p style="color: #6b7280; margin: 0; font-weight: 600;">${storyCount} stories</p>
                            </div>
                        </div>
                    </div>
                    
                    ${storyCount > 0 ? `
                        <div style="background: #f0fdf4; padding: 16px; border-radius: 8px; border-left: 4px solid #22c55e; text-align: center;">
                            <h6 style="color: #166534; margin-bottom: 8px; font-weight: 600;">Active Content Creator</h6>
                            <p style="color: #15803d; margin: 0; font-size: 13px;">This user has created ${storyCount} gratitude ${storyCount === 1 ? 'story' : 'stories'}</p>
                        </div>
                    ` : `
                        <div style="background: #f8fafc; padding: 16px; border-radius: 8px; border-left: 4px solid #64748b; text-align: center;">
                            <h6 style="color: #475569; margin-bottom: 8px; font-weight: 600;">New User</h6>
                            <p style="color: #64748b; margin: 0; font-size: 13px;">This user hasn't created any stories yet</p>
                        </div>
                    `}
                </div>
            `,
            width: '600px',
            showCloseButton: true,
            showConfirmButton: true,
            confirmButtonText: storyCount > 0 ? 'View Stories' : 'Close',
            confirmButtonColor: '#3b82f6',
            customClass: {
                popup: 'swal2-popup',
                title: 'swal2-title'
            }
        }).then((result) => {
            if (result.isConfirmed && storyCount > 0) {
                window.location.href = `{{ url('admin/users') }}/${user.id}/stories`;
            }
        });
    }
}
</script>
@endsection
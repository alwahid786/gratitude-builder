@extends('admin.layout')

@section('title', 'All Stories')
@section('page-title', 'Stories Management')

@section('content')
<!-- Header Actions -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-book-open"></i>
            All AI-Generated Stories
        </h3>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('admin.stories.export-pdf') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-file-pdf"></i>
                Export PDF
            </a>
        </div>
    </div>
    
    <!-- Search and Filters -->
    <div class="card-body" style="border-bottom: 1px solid #e2e8f0;">
        <div class="admin-grid-3" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Search Stories</label>
                <input type="text" class="form-input" placeholder="Search by title or content..." id="searchInput" onkeyup="searchStories()">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Sort By</label>
                <select class="form-select" id="sortBy" onchange="sortStories()">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="title">By Title</option>
                    <option value="words">By Word Count</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Show</label>
                <select class="form-select" id="showPerPage" onchange="filterStories()">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="all">Show All</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Stories Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        @if($stories->count() > 0)
            <div class="table-container">
                <table class="table" id="storiesTable">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Title</th>
                            <th>User Prompt</th>
                            <th style="width: 100px;">Words</th>
                            <th style="width: 120px;">Created</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stories as $story)
                        <tr data-story-id="{{ $story->id }}">
                            <td>
                                <span class="badge badge-blue">#{{ $story->id }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                    {{ Str::limit($story->title, 40) }}
                                </div>
                                @if($story->user)
                                    <div style="font-size: 11px; color: #64748b;">
                                        by {{ $story->user->name }}
                                    </div>
                                @endif
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
                                <div style="display: flex; gap: 4px;">
                                    <button type="button" 
                                            class="btn btn-outline btn-sm" 
                                            onclick="viewStory({{ $story->id }})" 
                                            title="View Story">
                                        <i class="fas fa-eye" style="font-size: 12px;"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.stories.delete', $story->id) }}" 
                                          style="display: inline;" 
                                          onsubmit="return confirmDelete('{{ $story->title }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline btn-sm" 
                                                title="Delete Story"
                                                style="color: #dc2626; border-color: #fecaca;">
                                            <i class="fas fa-trash" style="font-size: 12px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($stories->hasPages())
                <div style="padding: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: center;">
                    {{ $stories->links() }}
                </div>
            @endif
        @else
            <div style="text-align: center; padding: 60px 20px; color: #64748b;">
                <i class="fas fa-book-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                <h4 style="color: #64748b; margin-bottom: 8px; font-weight: 600;">No Stories Yet</h4>
                <p style="color: #9ca3af; margin: 0;">Stories will appear here once users start creating them</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
const storiesData = @json($stories->items());

function viewStory(storyId) {
    const story = storiesData.find(s => s.id === storyId);
    
    if (story) {
        const wordCount = story.generated_story.trim().split(/\s+/).length;
        const userName = story.user ? story.user.name : 'Unknown User';
        
        Swal.fire({
            title: story.title,
            html: `
                <div style="text-align: left; max-height: 500px; overflow-y: auto;">
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 12px;">
                            <div>
                                <h6 style="color: #374151; margin-bottom: 4px; font-weight: 600; font-size: 12px;">STORY ID</h6>
                                <p style="color: #6b7280; margin: 0; font-family: monospace;">#${story.id}</p>
                            </div>
                            <div>
                                <h6 style="color: #374151; margin-bottom: 4px; font-weight: 600; font-size: 12px;">AUTHOR</h6>
                                <p style="color: #6b7280; margin: 0;">${userName}</p>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div>
                                <h6 style="color: #374151; margin-bottom: 4px; font-weight: 600; font-size: 12px;">CREATED</h6>
                                <p style="color: #6b7280; margin: 0; font-size: 13px;">${new Date(story.created_at).toLocaleDateString()} at ${new Date(story.created_at).toLocaleTimeString()}</p>
                            </div>
                            <div>
                                <h6 style="color: #374151; margin-bottom: 4px; font-weight: 600; font-size: 12px;">WORD COUNT</h6>
                                <p style="color: #6b7280; margin: 0;">${wordCount} words</p>
                            </div>
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

function confirmDelete(storyTitle) {
    return confirm(`Are you sure you want to delete the story "${storyTitle}"? This action cannot be undone.`);
}

function searchStories() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#storiesTable tbody tr');
    
    let visibleCount = 0;
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const isVisible = text.includes(searchTerm);
        row.style.display = isVisible ? '' : 'none';
        if (isVisible) visibleCount++;
    });
    
    // Show/hide "no results" message
    updateNoResults(visibleCount === 0 && searchTerm !== '');
}

function sortStories() {
    const sortBy = document.getElementById('sortBy').value;
    const tbody = document.querySelector('#storiesTable tbody');
    const rows = Array.from(tbody.getElementsByTagName('tr'));
    
    rows.sort((a, b) => {
        let aVal, bVal;
        
        switch(sortBy) {
            case 'newest':
                aVal = new Date(a.cells[4].textContent.trim());
                bVal = new Date(b.cells[4].textContent.trim());
                return bVal - aVal;
            case 'oldest':
                aVal = new Date(a.cells[4].textContent.trim());
                bVal = new Date(b.cells[4].textContent.trim());
                return aVal - bVal;
            case 'title':
                aVal = a.cells[1].textContent.trim().toLowerCase();
                bVal = b.cells[1].textContent.trim().toLowerCase();
                return aVal.localeCompare(bVal);
            case 'words':
                aVal = parseInt(a.cells[3].textContent.trim());
                bVal = parseInt(b.cells[3].textContent.trim());
                return bVal - aVal;
            default:
                return 0;
        }
    });
    
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
}

function filterStories() {
    const showPerPage = document.getElementById('showPerPage').value;
    const rows = document.querySelectorAll('#storiesTable tbody tr');
    
    if (showPerPage === 'all') {
        rows.forEach(row => row.style.display = '');
    } else {
        const limit = parseInt(showPerPage);
        rows.forEach((row, index) => {
            row.style.display = index < limit ? '' : 'none';
        });
    }
}

function updateNoResults(show) {
    const tbody = document.querySelector('#storiesTable tbody');
    let noResultsRow = document.getElementById('noResultsRow');
    
    if (show && !noResultsRow) {
        noResultsRow = document.createElement('tr');
        noResultsRow.id = 'noResultsRow';
        noResultsRow.innerHTML = `
            <td colspan="6" style="text-align: center; padding: 40px; color: #9ca3af;">
                <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 12px; display: block;"></i>
                No stories match your search criteria
            </td>
        `;
        tbody.appendChild(noResultsRow);
    } else if (!show && noResultsRow) {
        noResultsRow.remove();
    }
}
</script>
@endsection
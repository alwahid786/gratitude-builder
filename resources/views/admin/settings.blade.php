{{-- new code - Beautiful AI Settings --}}
@extends('admin.layout')

@section('title', 'AI Settings')
@section('page-title', 'AI Configuration')

@section('content')
<!-- Main Settings Form -->
<div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-robot"></i>
                OpenAI Configuration
            </h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf
                @method('PUT')

                <!-- Model and Settings Row -->
                <div class="admin-grid-3" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div>
                        <label class="form-label">OpenAI Model</label>
                        <select class="form-select @error('openai_model') border-red-300 @enderror" 
                                name="openai_model" required>
                            <option value="gpt-3.5-turbo" {{ ($aiSettings['openai_model']->value ?? '') == 'gpt-3.5-turbo' ? 'selected' : '' }}>GPT-3.5 Turbo</option>
                            <option value="gpt-4" {{ ($aiSettings['openai_model']->value ?? '') == 'gpt-4' ? 'selected' : '' }}>GPT-4</option>
                            <option value="gpt-4-turbo" {{ ($aiSettings['openai_model']->value ?? '') == 'gpt-4-turbo' ? 'selected' : '' }}>GPT-4 Turbo</option>
                        </select>
                        @error('openai_model')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="form-label">Max Tokens</label>
                        <input type="number" 
                               class="form-input @error('max_tokens') border-red-300 @enderror" 
                               name="max_tokens" 
                               min="1" max="4000"
                               value="{{ $aiSettings['max_tokens']->value ?? '1000' }}" 
                               required>
                        @error('max_tokens')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="form-label">Temperature</label>
                        <input type="number" 
                               class="form-input @error('temperature') border-red-300 @enderror" 
                               name="temperature" 
                               min="0" max="2" step="0.1"
                               value="{{ $aiSettings['temperature']->value ?? '0.7' }}" 
                               required>
                        @error('temperature')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Prompts Section -->
                <div style="border-top: 1px solid #e2e8f0; margin: 32px 0 24px; padding-top: 24px;">
                    <h4 style="font-size: 16px; font-weight: 600; color: #1e293b; margin-bottom: 20px;">
                        <i class="fas fa-comments" style="color: #3b82f6; margin-right: 8px;"></i>
                        AI Prompts Configuration
                    </h4>
                </div>

                {{-- UNUSED: Story generation prompt - only review is supported --}}
                {{-- <div class="form-group">
                    <label class="form-label">Story Generation System Prompt</label>
                    <textarea class="form-textarea @error('story_generation_prompt') border-red-300 @enderror" 
                              name="story_generation_prompt" 
                              rows="4" required>{{ $aiSettings['story_generation_prompt']->value ?? '' }}</textarea>
                    @error('story_generation_prompt')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-help">System prompt used for generating gratitude stories</div>
                </div> --}}

                <div class="form-group">
                    <label class="form-label">AI Review Prompt</label>
                    <textarea class="form-textarea @error('ai_review_prompt') border-red-300 @enderror" 
                              name="ai_review_prompt" 
                              rows="5" required>{{ $aiSettings['ai_review_prompt']->value ?? '' }}</textarea>
                    @error('ai_review_prompt')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Prompt used for AI content review functionality</div>
                </div>

                {{-- UNUSED: Story completion prompt - only review is supported --}}
                {{-- <div class="form-group">
                    <label class="form-label">Story Completion Prompt Template</label>
                    <textarea class="form-textarea @error('completion_prompt') border-red-300 @enderror" 
                              name="completion_prompt" 
                              rows="3" required>{{ $aiSettings['completion_prompt']->value ?? '' }}</textarea>
                    @error('completion_prompt')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Template for story completion prompts. Use {prompt} placeholder for user input</div>
                </div> --}}

                <!-- Default Story Section -->
                <div style="border-top: 1px solid #e2e8f0; margin: 32px 0 24px; padding-top: 24px;">
                    <h4 style="font-size: 16px; font-weight: 600; color: #1e293b; margin-bottom: 20px;">
                        <i class="fas fa-book-open" style="color: #3b82f6; margin-right: 8px;"></i>
                        Default Story Configuration
                    </h4>
                </div>

                <div class="form-group">
                    <label class="form-label">Default Story Title</label>
                    <input type="text" 
                           class="form-input @error('default_story_title') border-red-300 @enderror" 
                           name="default_story_title" 
                           value="{{ $generalSettings['default_story_title']->value ?? 'Your Gratitude Story' }}" 
                           required>
                    @error('default_story_title')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Title displayed on the main page story container</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Default Story Content</label>
                    <textarea class="form-textarea @error('default_story_content') border-red-300 @enderror" 
                              name="default_story_content" 
                              rows="10" required>{{ $generalSettings['default_story_content']->value ?? '' }}</textarea>
                    @error('default_story_content')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-help">Default story content shown to users before they generate their own story. HTML tags are supported.</div>
                </div>

                <!-- Submit Button -->
                <div style="display: flex; justify-content: flex-end; padding-top: 24px; border-top: 1px solid #e2e8f0;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Configuration
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


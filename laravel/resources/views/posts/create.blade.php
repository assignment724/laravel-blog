<x-app-layout>
    <style>
        .form-container {
            background: linear-gradient(to right, #f8fafc, #f1f5f9);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .form-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .input-field {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .file-upload-container {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .file-upload-container:hover {
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.05);
        }
        
        .file-upload-input {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
        
        .file-upload-icon {
            width: 48px;
            height: 48px;
            color: #64748b;
        }
        
        .tag-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.75rem;
        }
        
        .tag-checkbox {
            display: none;
        }
        
        .tag-label {
            display: block;
            padding: 0.5rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }
        
        .tag-checkbox:checked + .tag-label {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }
        
        .submit-button {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .submit-button:hover {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-style: italic;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="form-container">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="form-card">
                <div class="p-8">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                                Title
                            </label>
                            <input type="text" name="title" id="title" 
                                   class="input-field @error('title') border-red-500 @enderror"
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Category
                            </label>
                            <select name="category_id" id="category_id" 
                                    class="input-field @error('category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">
                                Post Image
                            </label>
                            <div class="file-upload-container">
                                <input type="file" name="image" id="image" class="file-upload-input" accept="image/*">
                                <div class="file-upload-label">
                                    <svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-gray-600">Click or drag to upload an image</span>
                                    <span class="text-sm text-gray-500">Supports JPG, PNG, GIF up to 5MB</span>
                                </div>
                            </div>
                            @error('image')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">
                                Content
                            </label>
                            <textarea name="content" id="content" rows="10"
                                      class="input-field @error('content') border-red-500 @enderror"
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tags
                            </label>
                            <div class="tag-container">
                                @foreach($tags as $tag)
                                    <div>
                                        <input type="checkbox" 
                                               id="tag-{{ $tag->id }}"
                                               name="tags[]" 
                                               value="{{ $tag->id }}"
                                               class="tag-checkbox">
                                        <label for="tag-{{ $tag->id }}" class="tag-label">
                                            {{ $tag->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('tags')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="submit-button">
                                Create Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-label for="title" :value="__('Title')" class="text-gray-700 font-semibold" />
                            <x-input id="title" 
                                class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200" 
                                type="text" 
                                name="title" 
                                :value="old('title', $post->title)" 
                                required />
                            @error('title')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="category_id" :value="__('Category')" class="text-gray-700 font-semibold" />
                            <select id="category_id" 
                                name="category_id" 
                                class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200" 
                                required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="tags" :value="__('Tags')" class="text-gray-700 font-semibold" />
                            <select id="tags" 
                                name="tags[]" 
                                multiple 
                                class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 min-h-[120px]">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" 
                                        {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tags')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            @if($post->image_path)
                                <div class="relative group">
                                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-100">
                                        <img src="{{ asset('storage/' . $post->image_path) }}" 
                                            alt="Post image" 
                                            class="object-cover w-full h-full group-hover:opacity-90 transition-opacity duration-300">
                                    </div>
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300 flex items-center justify-center">
                                        <span class="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            Current Image
                                        </span>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-4">
                                <x-label for="image" :value="__('Update Image')" class="text-gray-700 font-semibold" />
                                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors duration-300">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                                                stroke-width="2" 
                                                stroke-linecap="round" 
                                                stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload a file</span>
                                                <input id="image" name="image" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                                @error('image')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <x-label for="content" :value="__('Content')" class="text-gray-700 font-semibold" />
                            <textarea id="content" 
                                name="content" 
                                rows="10"
                                class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 resize-y"
                                required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:scale-105">
                                {{ __('Update Post') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
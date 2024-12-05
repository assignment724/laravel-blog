<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories') }}
            </h2>
            @if(auth()->user()?->role === 'admin')
                <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Category
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($categories as $category)
                            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                                <h3 class="text-xl font-semibold mb-2">
                                    <a href="{{ route('categories.show', $category) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $category->name }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-4">{{ $category->posts_count }} posts</p>
                                @if(auth()->user()?->role === 'admin')
                                    <div class="flex space-x-2">
                                        <a href="{{ route('categories.edit', $category) }}" 
                                           class="text-yellow-600 hover:text-yellow-800">Edit</a>
                                        <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800"
                                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
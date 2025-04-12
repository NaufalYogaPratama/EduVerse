<x-app-layout>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight mb-6 text-center justify-center">
                    {{ __('Edit Material') }}
                </h2>
                <form method="POST" action="{{ route('materials.update', $material) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $material->title) }}" required
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Description</label>
                        <textarea id="description" name="description" rows="4" required
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600">{{ old('description', $material->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- File Upload -->
                    <div class="mb-6">
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">File (PDF, DOC, JPG, PNG) - Leave blank to keep existing</label>
                        <input type="file" id="file" name="file" accept=".pdf,.doc,.docx,.jpg,.png"
                            class="w-full px-4 py-2 border rounded-md shadow-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600" />
                        @if($material->file_path)
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Current file: 
                                <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="text-blue-500 underline">Download</a>
                            </p>
                        @endif
                        <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    </div>

                    <!-- Course Name -->
                    <div class="mb-6">
                        <label for="course_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Course Name</label>
                        <input type="text" id="course_name" name="course_name" value="{{ old('course_name', $material->courses->first()->course_name ?? '') }}" required
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600" />
                        <x-input-error :messages="$errors->get('course_name')" class="mt-2" />
                    </div>

                    <!-- Semester -->
                    <div class="mb-6">
                        <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Semester</label>
                        <input type="text" id="semester" name="semester" value="{{ old('semester', $material->courses->first()->semester ?? '') }}" required
                            class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-600" />
                        <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('dashboard') }}"
                           class="px-6 py-2 text-sm font-semibold rounded-md shadow-sm bg-gray-300 hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 text-black dark:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Cancel
                        </a>
                        <x-primary-button class="px-6 py-2 text-sm font-semibold rounded-md shadow-sm bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-white dark:bg-indigo-500 dark:hover:bg-indigo-600">
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

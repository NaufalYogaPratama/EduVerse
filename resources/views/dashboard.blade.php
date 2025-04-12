<x-app-layout>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-800">
                    
                    <!-- Navbar -->
                    <nav class="flex items-center justify-between bg-amber-300 p-4 rounded-lg mb-6 shadow-md">
                        <div class="flex items-center">
                            <a class="text-lg font-semibold tracking-tight text-gray-800" href="#">EduVerse Dashboard</a>
                        </div>
                        <div class="flex items-center space-x-4">
                            <form class="flex items-center" method="GET" action="{{ route('dashboard') }}">
                                <input class="rounded-l-md border border-gray-300 px-3 py-1 bg-white text-gray-800 placeholder-gray-500 focus:ring-amber-400 focus:border-amber-400 transition-all" type="search" name="search" placeholder="Search materials..." value="{{ request('search') }}">
                                <button class="bg-white hover:bg-amber-400 text-gray-800 px-4 py-2 rounded-r-md border border-gray-300 transition-colors duration-200" type="submit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </form>
                        </div>
                    </nav>

                    <!-- Materials Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800"></h1>
                        @if(auth()->user()->role == 'mahasiswa')
                            <a href="{{ route('materials.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-400 text-gray-800 rounded-md shadow-sm transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Upload Material
                            </a>
                        @endif
                    </div>

                    @if($materials->isEmpty())
                        <div class="text-center py-8 text-gray-800">
                            <p>No materials found. Start by uploading one!</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-800 uppercase text-xs font-semibold tracking-wider">
                                        <th class="p-3 text-center">Title</th>
                                        <th class="p-3 text-center">Uploader</th>
                                        <th class="p-3 text-center">Course</th>
                                        <th class="p-3 text-center">Semester</th>
                                        <th class="p-3 text-center">File</th>
                                        <th class="p-3 text-center">Approved</th>
                                        <th class="p-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materials as $material)
                                        <tr class="border-b hover:bg-amber-50 transition-colors duration-150">
                                            <td class="p-3 text-center text-gray-800">{{ $material->title }}</td>
                                            <td class="p-3 text-center text-gray-800">{{ $material->user->name }}</td>
                                            <td class="p-3 text-center text-gray-800">{{ $material->courses->first()->course_name ?? '-' }}</td>
                                            <td class="p-3 text-center text-gray-800">{{ $material->courses->first()->semester ?? '-' }}</td>
                                            <td class="p-3 text-center">
                                                @if($material->file_path)
                                                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="text-amber-600 hover:underline">Download</a>
                                                @else
                                                    <span class="text-gray-600">-</span>
                                                @endif
                                            </td>
                                            <td class="p-3 text-center">
                                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $material->approved ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                    {{ $material->approved ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td class="p-3 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    @if(auth()->user()->role == 'mahasiswa' && $material->user_id == auth()->id())
                                                        <a href="{{ route('materials.edit', $material) }}" class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-gray-800 rounded-md text-sm">Edit</a>
                                                        <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline-flex">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="px-3 py-1 bg-red-400 hover:bg-red-500 text-gray-800 rounded-md text-sm" onclick="return confirm('Are you sure you want to soft delete this material?')">Delete</button>
                                                        </form>
                                                    @endif
                                                    @if(auth()->user()->role == 'dosen' && !$material->approved)
                                                        <form action="{{ route('materials.approve', $material) }}" method="POST" class="inline-flex">
                                                            @csrf
                                                            <button type="submit" class="px-3 py-1 bg-green-400 hover:bg-green-500 text-gray-800 rounded-md text-sm">Approve</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

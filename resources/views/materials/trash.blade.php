<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6 text-gray-800">

                    <!-- Navbar -->
                    <nav class="flex items-center justify-between bg-amber-300 p-4 rounded-lg mb-6 shadow-md">
                        <div class="flex items-center">
                            <a class="text-lg font-semibold tracking-tight text-gray-800" href="#">Trash Materials</a>
                        </div>
                        {{-- <div class="flex items-center space-x-4">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-800 hover:underline">Back to Dashboard</a>
                        </div> --}}
                    </nav>

                    <!-- Heading -->
                    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Deleted Materials</h1>

                    <!-- Alerts -->
                    @if (session('success'))
                        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Table or Empty -->
                    @if($materials->isEmpty())
                        <div class="text-center py-8 text-gray-800">
                            <p>No deleted materials found.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-800 uppercase text-xs font-semibold tracking-wider">
                                        <th class="p-3 text-left">Title</th>
                                        <th class="p-3 text-left">Uploader</th>
                                        <th class="p-3 text-left">Course</th>
                                        <th class="p-3 text-left">Semester</th>
                                        <th class="p-3 text-left">File</th>
                                        <th class="p-3 text-left">Deleted At</th>
                                        <th class="p-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($materials as $material)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="p-3">{{ $material->title }}</td>
                                            <td class="p-3">{{ $material->user->name }}</td>
                                            <td class="p-3">{{ $material->courses->first()->course_name ?? '-' }}</td>
                                            <td class="p-3">{{ $material->courses->first()->semester ?? '-' }}</td>
                                            <td class="p-3">
                                                @if($material->file_path && \Storage::disk('public')->exists($material->file_path))
                                                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Download</a>
                                                @else
                                                    <span class="text-gray-500">-</span>
                                                @endif
                                            </td>
                                            <td class="p-3">{{ $material->deleted_at->format('Y-m-d H:i:s') }}</td>
                                            <td class="p-3 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <form action="{{ route('materials.restore', $material) }}" method="POST" class="inline-flex">
                                                        @csrf
                                                        <button type="submit" class="font-semibold px-3 py-1 bg-amber-200 hover:bg-amber-400 text-gray-800 rounded-md text-sm" onclick="return confirm('Are you sure you want to restore this material?')">Restore</button>
                                                    </form>
                                                    <form action="{{ route('materials.forceDelete', $material) }}" method="POST" class="inline-flex">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="font-semibold px-3 py-1 bg-red-400 hover:bg-red-500 text-gray-800 rounded-md text-sm" onclick="return confirm('Are you sure you want to permanently delete this material?')">Force Delete</button>
                                                    </form>
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

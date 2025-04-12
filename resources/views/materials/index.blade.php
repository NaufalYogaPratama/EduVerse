<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">EduVerse</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('materials.index') }}">Materials</a></li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="GET">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search materials">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container">
    <h1>Materials</h1>
    @if(auth()->user()->role == 'mahasiswa')
        <a href="{{ route('materials.create') }}" class="btn btn-primary">Upload Material</a>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Uploader</th>
                <th>Course</th>
                <th>Approved</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
            <tr>
                <td>{{ $material->title }}</td>
                <td>{{ $material->user->name }}</td>
                <td>{{ $material->courses->first()->course_name ?? '-' }}</td>
                <td>{{ $material->approved ? 'Yes' : 'No' }}</td>
                <td>
                    @if(auth()->user()->role == 'mahasiswa' && $material->user_id == auth()->id())
                        <a href="{{ route('materials.edit', $material) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('materials.destroy', $material) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif
                    @if(auth()->user()->role == 'dosen' && !$material->approved)
                        <form action="{{ route('materials.approve', $material) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
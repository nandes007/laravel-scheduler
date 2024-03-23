@extends('components.layout')
@section('content')
<div class="home">
    <div class="card">
        <h2>Total Users: {{ $total_users }}</h2>
    </div>

    <div class="search-form">
        <form id="searchForm" action="{{ route('home') }}" method="GET">
            <input type="text" id="name" name="name" placeholder="Type Name" value="{{ request('name') }}">
            <input type="number" id="age" name="age" placeholder="Type Age" value="{{ request('age') }}">
            <select name="gender">
                <option value="" selected>Select Gender</option>
                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            <input type="date" id="dateInput" name="date" placeholder="Type Date" value="{{ request('date') }}">
            <button type="submit">Search</button>
            <button type="button" id="clearButton">Clear</button>
        </form>
    </div>

    <h2>User List</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->age }}</td>
                <td>{{ $user->gender }}</td>
                <td>{{ $user->created_at }}</td>
                <td class="actions">
                    <form action="{{ route('users.destroy', ['uuid' => $user->uuid]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- <div class="pagination">
        {!! $users->appends($_GET)->links() !!}
    </div> -->
    <div class="pagination">
        <ul class="pagination-list">
            @if ($users->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a href="{{ $users->appends(request()->query())->previousPageUrl() }}" class="page-link" rel="prev">&laquo;</a></li>
            @endif

            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                @if ($page == $users->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($users->hasMorePages())
                <li class="page-item"><a href="{{ $users->appends(request()->query())->nextPageUrl() }}" class="page-link" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.getElementById('clearButton').addEventListener('click', function() {
            document.getElementById('searchForm').reset();
            document.getElementById('age').value = '';
            document.getElementById('name').value = '';
            document.getElementById('dateInput').value = '';
            document.querySelector('select[name="gender"]').selectedIndex = 0;
            });
    </script>
@endpush
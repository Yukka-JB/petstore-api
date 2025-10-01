@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Pet Details</h2>

    <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-warning mb-3">Edit Pet</a>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $pet['id'] }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $pet['name'] }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ json_encode($pet['category']) }}</td>
        </tr>
        <tr>
            <th>Photo URLs</th>
            <td>
                @foreach($pet['photoUrls'] as $url)
                    <a href="{{ $url }}" target="_blank">{{ $url }}</a><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Tags</th>
            <td>{{ json_encode($pet['tags']) }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $pet['status'] }}</td>
        </tr>
    </table>

    <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Pet</button>
    </form>
</div>
@endsection

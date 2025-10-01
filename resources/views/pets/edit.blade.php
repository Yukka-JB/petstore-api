@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Pet</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pets.update', $pet['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id" class="form-label">Pet ID</label>
            <input type="number" name="id" id="id" class="form-control" value="{{ $pet['id'] }}" readonly>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Pet Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $pet['name']) }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category (JSON format)</label>
            <textarea name="category" id="category" class="form-control" rows="2">{{ old('category', json_encode($pet['category'])) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="photoUrls" class="form-label">Photo URLs (JSON array)</label>
            <textarea name="photoUrls" id="photoUrls" class="form-control" rows="2">{{ old('photoUrls', json_encode($pet['photoUrls'])) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Tags (JSON array)</label>
            <textarea name="tags" id="tags" class="form-control" rows="2">{{ old('tags', json_encode($pet['tags'])) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="available" {{ (old('status', $pet['status']) == 'available') ? 'selected' : '' }}>Available</option>
                <option value="pending" {{ (old('status', $pet['status']) == 'pending') ? 'selected' : '' }}>Pending</option>
                <option value="sold" {{ (old('status', $pet['status']) == 'sold') ? 'selected' : '' }}>Sold</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Pet</button>
    </form>
</div>
@endsection

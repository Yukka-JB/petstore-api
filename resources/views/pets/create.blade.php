@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add New Pet</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pets.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id" class="form-label">Pet ID</label>
            <input type="number" name="id" id="id" class="form-control" value="{{ old('id') }}" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Pet Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category (JSON format)</label>
            <textarea name="category" id="category" class="form-control" rows="2" placeholder='{"id":1,"name":"Dogs"}'>{{ old('category', '{"id":1,"name":"Dogs"}') }}</textarea>
            <small class="form-text text-muted">Example: {"id":1,"name":"Dogs"}</small>
        </div>

        <div class="mb-3">
            <label for="photoUrls" class="form-label">Photo URLs (JSON array)</label>
            <textarea name="photoUrls" id="photoUrls" class="form-control" rows="2" placeholder='["https://example.com/dog1.jpg"]'>{{ old('photoUrls', '["https://example.com/dog1.jpg"]') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Tags (JSON array)</label>
            <textarea name="tags" id="tags" class="form-control" rows="2" placeholder='[{"id":1,"name":"tag1"}]'>{{ old('tags', '[{"id":1,"name":"tag1"}]') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Pet</button>
    </form>
</div>
@endsection

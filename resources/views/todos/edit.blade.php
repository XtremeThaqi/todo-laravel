@extends('layout')

@section('content')
    <link href="{{ asset('css/edit.css') }}" rel="stylesheet">
    <h2>Edit Todo</h2>

    <form action="{{ route('todos.update', $todo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $todo->title) }}" required>
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="5">{{ old('description', $todo->description) }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group checkbox-group">
            <label class="completed-checkbox">
                <input type="checkbox" name="completed" value="1" {{ $todo->completed ? 'checked' : '' }}>
                <span class="checkmark"></span>
                Mark as completed
            </label>
        </div>

        <button type="submit" class="btn">Update Todo</button>
    </form>

    <a href="{{ route('todos.index') }}" class="btn back-btn">Back to List</a>
@endsection

@section('scripts')
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showSuccessAlert('{{ session('success') }}');
            });
        </script>
    @endif
@endsection
@extends('layout')

@section('content')
<link href="{{ asset('css/create.css') }}" rel="stylesheet">

<div class="create-container">
    <h1 class="create-title">Add New Todo</h1>

    <form method="POST" action="{{ route('todos.store') }}" class="create-form">
        @csrf
        
        <div class="form-group">
            <input 
                type="text" 
                name="title" 
                placeholder="Title" 
                value="{{ old('title') }}"
                required
                class="form-input"
            >
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <textarea 
                name="description" 
                placeholder="Description"
                class="form-textarea"
                rows="5"
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-btn">Add Todo</button>
            <a href="{{ route('todos.index') }}" class="cancel-btn">Back to List</a>
        </div>
    </form>
</div>
@endsection
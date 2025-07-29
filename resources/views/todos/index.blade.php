@extends('layout')

@section('content')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">

    <a href="{{ route('todos.create') }}" class="add-todo-btn">+ Add New Todo</a>

    @if($todos->count())
        <div class="todo-list">
            @foreach($todos as $todo)
                <div class="todo {{ $todo->completed ? 'completed' : '' }}" id="todo-{{ $todo->id }}">
                    <!-- Checkbox -->
                    <div class="todo-checkbox">
                        <input type="checkbox" id="checkbox-{{ $todo->id }}" {{ $todo->completed ? 'checked' : '' }}
                            onchange="toggleTodo({{ $todo->id }})">
                    </div>

                    <!-- Content -->
                    <div class="todo-content">
                        <span class="todo-title" id="title-{{ $todo->id }}">
                            {{ $todo->title }}
                        </span>
                        @if($todo->description)
                            <p class="todo-description">
                                {{ $todo->description }}
                            </p>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="todo-actions">
                        <a href="{{ route('todos.edit', $todo->id) }}" class="edit-btn">
                            Edit
                        </a>
                        <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="no-todos-message">
            No todos found. <a href="{{ route('todos.create') }}" class="no-todos-link">Create your first todo</a>.
        </p>
    @endif
@endsection

@section('scripts')
    <script>
        // Initialize checkboxes
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.todo-checkbox input[type="checkbox"]').forEach(checkbox => {
                const todoId = checkbox.id.replace('checkbox-', '');
                const todoItem = document.getElementById(`todo-${todoId}`);
                if (checkbox.checked) {
                    todoItem.classList.add('completed');
                }
            });

            // Attach delete handlers
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    confirmDelete(this);
                });
            });
        });

        function toggleTodo(todoId) {
            const checkbox = document.getElementById(`checkbox-${todoId}`);
            const title = document.getElementById(`title-${todoId}`);
            const isCompleted = checkbox.checked;

            // Immediately update UI
            checkbox.disabled = true;  // Prevent multiple clicks
            title.classList.toggle('completed', isCompleted);

            // Send AJAX request
            fetch(`/todos/${todoId}/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        // Revert if server reports failure
                        checkbox.checked = !isCompleted;
                        title.classList.toggle('completed', !isCompleted);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Revert on error
                    checkbox.checked = !isCompleted;
                    title.classList.toggle('completed', !isCompleted);
                })
                .finally(() => {
                    checkbox.disabled = false;
                });
        }
    </script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showSuccessAlert('{{ session('success') }}');
            });
        </script>
    @endif
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление пользователями</h1>

    <div class="card mb-4">
        <div class="card-header">Действия</div>
        <div class="card-body">
            <button id="remove-all-users" class="btn btn-danger">Удалить всех пользователей</button>
            <div id="result-message" class="mt-3"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Список пользователей</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Активирован</th>
                        <th>Дата регистрации</th>
                    </tr>
                </thead>
                <tbody id="users-table-body">
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->is_active ? 'Да' : 'Нет' }}</td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const removeAllBtn = document.getElementById('remove-all-users');
        const resultMessage = document.getElementById('result-message');

        if (removeAllBtn) {
            removeAllBtn.addEventListener('click', function () {
                if (confirm('Вы уверены, что хотите удалить ВСЕХ пользователей, кроме вас? Это действие нельзя отменить!')) {
                    fetch('{{ route("admin.users.remove-all") }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            resultMessage.innerHTML = `<div class="alert alert-${data.success ? 'success' : 'danger'}">${data.message}</div>`;

                            // Если успешно удалены, обновляем страницу через 2 секунды
                            if (data.success) {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            }
                        })
                        .catch(error => {
                            resultMessage.innerHTML = '<div class="alert alert-danger">Произошла ошибка при удалении пользователей</div>';
                            console.error('Error:', error);
                        });
                }
            });
        }
    });
</script>
@endsection
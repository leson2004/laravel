@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-info text-white text-center">
                    <h4 class="mb-0">👤 Thông tin người dùng</h4>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>ID:</strong> {{ $user->id }}
                        </li>
                        <li class="list-group-item">
                            <strong>Tên:</strong> {{ $user->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Email:</strong> {{ $user->email }}
                        </li>
                        <li class="list-group-item">
                            <strong>Vai trò:</strong> 
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Quản trị</span>
                            @else
                                <span class="badge bg-secondary">Người dùng</span>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4">
                        ⬅ Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

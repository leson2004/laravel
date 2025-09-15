@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-warning text-dark text-center">
                    <h4 class="mb-0">✏️ Chỉnh sửa người dùng</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Nhập tên" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Nhập email" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Vai trò</label>
                            <select name="role" class="form-select" required>
                                <option value="" disabled>-- Chọn vai trò --</option>
                                <option value="user" @selected($user->role === 'user')>👤 Người dùng</option>
                                <option value="admin" @selected($user->role === 'admin')>⚙️ Quản trị</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4">
                                ⬅ Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                💾 Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

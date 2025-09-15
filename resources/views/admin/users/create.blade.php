@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">➕ Thêm người dùng</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên người dùng" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Vai trò</label>
                            <select name="role" class="form-select" required>
                                <option value="" selected disabled>-- Chọn vai trò --</option>
                                <option value="user">👤 Người dùng</option>
                                <option value="admin">⚙️ Quản trị</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4">
                                ⬅ Quay lại
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                💾 Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

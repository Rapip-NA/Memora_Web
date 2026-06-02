@extends('layouts.desktop')

@section('content')
<style>
    .users-wrapper {
        padding: 40px;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        color: var(--text-dark);
    }
    
    .users-header {
        margin-bottom: 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .users-header h2 {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .users-header p {
        color: var(--text-muted);
        margin: 0;
        font-size: 15px;
    }

    .filter-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        align-items: flex-end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        background: var(--bg-main);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 10px 16px;
        color: var(--text-dark);
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: all 0.2s;
        width: 100%;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(29, 155, 240, 0.1);
    }

    .btn-filter-group {
        display: flex;
        gap: 12px;
    }

    .btn-action {
        border: none;
        padding: 11px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        font-family: inherit;
        text-decoration: none;
    }

    .btn-submit {
        background: var(--primary);
        color: white;
        flex: 1;
    }

    .btn-submit:hover {
        background: var(--primary-hover, #1a8cd8);
        transform: translateY(-2px);
    }

    .btn-reset {
        background: var(--bg-main);
        color: var(--text-dark);
        border: 1px solid var(--border-color);
    }

    .btn-reset:hover {
        background: var(--border-color);
    }
    
    .users-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }
    
    .users-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    
    .users-table th {
        background: var(--bg-main);
        padding: 16px 24px;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border-color);
    }
    
    .users-table td {
        padding: 16px 24px;
        font-size: 15px;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }
    
    .users-table tr:last-child td {
        border-bottom: none;
    }
    
    .user-info-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--border-color);
        object-fit: cover;
        border: 1px solid var(--border-color);
    }
    
    .user-details h4 {
        margin: 0;
        font-weight: 700;
        color: var(--text-dark);
    }
    
    .user-details p {
        margin: 2px 0 0 0;
        font-size: 13px;
        color: var(--text-muted);
    }

    .user-badge {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .user-badge-class {
        background: rgba(29, 155, 240, 0.1);
        color: var(--primary);
        border: 1px solid rgba(29, 155, 240, 0.2);
    }

    .user-badge-role-admin {
        background: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
        border: 1px solid rgba(139, 92, 246, 0.2);
    }

    .user-badge-role-user {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .user-badge-status-active {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .user-badge-status-pending {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .user-badge-status-inactive {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 40px;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(29, 155, 240, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 24px;
    }
    
    .empty-state h3 {
        margin: 0 0 8px 0;
        font-size: 20px;
        font-weight: 700;
        color: var(--text-dark);
    }
    
    .empty-state p {
        margin: 0;
        color: var(--text-muted);
        font-size: 15px;
    }
    
    .pagination-container {
        padding: 20px 24px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<div class="users-wrapper">
    <div class="users-header">
        <div>
            <h2><i class='bx bx-group' style="color: var(--primary);"></i> Daftar Anggota</h2>
            <p>Kelola dan pantau seluruh akun alumni dan administrator di platform ini.</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <form action="{{ route('admin.users') }}" method="GET" class="filter-form">
            <div class="form-group" style="grid-column: span 2;">
                <label for="search">Cari Anggota</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama, email, atau username..." class="form-control">
            </div>

            <div class="form-group">
                <label for="classroom_id">Kelas</label>
                <select name="classroom_id" id="classroom_id" class="form-control">
                    <option value="">Semua Kelas</option>
                    @foreach($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ request('classroom_id') == $cls->id ? 'selected' : '' }}>
                            {{ $cls->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="role">Kategori User</label>
                <select name="role" id="role" class="form-control">
                    <option value="">Semua Kategori</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator (Admin)</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Alumni (User)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Validasi</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Ditolak / Nonaktif</option>
                </select>
            </div>

            <div class="btn-filter-group">
                <button type="submit" class="btn-action btn-submit">
                    <i class='bx bx-filter-alt'></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'classroom_id', 'role', 'status']))
                    <a href="{{ route('admin.users') }}" class="btn-action btn-reset">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    <!-- Table Card -->
    <div class="users-card">
        @if($users->count() > 0)
        <div style="overflow-x: auto;">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Alumni</th>
                        <th>Kategori Kelas</th>
                        <th>Kategori User</th>
                        <th>Status</th>
                        <th>Tanggal Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="user-info-cell">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="user-avatar">
                                <div class="user-details">
                                    <h4>{{ $user->name }}</h4>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->classroom)
                                <span class="user-badge user-badge-class">
                                    <i class='bx bx-chalkboard'></i> {{ $user->classroom->name }}
                                </span>
                            @else
                                <span style="color: var(--text-muted); font-style: italic;">Tidak Ada Kelas</span>
                            @endif
                        </td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="user-badge user-badge-role-admin">
                                    <i class='bx bx-shield-quarter'></i> Admin
                                </span>
                            @else
                                <span class="user-badge user-badge-role-user">
                                    <i class='bx bx-user'></i> Alumni
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->status === 'active')
                                <span class="user-badge user-badge-status-active">
                                    <i class='bx bx-check-circle'></i> Aktif
                                </span>
                            @elseif($user->status === 'pending')
                                <span class="user-badge user-badge-status-pending">
                                    <i class='bx bx-time'></i> Menunggu
                                </span>
                            @else
                                <span class="user-badge user-badge-status-inactive">
                                    <i class='bx bx-block'></i> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td style="color: var(--text-muted); font-size: 14px;">
                            {{ $user->created_at->translatedFormat('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="pagination-container">
            <div style="color: var(--text-muted); font-size: 14px;">
                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} anggota
            </div>
            <div>
                {{ $users->links('vendor.pagination.custom') }}
            </div>
        </div>
        @endif
        
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class='bx bx-user-x'></i>
            </div>
            <h3>Anggota Tidak Ditemukan</h3>
            <p>Tidak ada data anggota yang cocok dengan kriteria filter Anda.</p>
        </div>
        @endif
    </div>
</div>
@endsection

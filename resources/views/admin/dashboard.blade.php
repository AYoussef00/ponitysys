<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الأدمن - PointSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Cairo', sans-serif;
        }

        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            width: 280px;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .sidebar-header h4 {
            color: white;
            margin: 0;
            font-weight: 600;
        }

        .sidebar-header p {
            color: rgba(255,255,255,0.8);
            margin: 0.5rem 0 0 0;
            font-size: 0.9rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 1rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
            border: none;
            text-align: right;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(-5px);
        }

        .sidebar-menu .nav-link i {
            margin-left: 0.75rem;
            font-size: 1.1rem;
        }

        .main-content {
            margin-right: 280px;
            min-height: 100vh;
        }

        .top-navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .content-area {
            padding: 0 2rem 2rem 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-icon.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-icon.success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .btn-add-company {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-add-company:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .table th {
            background: #f8f9fa;
            border: none;
            font-weight: 600;
            color: #495057;
        }

        .table td {
            border: none;
            vertical-align: middle;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .btn-outline-danger {
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-outline-primary {
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .btn-group .btn {
            margin-right: 5px;
        }

        .input-group .btn {
            border-radius: 0 8px 8px 0;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
            transform: translateX(-2px);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
            }

            .main-content {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-shield-check me-2"></i>لوحة الأدمن</h4>
            <p>PointSys Admin Panel</p>
        </div>

        <div class="sidebar-menu">
            <nav class="nav flex-column">
                <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    الرئيسية
                </a>
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                    <i class="bi bi-building-add"></i>
                    إضافة شركة جديدة
                </a>
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i>
                    تسجيل الخروج
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h2 class="mb-0">مرحباً بك في لوحة تحكم الأدمن</h2>
            <div class="d-flex align-items-center">
                <span class="text-muted me-3">{{ Auth::guard('admin')->user()->name ?? 'أدمن' }}</span>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-left me-2"></i>تسجيل الخروج
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="stat-card">
                        <div class="stat-icon primary">
                            <i class="bi bi-building"></i>
                        </div>
                        <h3 class="mb-1">{{ $totalCompanies }}</h3>
                        <p class="text-muted mb-0">إجمالي الشركات</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="stat-card">
                        <div class="stat-icon success">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h3 class="mb-1">{{ $recentCompanies->count() }}</h3>
                        <p class="text-muted mb-0">الشركات الحديثة</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="stat-card text-center">
                        <button class="btn btn-add-company btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                            <i class="bi bi-plus-lg me-2"></i>
                            إضافة شركة جديدة
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recent Companies Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">جميع الشركات المسجلة</h5>
                                <span class="badge bg-primary">{{ $totalCompanies }} شركة</span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($recentCompanies->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>اسم الشركة</th>
                                                <th>البريد الإلكتروني</th>
                                                <th>تاريخ التسجيل</th>
                                                <th>الحالة</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentCompanies as $company)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                            <i class="bi bi-building text-white"></i>
                                                        </div>
                                                        <strong>{{ $company->name }}</strong>
                                                    </div>
                                                </td>
                                                <td>{{ $company->email }}</td>
                                                <td>{{ $company->created_at->format('Y/m/d') }}</td>
                                                <td>
                                                    <span class="badge bg-success">نشط</span>
                                                </td>
                                                                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#changePasswordModal{{ $company->id }}"
                                                                title="تغيير كلمة المرور">
                                                            <i class="bi bi-key"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger"
                                                                onclick="confirmDelete({{ $company->id }}, '{{ $company->name }}')"
                                                                title="حذف الشركة">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>

                                                    <form id="delete-form-{{ $company->id }}"
                                                          action="{{ route('admin.companies.delete', $company) }}"
                                                          method="POST"
                                                          class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-building text-muted" style="font-size: 3rem;"></i>
                                    <h5 class="mt-3 text-muted">لا توجد شركات مسجلة</h5>
                                    <p class="text-muted">قم بإضافة شركة جديدة للبدء</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Company Modal -->
    <div class="modal fade" id="addCompanyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-building-add me-2"></i>
                        إضافة شركة جديدة
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.companies.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الشركة</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2 me-2"></i>
                            إضافة الشركة
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>

    <!-- Change Password Modals -->
    @foreach($recentCompanies as $company)
    <div class="modal fade" id="changePasswordModal{{ $company->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-key me-2"></i>
                        تغيير كلمة مرور شركة {{ $company->name }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.companies.change-password', $company) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>الشركة:</strong> {{ $company->name }} <br>
                            <strong>الإيميل:</strong> {{ $company->email }}
                        </div>

                        <div class="mb-3">
                            <label for="new_password{{ $company->id }}" class="form-label">كلمة المرور الجديدة</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password"
                                       class="form-control @error('new_password') is-invalid @enderror"
                                       id="new_password{{ $company->id }}"
                                       name="new_password"
                                       required
                                       minlength="8"
                                       placeholder="أدخل كلمة المرور الجديدة">
                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword('new_password{{ $company->id }}')">
                                    <i class="bi bi-eye" id="eye{{ $company->id }}"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation{{ $company->id }}" class="form-label">تأكيد كلمة المرور</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password"
                                       class="form-control"
                                       id="new_password_confirmation{{ $company->id }}"
                                       name="new_password_confirmation"
                                       required
                                       minlength="8"
                                       placeholder="أعد كتابة كلمة المرور">
                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword('new_password_confirmation{{ $company->id }}')">
                                    <i class="bi bi-eye" id="eye_confirm{{ $company->id }}"></i>
                                </button>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>تحذير:</strong> سيتم تسجيل خروج الشركة من جميع الأجهزة بعد تغيير كلمة المرور.
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2 me-2"></i>
                            تغيير كلمة المرور
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
                function confirmDelete(companyId, companyName) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: `سيتم حذف شركة "${companyName}" نهائياً ولا يمكن التراجع عن هذا الإجراء!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'نعم، احذف الشركة',
                cancelButtonText: 'إلغاء',
                reverseButtons: true,
                customClass: {
                    popup: 'text-end'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // إظهار loading
                    Swal.fire({
                        title: 'جاري الحذف...',
                        text: 'يرجى الانتظار',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // إرسال النموذج
                    document.getElementById(`delete-form-${companyId}`).submit();
                }
            });
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById('eye' + inputId.replace('new_password', '').replace('_confirmation', '_confirm'));

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                eyeIcon.className = 'bi bi-eye';
            }
        }
    </script>
</body>
</html>

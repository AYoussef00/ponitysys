<!-- Sidebar -->
<div class="sidebar bg-white border-end">
    <!-- Logo & Toggle -->
    <div class="sidebar-header border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="sidebar-logo text-decoration-none">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40">
        </a>
        <button class="btn btn-link p-0 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <!-- User Profile -->
    <div class="sidebar-user border-bottom py-4 px-4">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <div class="avatar-wrapper rounded-circle bg-primary bg-opacity-10" style="width: 48px; height: 48px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4e73df&color=ffffff"
                         class="rounded-circle w-100 h-100" alt="User Avatar">
                </div>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="mb-1 fw-semibold">{{ auth()->user()->name ?? 'Unknown User' }}</h6>
                <p class="text-muted small mb-0">مدير النظام</p>
            </div>
            <div class="dropdown">
                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>الملف الشخصي</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>الإعدادات</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; width: 100%; text-align: right;">
                                <i class="bi bi-box-arrow-right me-2"></i>تسجيل الخروج
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav p-4">
        <!-- Main Navigation -->
        <div class="nav-section mb-4">
            <h6 class="nav-section-title text-uppercase text-muted small fw-bold mb-3">القائمة الرئيسية</h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <div class="nav-link-icon">
                            <i class="bi bi-grid-1x2"></i>
                        </div>
                        <span>لوحة التحكم</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customers.index') }}" class="nav-link {{ Request::is('customers*') ? 'active' : '' }}">
                        <div class="nav-link-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <span>العملاء</span>
                        <span class="badge bg-primary rounded-pill ms-auto">{{ \App\Models\Customer::where('user_id', auth()->id())->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rewards.index') }}" class="nav-link {{ Request::is('rewards*') ? 'active' : '' }}">
                        <div class="nav-link-icon">
                            <i class="bi bi-gift"></i>
                        </div>
                        <span>المكافآت</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transactions.index') }}" class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}">
                        <div class="nav-link-icon">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <span>المعاملات</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Management -->
        <div class="nav-section mb-4">
            <h6 class="nav-section-title text-uppercase text-muted small fw-bold mb-3">الإدارة</h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('reports.index') }}" class="nav-link {{ Request::is('reports*') ? 'active' : '' }}">
                        <div class="nav-link-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <span>التقارير</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ Request::is('settings*') ? 'active' : '' }}">
                        <div class="nav-link-icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        <span>الإعدادات</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.api.docs.download') }}" class="nav-link">
                        <div class="nav-link-icon">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <span>الدليل الإرشادي للتكامل</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Support -->
        <div class="nav-section">
            <h6 class="nav-section-title text-uppercase text-muted small fw-bold mb-3">الدعم</h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-link-icon">
                            <i class="bi bi-question-circle"></i>
                        </div>
                        <span>المساعدة</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-link-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <span>تواصل معنا</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer border-top py-3 px-4">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <div class="bg-success bg-opacity-10 p-2 rounded">
                    <i class="bi bi-headset text-success"></i>
                </div>
            </div>
            <div class="flex-grow-1 ms-3">
                <p class="mb-0 small">بحاجة للمساعدة؟</p>
                <a href="#" class="text-decoration-none small fw-semibold">تواصل مع الدعم</a>
            </div>
        </div>
    </div>
</div>

<style>
.sidebar {
    width: 280px;
    height: 100vh;
    position: fixed;
    top: 0;
    right: 0;
    z-index: 1000;
    transition: all 0.3s ease;
}

.sidebar-header {
    height: 70px;
}

.sidebar-nav {
    height: calc(100vh - 70px - 180px); /* Header height + User section + Footer */
    overflow-y: auto;
}

.nav-section-title {
    letter-spacing: 0.5px;
    font-size: 11px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: var(--bs-gray-700);
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.nav-link:hover {
    color: var(--bs-primary);
    background-color: var(--bs-primary-bg-subtle);
}

.nav-link.active {
    color: var(--bs-primary);
    background-color: var(--bs-primary-bg-subtle);
    font-weight: 600;
}

.nav-link-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.75rem;
    height: 1.75rem;
    margin-left: 1rem;
    font-size: 1.1rem;
    color: var(--bs-gray-600);
    transition: all 0.2s ease;
}

.nav-link:hover .nav-link-icon,
.nav-link.active .nav-link-icon {
    color: var(--bs-primary);
}

.nav-link .badge {
    padding: 0.35em 0.65em;
    font-size: 0.75em;
}

.sidebar-footer {
    position: absolute;
    bottom: 0;
    right: 0;
    left: 0;
    background: var(--bs-white);
}

/* Custom Scrollbar */
.sidebar-nav::-webkit-scrollbar {
    width: 4px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: var(--bs-gray-300);
    border-radius: 4px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: var(--bs-gray-400);
}

/* Responsive */
@media (max-width: 991.98px) {
    .sidebar {
        transform: translateX(100%);
    }

    .sidebar.show {
        transform: translateX(0);
    }
}
</style>
@endsection

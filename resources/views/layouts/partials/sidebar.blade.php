<!-- Main Sidebar -->
<aside class="app-sidebar">
    <!-- Brand Logo -->
    <div class="brand-container d-flex justify-content-center align-items-center" style="padding: 1.5rem;">
        <a href="{{ route('dashboard') }}" class="brand-link d-flex justify-content-center align-items-center w-100" style="text-align: center;">
            {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo"> --}}
            <span class="brand-text mx-auto">PonintSys</span>
        </a>
        <button class="sidebar-toggle d-lg-none">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <!-- User Profile -->
    <div class="user-profile">
        <div class="user-avatar">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=4e73df&color=ffffff" alt="User Avatar">
            <span class="status-badge online"></span>
        </div>
        <div class="user-info">
            <h6 class="user-name">{{ auth()->user()->name ?? 'Unknown User' }}</h6>
            <span class="user-role">مدير النظام</span>
        </div>
        <div class="user-actions">
            <div class="dropdown">
                <button class="action-btn" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end custom-dropdown">
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-person"></i>
                            <span>الملف الشخصي</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear"></i>
                            <span>الإعدادات</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>تسجيل الخروج</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav">
        <!-- Main Menu -->
        <div class="nav-section">
            <span class="nav-section-title">القائمة الرئيسية</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i>
                        <span>لوحة التحكم</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>العملاء</span>
                        <span class="menu-badge">{{ \App\Models\Customer::where('user_id', auth()->id())->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rewards.index') }}" class="nav-link {{ request()->routeIs('rewards.*') ? 'active' : '' }}">
                        <i class="bi bi-gift"></i>
                        <span>المكافآت</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-left-right"></i>
                        <span>المعاملات</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Management Menu -->
        <div class="nav-section">
            <span class="nav-section-title">الإدارة</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('coupons.index') }}" class="nav-link {{ request()->routeIs('coupons.*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i>
                        <span>الكوبونات</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>التقارير</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        <span>الإعدادات</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- API Menu -->
        <div class="nav-section">
            <span class="nav-section-title">
                <i class="bi bi-code-slash me-2"></i>
                API والتكامل
            </span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('settings.api') }}" class="nav-link {{ request()->routeIs('settings.api') ? 'active' : '' }}">
                        <i class="bi bi-key"></i>
                        <span>مفاتيح API</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.api.docs.guide') }}" class="nav-link {{ request()->routeIs('settings.api.docs.*') ? 'active' : '' }}">
                        <i class="bi bi-book"></i>
                        <span>دليل API</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.api') }}#webhooks" class="nav-link">
                        <i class="bi bi-webhook"></i>
                        <span>Webhooks</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.api.stats') }}" class="nav-link {{ request()->routeIs('settings.api.stats') ? 'active' : '' }}">
                        <i class="bi bi-graph-up"></i>
                        <span>إحصائيات API</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Support Menu -->
        <div class="nav-section">
            <span class="nav-section-title">الدعم</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-question-circle"></i>
                        <span>المساعدة</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-envelope"></i>
                        <span>تواصل معنا</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="support-card">
            <div class="support-icon">
                <i class="bi bi-headset"></i>
            </div>
            <div class="support-content">
                <span class="support-label">بحاجة للمساعدة؟</span>
                <a href="#" class="support-link">تواصل مع الدعم</a>
            </div>
        </div>
    </div>
</aside>

<style>
.app-sidebar {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    width: 280px;
    background: white;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    z-index: 1000;
}

.brand-container {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #f0f0f0;
}

.brand-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: inherit;
}

.brand-logo {
    height: 40px;
    width: auto;
    margin-left: 1rem;
}

.brand-text {
    font-size: 1.25rem;
    font-weight: 600;
}

.sidebar-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #666;
    cursor: pointer;
}

.user-profile {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #f0f0f0;
    position: relative;
}

.user-avatar {
    position: relative;
    margin-left: 1rem;
}

.user-avatar img {
    width: 38px;
    height: 38px;
    border-radius: 50%;
}

.status-badge {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.status-badge.online {
    background: #28a745;
}

.user-info {
    flex: 1;
    min-width: 0;
    overflow: visible;
    margin-right: 10px;
}

.user-name {
    margin: 0;
    font-size: 0.8rem;
    font-weight: 600;
    white-space: nowrap;
    overflow: visible;
    max-width: none;
}

.user-role {
    font-size: 0.7rem;
    color: #666;
}

.user-actions {
    margin-right: auto;
}

.action-btn {
    background: none;
    border: none;
    font-size: 1.25rem;
    color: #666;
    cursor: pointer;
    padding: 0.25rem;
}

.custom-dropdown {
    min-width: 200px;
    padding: 0.5rem;
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.dropdown-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: inherit;
    text-decoration: none;
    border-radius: 0.5rem;
}

.dropdown-item i {
    margin-left: 0.75rem;
    font-size: 1.1rem;
}

.dropdown-item:hover {
    background: #f8f9fa;
}

.dropdown-item.text-danger:hover {
    background: #dc354522;
}

.dropdown-divider {
    margin: 0.5rem 0;
}

.sidebar-nav {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem 1rem;
}

.nav-section-title {
    font-size: 0.7rem;
    font-weight: 600;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.75rem;
    padding: 0 0.5rem;
}

.nav-section-title i {
    color: #4e73df;
}

.nav-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    margin-bottom: 0.25rem;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.6rem 1rem;
    color: #666;
    text-decoration: none;
    border-radius: 0.5rem;
    margin-bottom: 0.25rem;
    transition: all 0.2s ease;
    font-size: 0.85rem;
}

.nav-link i {
    margin-left: 1rem;
    font-size: 1rem;
    width: 20px;
    text-align: center;
}

.nav-link:hover {
    background: #f8f9fa;
    color: #333;
    transform: translateX(-5px);
}

.nav-link.active {
    background: #4e73df;
    color: white;
    box-shadow: 0 2px 8px rgba(78, 115, 223, 0.3);
}

.nav-link.active:hover {
    transform: translateX(-5px);
}

@media (max-width: 991.98px) {
    .app-sidebar {
        transform: translateX(100%);
        transition: transform 0.3s ease;
    }

    .app-sidebar.show {
        transform: translateX(0);
    }

    .sidebar-toggle {
        display: block;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.app-sidebar');
    const toggle = document.querySelector('.sidebar-toggle');

    if (toggle) {
        toggle.addEventListener('click', function() {
            sidebar.classList.remove('show');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && !sidebar.contains(e.target) && !e.target.closest('.navbar-toggler')) {
            sidebar.classList.remove('show');
        }
    });
});
</script>

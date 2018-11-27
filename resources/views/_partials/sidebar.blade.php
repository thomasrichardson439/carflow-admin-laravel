<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <div class="peers">
                <div class="peer peer-logo">
                    <a href="/admin">
                        <h5 class="collapsed"><img src="/images/logo_small.png"></h5>
                        <h5 class="expanded"><img src="/images/logo.svg"> <span class="admin-label label-logo">ADMIN</span></h5>
                    </a>
                </div>
                <div class="peer">
                    <div class="mobile-toggle sidebar-toggle">
                        <a href="/" class="td-n">
                            <i class="ti-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <ul class="sidebar-menu scrollable pos-r">
            <li class="nav-item mT-30 active">
                <a class='sidebar-link' href="{{ route('admin.users.index') }}">
                    <span class="title">Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin.cars.index') }}">
                    <span class="title">Cars</span>
                </a>
            </li>
            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin.receipts.index') }}">
                    <span class="title">Receipts</span>
                </a>
            </li>
        </ul>
    </div>
</div>

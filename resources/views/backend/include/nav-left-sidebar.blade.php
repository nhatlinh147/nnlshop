<ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-1" aria-controls="submenu-1"><i
                                        class="fa fa-fw fa-user-circle"></i>Dashboard <span
                                        class="badge badge-success">6</span></a>
                                <div id="submenu-1" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link"
                                                href="{{ route('backend.dashboard_finance') }}">Finance</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link"
                                                href="{{ route('backend.dashboard_sale') }}">Sales</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="infulencer.html">Infulencer</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-2" aria-controls="submenu-2"><i
                                        class="fa fa-fw fa-user-circle"></i>Sản phẩm<span
                                        class="badge badge-success">6</span></a>
                                <div id="submenu-2" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('backend.all_category') }}">Quản
                                                lý danh mục</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('backend.all_brand') }}">Quản
                                                lý
                                                thương hiệu</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('backend.all_product') }}">Quản
                                                lý sản phẩm</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-3" aria-controls="submenu-3"><i
                                        class="fa fa-fw fa-user-circle"></i>Bài viết<span
                                        class="badge badge-success">6</span></a>
                                <div id="submenu-3" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('backend.list_cate_post') }}">Quản
                                                lý danh mục bài
                                                viết</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('backend.list_post') }}">Quản
                                                lý bài viết</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false"
                                    data-target="#submenu-4" aria-controls="submenu-4"><i
                                        class="fa fa-fw fa-user-circle"></i>Ưu đãi<span
                                        class="badge badge-success">6</span></a>
                                <div id="submenu-4" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('backend.add_special') }}">Thêm chiến
                                                dịch</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('backend.all_special') }}">Toàn bộ
                                                chiến dịch</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('backend.list_slide') }}" id="submenu-5">
                                    <i class="fa fa-fw fa-user-circle"></i>
                                    Slide<span class="badge badge-success">6</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('backend.all_prop_product') }}" id="submenu-6">
                                    <i class="fa fa-fw fa-user-circle"></i>Thuộc tính sản phẩm<span
                                        class="badge badge-success">6</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('backend.fee_shipping') }}" id="submenu-7">
                                    <i class="fa fa-fw fa-user-circle"></i>Chi phí vận chuyển<span
                                        class="badge badge-success">6</span>
                                </a>
                            </li>

                        </ul>
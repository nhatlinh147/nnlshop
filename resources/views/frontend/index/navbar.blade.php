<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse"
                href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Danh sách</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;width: fit-content;">
                <div class="navbar-nav w-100" style="font-size: 0.9rem">

                    @foreach ($category_parent as $cate)
                        @if (in_array($cate->id, $array_have_child))
                            <div class="nav-item dropdown dropright">
                                <a href="#" class="nav-link dropdown-toggle d-flex" data-toggle="dropdown">
                                    <span style="flex: auto">{{ $cate->Category_Name }}</span>
                                    {{-- <i class="fa fa-angle-right mr-3"></i> --}}
                                    <i class="fa fa-angle-right float-right mt-1 ml-3"></i>
                                </a>
                                <div class="dropdown-menu position-absolute rounded-0 border-0 m-0"
                                    style="font-size: 0.9rem">
                                    @foreach (App\Model\CategoryModel::where('Category_Parent', $cate->id)->get() as $child)
                                        <a href="" class="dropdown-item">{{ $child->Category_Name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="nav-item">
                                <a href="" class="nav-link">{{ $cate->Category_Name }}</a>
                            </div>
                        @endif
                    @endforeach

                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="{{ route('frontend.index') }}" class="text-decoration-none d-block d-lg-none">
                    <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="index.html" class="nav-item nav-link active">Trang chủ</a>
                        <a href="shop.html" class="nav-item nav-link">Shop</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i
                                    class="fa fa-angle-down mt-1"></i></a>
                            <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                <a href="cart.html" class="dropdown-item">Shopping Cart</a>
                                <a href="checkout.html" class="dropdown-item">Checkout</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block" id="Count_Favourite_Cart">
                        <a href="{{ route('frontend.show_cart') }}" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle"
                                style="padding-bottom: 2px;">0</span>
                        </a>
                        <a href="{{ route('frontend.show_favorite') }}" class="btn px-0">
                            <i class="fas fa-heart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle"
                                style="padding-bottom: 2px;">0</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

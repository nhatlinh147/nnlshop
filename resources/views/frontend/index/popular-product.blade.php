<div class="fr-pop-wrap">

    <h3 class="component-ttl"><span>Sản phẩm nổi bật</span></h3>

    <ul class="fr-pop-tabs sections-show">

        <li><a data-frpoptab-num="0" data-frpoptab="#frpoptab-tab-0" href="#" class="active">Toàn bộ danh mục</a></li>

        @foreach ($tabCateProPopular as $value)
            <li><a data-frpoptab-num="{{$value->Category_ID}}" data-frpoptab="#frpoptab-tab-{{$value->Category_ID}}" href="#">{{$value->category->Category_Name}}</a></li>
        @endforeach
    </ul>

    <div class="fr-pop-tab-cont">

        <p data-frpoptab-num="0" class="fr-pop-tab-mob active" data-frpoptab="#frpoptab-tab-0">Toàn bộ danh mục</p>
        <div class="flexslider prod-items fr-pop-tab" id="frpoptab-tab-0">
            <ul class="slides">
                @foreach ($filterPopularProduct as $filter)
                <li class="prod-i">
                    <div class="prod-i-top">
                        <a href="product.html" class="prod-i-img"><!-- NO SPACE --><img src="{{url('public/upload/product/'.$filter->Product_Image)}}" alt="{{$filter->Product_Name}}"><!-- NO SPACE --></a>
                        <p class="prod-i-info">
                            <a href="#" class="prod-i-favorites"><span>Wishlist</span><i class="fa fa-heart"></i></a>
                            <a href="#" class="qview-btn prod-i-qview"><span>Quick View</span><i class="fa fa-search"></i></a>
                            <a class="prod-i-compare" href="#"><span>Compare</span><i class="fa fa-bar-chart"></i></a>
                        </p>
                        <p class="prod-i-addwrap">
                            <a href="#" class="prod-i-add">Go to detail</a>
                        </p>
                    </div>
                    <h3>
                        <a href="product.html">{{$filter->Product_Name}}</a>
                    </h3>
                    <p class="prod-i-price">
                        <b>{{$filter->Product_Name}}</b>
                    </p>
                    <div class="prod-i-skuwrapcolor">
                        <ul class="prod-i-skucolor">
                            <li class="bx_active"><img src="{{asset('public/FrontEnd/img/color/red.jpg')}}" alt="Red"></li>
                            <li><img src="{{asset('public/FrontEnd/img/color/blue.jpg')}}" alt="Blue"></li>
                        </ul>
                    </div>
                </li>
                @endforeach
            </ul>

        </div>

        @foreach ($tabCateProPopular as $item)
            <p data-frpoptab-num="{{$item->Category_ID}}" class="fr-pop-tab-mob" data-frpoptab="#frpoptab-tab-{{$item->Category_ID}}">{{$item->category->Category_Name}}</p>
            <div class="flexslider prod-items fr-pop-tab" id="frpoptab-tab-{{$item->Category_ID}}">
                <ul class="slides">
                    @foreach(App\Model\Product::where('Category_ID',$item->Category_ID)->get() as $product)
                    <li class="prod-i">
                        <div class="prod-i-top">
                            <a href="product.html" class="prod-i-img"><!-- NO SPACE --><img src="{{url('public/upload/product/'.$product->Product_Image)}}" alt="{{$product->Product_Name}}"><!-- NO SPACE --></a>
                            <p class="prod-i-info">
                                <a href="#" class="prod-i-favorites"><span>Wishlist</span><i class="fa fa-heart"></i></a>
                                <a href="#" class="qview-btn prod-i-qview"><span>Quick View</span><i class="fa fa-search"></i></a>
                                <a class="prod-i-compare" href="#"><span>Compare</span><i class="fa fa-bar-chart"></i></a>
                            </p>
                            <p class="prod-i-addwrap">
                                <a href="#" class="prod-i-add">Go to detail</a>
                            </p>
                        </div>
                        <h3>
                            <a href="product.html">{{$product->Product_Name}}</a>
                        </h3>
                        <p class="prod-i-price">
                            <b>{{$product->Product_Name}}</b>
                        </p>
                        <div class="prod-i-skuwrapcolor">
                            <ul class="prod-i-skucolor">
                                <li class="bx_active"><img src="{{asset('public/FrontEnd/img/color/red.jpg')}}" alt="Red"></li>
                                <li><img src="{{asset('public/FrontEnd/img/color/blue.jpg')}}" alt="Blue"></li>
                            </ul>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

    </div><!-- .fr-pop-tab-cont -->


    <ul class="fr-pop-tabs sections-show">

        <li><a data-frpoptab-num="0" data-frpoptab="#frpoptab-tab-brand-0" href="#" class="active">Toàn bộ thương hiệu</a></li>

        @foreach ($tabBrandProPopular as $value)
            <li><a data-frpoptab-num="{{$value->Brand_ID}}" data-frpoptab="#frpoptab-tab-{{$value->brand->Brand_Product_Slug}}-{{$value->Brand_ID}}" href="#">{{$value->brand->Brand_Name}}</a></li>
        @endforeach
    </ul>

    <div class="fr-pop-tab-cont">

        <p data-frpoptab-num="0" class="fr-pop-tab-mob active" data-frpoptab="#frpoptab-tab-brand-0">Toàn bộ danh mục</p>
        <div class="flexslider prod-items fr-pop-tab" id="frpoptab-tab-brand-0">
            <ul class="slides">
                @foreach ($filterPopularProduct as $filter)
                <li class="prod-i">
                    <div class="prod-i-top">
                        <a href="product.html" class="prod-i-img"><!-- NO SPACE --><img src="{{url('public/upload/product/'.$filter->Product_Image)}}" alt="{{$filter->Product_Name}}"><!-- NO SPACE --></a>
                        <p class="prod-i-info">
                            <a href="#" class="prod-i-favorites"><span>Wishlist</span><i class="fa fa-heart"></i></a>
                            <a href="#" class="qview-btn prod-i-qview"><span>Quick View</span><i class="fa fa-search"></i></a>
                            <a class="prod-i-compare" href="#"><span>Compare</span><i class="fa fa-bar-chart"></i></a>
                        </p>
                        <p class="prod-i-addwrap">
                            <a href="#" class="prod-i-add">Go to detail</a>
                        </p>
                    </div>
                    <h3>
                        <a href="product.html">{{$filter->Product_Name}}</a>
                    </h3>
                    <p class="prod-i-price">
                        <b>{{$filter->Product_Name}}</b>
                    </p>
                    <div class="prod-i-skuwrapcolor">
                        <ul class="prod-i-skucolor">
                            <li class="bx_active"><img src="{{asset('public/FrontEnd/img/color/red.jpg')}}" alt="Red"></li>
                            <li><img src="{{asset('public/FrontEnd/img/color/blue.jpg')}}" alt="Blue"></li>
                        </ul>
                    </div>
                </li>
                @endforeach
            </ul>

        </div>

        @foreach ($tabBrandProPopular as $item)
            <p data-frpoptab-num="{{$item->Brand_ID}}" class="fr-pop-tab-mob" data-frpoptab="#frpoptab-tab-{{$item->brand->Brand_Product_Slug}}-{{$item->Brand_ID}}">{{$item->brand->Brand_Name}}</p>
            <div class="flexslider prod-items fr-pop-tab" id="frpoptab-tab-{{$item->brand->Brand_Product_Slug}}-{{$item->Brand_ID}}">
                <ul class="slides">
                    @foreach(App\Model\Product::where('Brand_ID',$item->Brand_ID)->get() as $product)
                    <li class="prod-i">
                        <div class="prod-i-top">
                            <a href="product.html" class="prod-i-img"><!-- NO SPACE --><img src="{{url('public/upload/product/'.$product->Product_Image)}}" alt="{{$product->Product_Name}}"><!-- NO SPACE --></a>
                            <p class="prod-i-info">
                                <a href="#" class="prod-i-favorites"><span>Wishlist</span><i class="fa fa-heart"></i></a>
                                <a href="#" class="qview-btn prod-i-qview"><span>Quick View</span><i class="fa fa-search"></i></a>
                                <a class="prod-i-compare" href="#"><span>Compare</span><i class="fa fa-bar-chart"></i></a>
                            </p>
                            <p class="prod-i-addwrap">
                                <a href="#" class="prod-i-add">Go to detail</a>
                            </p>
                        </div>
                        <h3>
                            <a href="product.html">{{$product->Product_Name}}</a>
                        </h3>
                        <p class="prod-i-price">
                            <b>{{$product->Product_Name}}</b>
                        </p>
                        <div class="prod-i-skuwrapcolor">
                            <ul class="prod-i-skucolor">
                                <li class="bx_active"><img src="{{asset('public/FrontEnd/img/color/red.jpg')}}" alt="Red"></li>
                                <li><img src="{{asset('public/FrontEnd/img/color/blue.jpg')}}" alt="Blue"></li>
                            </ul>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

    </div><!-- .fr-pop-tab-cont -->


</div><!-- .fr-pop-wrap -->



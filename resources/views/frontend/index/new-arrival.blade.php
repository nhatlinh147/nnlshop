<!-- BEGIN SALE PRODUCT & NEW ARRIVALS -->
<div class="row margin-bottom-40">
    <!-- BEGIN SALE PRODUCT -->
    <div class="col-md-12 sale-product">
        <h2>New Arrivals</h2>
        <div class="owl-carousel owl-carousel5">
            <?php $i = 0; ?>
            @foreach ($new_arrival as $product)
                <div>
                    <div class="product-item">
                        <div class="pi-img-wrapper">
                            <img src="{{ url('public/upload/product/' . $product->Product_Image) }}"
                                class="img-responsive" alt="{{ $product->Product_Name }}">
                            <div>
                                <a href="{{ url('public/upload/product/' . $product->Product_Image) }}"
                                    class="btn btn-default fancybox-button">Zoom</a>
                                <a href="#{{ $product->Product_Slug }}-view"
                                    class="btn btn-default fancybox-fast-view">View</a>
                            </div>
                        </div>
                        <h3><a href="shop-item.html">{{ $product->Product_Name }}</a></h3>
                        <div class="pi-price">{{ $product->Product_Price }}</div>
                        <a href="javascript:;" class="btn btn-default add2cart">Add to cart</a>
                        <?php
                        $i++;
                        if ($i == 1) {
                            $str = '<div class="sticker sticker-new"></div>';
                        } elseif ($i == 5) {
                            $str = '<div class="sticker sticker-sale"></div>';
                        } else {
                            $str = '';
                        }

                        echo $str;
                        ?>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
    <!-- END SALE PRODUCT -->
</div>
<!-- END SALE PRODUCT & NEW ARRIVALS -->

<!-- BEGIN fast view of a product -->
<div id="product-pop-up" style="display: none; width: 700px;">
    <div class="product-page product-pop-up">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-3">
                <div class="product-main-image">
                    <img src="assets/pages/img/products/model7.jpg" alt="Cool green dress with red bell"
                        class="img-responsive">
                </div>
                <div class="product-other-images">
                    <a href="javascript:;" class="active"><img alt="Berry Lace Dress"
                            src="assets/pages/img/products/model3.jpg"></a>
                    <a href="javascript:;"><img alt="Berry Lace Dress" src="assets/pages/img/products/model4.jpg"></a>
                    <a href="javascript:;"><img alt="Berry Lace Dress" src="assets/pages/img/products/model5.jpg"></a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-9">
                <h2>Cool green dress with red bell</h2>
                <div class="price-availability-block clearfix">
                    <div class="price">
                        <strong><span>$</span>47.00</strong>
                        <em>$<span>62.00</span></em>
                    </div>
                    <div class="availability">
                        Availability: <strong>In Stock</strong>
                    </div>
                </div>
                <div class="description">
                    <p>Lorem ipsum dolor ut sit ame dolore adipiscing elit, sed nonumy nibh sed euismod laoreet
                        dolore magna aliquarm erat volutpat Nostrud duis molestie at dolore.</p>
                </div>
                <div class="product-page-options">
                    <div class="pull-left">
                        <label class="control-label">Size:</label>
                        <select class="form-control input-sm">
                            <option>L</option>
                            <option>M</option>
                            <option>XL</option>
                        </select>
                    </div>
                    <div class="pull-left">
                        <label class="control-label">Color:</label>
                        <select class="form-control input-sm">
                            <option>Red</option>
                            <option>Blue</option>
                            <option>Black</option>
                        </select>
                    </div>
                </div>
                <div class="product-page-cart">
                    <div class="product-quantity">
                        <input id="product-quantity" type="text" value="1" readonly name="product-quantity"
                            class="form-control input-sm">
                    </div>
                    <button class="btn btn-primary" type="submit">Add to cart</button>
                    <a href="shop-item.html" class="btn btn-default">More details</a>
                </div>
            </div>

            <div class="sticker sticker-sale"></div>
        </div>
    </div>
</div>
<!-- END fast view of a product -->

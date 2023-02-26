<div class="container-fluid mb-3">
    <div class="row px-xl-5">

        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                <ol class="carousel-indicators">
                    @php
                        $i = 0;
                        $j = 0;
                    @endphp
                    @foreach ($all_slide as $slide)
                        <li data-target="#header-carousel" data-slide-to="{{ $i }}"
                            class="{{ $i == 0 ? 'active' : '' }}"></li>
                        @php
                            $i++;
                        @endphp
                    @endforeach

                </ol>
                <div class="carousel-inner">
                    @foreach ($all_slide as $slide)
                        <div class="carousel-item position-relative {{ $j == 0 ? 'active' : '' }}"
                            style="height: 530px;">
                            @php
                                $j++;
                            @endphp
                            <img class="position-absolute w-100 h-100"
                                src="{{ asset('public/upload/slide/' . $slide->Slide_Image) }}"
                                style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">
                                        {{ $slide->Slide_Title }}</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                        {!! $slide->Slide_Desc !!}</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                        href="#">{{ $slide->Slide_More }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @foreach ($special_show as $special)
                <div class="product-offer mb-30" style="height: 250px;">
                    <img class="img-fluid" src="{{ asset('public/upload/special/' . $special->Special_Image) }}"
                        alt="">
                    <div class="offer-text text-center">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">{{ $special->Special_Title }}</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</div>

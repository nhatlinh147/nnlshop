<!-- BEGIN SLIDER -->
<div class="page-slider margin-bottom-35">
    <div id="carousel-example-generic" class="carousel slide carousel-slider">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @php
                $i = -1;
                $j = -1;
            @endphp
            @foreach ($all_slide as $slide)
                @php
                    $i++;
                @endphp
                <li data-target="#carousel-example-generic" data-slide-to="{{ $i }}"
                    class="{{ $i == 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @foreach ($all_slide as $slide)
                @php
                    $j++;
                @endphp
                <div class="item carousel-item {{ $j == 0 ? 'active' : '' }}"
                    style="background: url(public/upload/slide/{{ $slide->Slide_Image }})">
                    <div class="container">
                        <div class="carousel-position-four text-center">
                            <h2 class="margin-bottom-20 animate-delay carousel-title-v3 border-bottom-title text-uppercase"
                                data-animation="animated fadeInDown">
                                {{ $slide->Slide_Title }}
                            </h2>
                            <p class="carousel-subtitle-v2" data-animation="animated fadeInUp">
                                {{ $slide->Slide_Desc }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Controls -->
        <a class="left carousel-control carousel-control-shop" href="#carousel-example-generic" role="button"
            data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <a class="right carousel-control carousel-control-shop" href="#carousel-example-generic" role="button"
            data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>
    </div>
</div>
<!-- END SLIDER -->

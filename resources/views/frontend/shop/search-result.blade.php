@php
    function text($test)
    {
        $test_all = $test . '<strong>' . $_GET['Search_Product'] . '</strong>';
        return $_GET['Search_Product'] ? $test_all : '';
    }
@endphp
<div class="container">
    <div class="card" style="border:none">
        <div class="card-header" style="background-color: white">
            <div class="card-title font-weight" style="font-size: 1.2rem">Tìm thấy 0 kết quả
                {!! text('với từ khóa ') !!}
            </div>
        </div>
        <div class="card-body">
            <div class="row justify-content-center text-center">
                <div class="col-12">
                    <img src="{{ asset('public/FrontEnd/img/noti-search_1_11zon.png') }}" />
                </div>
                <div class="col-12 text-uppercase">
                    <p>Rất tiếc chúng tôi không tìm thấy kết quả {!! text(': ') !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

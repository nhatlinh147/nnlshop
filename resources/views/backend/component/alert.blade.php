
<div class="alert alert-danger">
    <div class="alert-title" id="{{ $title_customization }}">{{ $title_customization }}</div>
    {{ $slot }}
    <br>
    @if (!empty($foo))
        <h1>Tồn tại</h1>
    @else
        <h1>Không Tồn tại</h1>
    @endif

    @foreach ($array_one as $key1 => $value )
        @foreach ($value["suffix"] as $key2 => $item )

            @if ($item["suffix_v"] == 'slug' && $item["suffix_v"] == 'name')
                {{'Tồn tại slug'}}
            @endif
        @endforeach
        @foreach ($value["suffix"] as $key2 => $item )
            {!!$item["suffix_v"].'_'.$value["prefix_v"]!!}

        @endforeach
    @endforeach

    @if(!empty($array_one))
@foreach ($array_one as $key => $value )
<div class="modal fade" id="ajax-{{$value['prefix_v']}}-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-small">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title_{{$value['prefix_v']}}"></h4>
            </div>
            <div class="modal-body">
                <form id="{{$value['prefix_v']}}Form" name="{{$value['prefix_v']}}Form" class="form-horizontal">
                <input type="hidden" name="{{$value['prefix_v']}}_id" id="{{$value['prefix_v']}}_id">
                <input type="hidden" id="Image_{{ucfirst($value['prefix_v'])}}_Hidden"/>

                        @foreach ($value["suffix"] as $key2 => $item )

                            @php
                                if ($item['suffix_v'] == 'slug'){
                                    $exist = 'Tồn tại';
                                    break;
                                }else {
                                    $exist = 'Không tồn tại';
                                }
                            @endphp

                        @endforeach
                        @foreach ($value["suffix"] as $key => $item )
                            <div class="form-group">
                                <label class="col-sm-6">{{ucfirst($item['suffix_c']).' '.$value['prefix_c']}}</label>
                                <div class="col-sm-12">
                                    @if ($item['suffix_v'] == 'desc' || $item['suffix_v'] == 'content' || $item['suffix_v'] == 'meta_desc'|| $item['suffix_v'] == 'meta_keywords')
                                        <textarea class="form-control {{$value['prefix_v'].'_'.$item['suffix_v']}}"
                                        name="{{($item['suffix_v'] == 'meta_keywords'||$item['suffix_v'] == 'meta_desc') ? $item['suffix_v'].'_'.$value['prefix_v'] :$value['prefix_v'].'_'.$item['suffix_v']}}"
                                        id="{{$item['suffix_v'] == 'meta_keywords' ? $item['suffix_v'].'_'.$value['prefix_v'] :'Ckeditor_'.ucfirst($item['suffix_v'])}}" rows="3"></textarea>
                                    @elseif($item['suffix_v'] == 'status')
                                        <select name="{{$value['prefix_v'].'_'.$item['suffix_v']}}" class="form-control {{$value['prefix_v'].'_'.$item['suffix_v']}}" id="{{$value['prefix_v'].'_'.$item['suffix_v']}}">
                                            <option value="0">Ẩn</option>
                                            <option selected value="1">Hiển thị</option>
                                        </select>

                                    @elseif($item['suffix_v'] == 'category_parent')
                                        <select name="category_product_name" class="form-control input-sm m-bot15 category_product_name">
                                            <option value="">Chọn danh mục sản phẩm</option>
                                            @foreach (DB::table('tbl_category_product')->whereIn('Category_Parent', [0])->orderby('id', 'desc')->get() as $category)
                                                @if (App\Model\CategoryModel::whereIn('Category_Parent',[$category->id])->get()->count() == 0)
                                                    <option value="{{$category->id}}">{{$category->Category_Name}}</option>
                                                @else
                                                    <optgroup label="{{$category->Category_Name}}">
                                                        @foreach (App\Model\CategoryModel::where('Category_Parent',$category->id)->get() as $value)
                                                            <option value="{{$value->id}}">{{$value->Category_Name}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endif
                                            @endforeach
                                        </select>

                                    @elseif($item['suffix_v'] == 'brand_parent')
                                        <select name="brand_product_name" class="form-control input-sm m-bot15 brand_product_name">
                                            <option value="">Chọn thương hiệu sản phẩm</option>
                                            @foreach (DB::table('tbl_brand_product')->whereIn('Brand_Parent', [0])->orderby('Brand_ID', 'desc')->get() as $brand)
                                                @if (App\Model\BrandModel::whereIn('Brand_Parent',[$brand->Brand_ID])->get()->count() == 0)
                                                    <option value="{{$brand->Brand_ID}}">{{$brand->Brand_Name}}</option>
                                                @else
                                                    <optgroup label="{{$brand->Brand_Name}}">
                                                        @foreach (App\Model\BrandModel::where('Brand_Parent',$brand->Brand_ID)->get() as $value)
                                                            <option value="{{$value->Brand_ID}}">{{$value->Brand_Name}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endif
                                            @endforeach
                                        </select>

                                    @else
                                        <input type="{{($item['suffix_v'] == 'image'||$item['suffix_v'] == 'document') ? 'file' :'text'}}"
                                        class="form-control {{$value['prefix_v'].'_'.$item['suffix_v']}} {{($item['suffix_v'] == 'price'||$item['suffix_v'] == 'cost'||$item['suffix_v'] =='quantity'||$item['suffix_v'] =='sold') ? 'format_price' :''}}"
                                        name="{{$value['prefix_v'].'_'.$item['suffix_v']}}"
                                        @php
                                        if($exist == 'Tồn tại'){
                                            if($item['suffix_v'] == 'slug'){
                                                echo 'id="convert_slug"';
                                            }else if($item['suffix_v'] == 'name'||$item['suffix_v'] == 'title'){
                                                echo 'onkeyup="ChangeToSlug()" id="slug"';
                                            }else if ($item['suffix_v'] == 'image'||$item['suffix_v'] == 'document') {
                                                echo 'id="file_'.$value['prefix_v'].'_'.$item['suffix_v'].'"';
                                            }else {
                                                echo 'id="'.$value['prefix_v'].'_'.$item['suffix_v'].'"';
                                            }
                                        }else {
                                            if ($item['suffix_v'] == 'image'||$item['suffix_v'] == 'document') {
                                                echo 'id="file_'.$value['prefix_v'].'_'.$item['suffix_v'].'"';
                                            }
                                            echo 'id="'.$value['prefix_v'].'_'.$item['suffix_v'].'"';
                                        }

                                        @endphp
                                        placeholder="Nhập vào {{$item['suffix_c'].' '.$value['prefix_c']}}"/>

                                    @endif

                                </div>
                            </div>
                        @endforeach


                    <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-primary" id="btn-save" value="Save changes" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
@endforeach
@endif

</div>


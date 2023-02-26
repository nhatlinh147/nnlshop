@extends('backend.admin-layout')
@section('content')
<style type="text/css">
    ul.drive {
        padding: 20px;
    }
    ul.drive li:not(:last-child) {
        margin-left: 2rem;
        list-style-type: decimal;
    }
    ul.drive li:last-child {
        list-style-type: none;
        margin-top: 20px;
    }
    ul.drive li {
        color: #000;
        font-weight: 400;
        line-height: 180%;
    }
    .title-ggdrive{
        text-align: center;
    }
</style>

<div class="row">
        <?php
            $i = 1;
        ?>
		@foreach($contents as $value)
        <ul class="drive">
        <h3 class="title-ggdrive">File Google Drive Thứ {{$i++}}</h3>
		<li>Name : {{$value['name']}}</li>
		<li>Path : {{$value['path']}}</li>
		<li>Basename : {{$value['basename']}}</li>
		<li>Mimetype : {{$value['mimetype']}}</li>
		<li>Type : {{$value['type']}}</li>
		<li>Mimetype : {{$value['size']}}</li>
        <li>Filename : {{$value['filename']}}</li>

		<li>Download file cách 1 : <a href="https://drive.google.com/file/d/{{$value['path']}}/view" target="_blank">Tải</a></li>

		<li>Download file cách 2 :  <a href="{{url('download-document', [ 'path'=>$value['path'], 'name'=>$value['name'] ])}}">Tải</a>
            {{-- Download file cách 2 :  <a href="{{url('download-document/'.$value['path'].'/'.$value['name'])}}">Tải</a> --}}
		</li>

		<li>Delete : <a href="{{url('delete-document', [ 'path'=> $value['path'] ])}}">Delete</a></li>

		<li><iframe src="https://drive.google.com/file/d/{{$value['path']}}/preview" width="640" height="640"></iframe></iframe>


			</li>
        </ul>
			@endforeach





</div>
@endsection


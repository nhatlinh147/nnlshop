<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;
use App\Model\SlideModel;

use Image;
use DB;
use Session;

class SlideController extends Controller
{
    public function list_slide()
    {
        return view('backend.slide.all-slide');
    }

    public function list_slide_json()
    {
        $info = [
            'data' => [],
        ];
        $slide = SlideModel::all();
        $info['data'] = $slide;

        return $info;
    }
    public function save_slide(request $request)
    {
        $data = $request->all();

        $request_image =  $request->file('slide_image');
        $path_slide = 'public/upload/slide/';

        if ($request_image) {
            $slideImage = current(explode('.', $request_image->getClientOriginalName())) . '-' .  rand(0, 101) . '.' .  $request_image->getClientOriginalExtension();

            $img = Image::make($request_image->path());
            $img->resize(1000, 430, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path_slide . $slideImage);

            // $request_image->move($path_slide, $slideImage);
        } else {
            $slideImage = SlideModel::where('Slide_ID', $data['slide_id'])->first()->Slide_Image;
        }

        $slideId = $data['slide_id'];
        $slide  =   SlideModel::updateOrCreate(
            ['Slide_ID' => $slideId],
            [
                'Slide_Title' => $data['slide_title'],
                'Slide_More' => $data['slide_more'],
                'Slide_Image' => $slideImage,
                'Slide_Desc' => $data['slide_desc'],
                'Meta_Keywords_Slide' => $data['meta_keywords_slide'],
                'Slide_Status' => $data["slide_status"],
            ]
        );
        // $first_slide = SlideModel::where('Slide_Image', $slideImage)->first();

        if ($data['get_image'] && $request_image) {
            unlink($path_slide . $data['get_image']);
        }

        return response()->json($slide);
    }
    public function edit_slide($slide_id)
    {
        $where = array('Slide_ID' => $slide_id);
        $slide  = SlideModel::where($where)->first();
        return response()->json($slide);
    }

    public function delete_slide($slide_id)
    {
        $slide = SlideModel::where('Slide_ID', $slide_id)->first();
        unlink('public/upload/slide/' . $slide->Slide_Image);
        SlideModel::where('Slide_ID', $slide_id)->delete();
        return response()->json($slide);
    }
    public function delete_slide_selected(Request $request)
    {
        $data = $request->ajax();
        $get_slide = SlideModel::whereIn('Slide_ID', $request->ids)->get();
        foreach ($get_slide as $value) {
            unlink('public/upload/slide/' . $value->Slide_Image);
        }
        $slide = SlideModel::whereIn('Slide_ID', $request->ids)->delete();

        return response()->json($slide);
    }
}
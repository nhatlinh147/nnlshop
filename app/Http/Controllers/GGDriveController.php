<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Support\Facades\Redirect;
use Storage;
use File;
use Auth;
use PDF;

class GGDriveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_file()
    {
        $filename = 'co-so-du-lieu.pdf';
        $filePath = public_path('upload/document/co-so-du-lieu__session-02_erd-and-normalization - [cuuduongthancong.com].pdf');
        $fileData = File::get($filePath);
        Storage::disk('google')->put($filename, $fileData);
        return 'File PDF Uploaded';
    }
    public function create_document()
    {
        Storage::disk('google')->put('test.txt', 'Nguyễn Nhất Linh');
        dd('created');
    }
    public function upload_image()
    {
        $filename = 'cttn.jpg';
        $filePath = public_path('upload/document/132201169_2122813121185869_7798491291681801231_o.jpg');
        $fileData = File::get($filePath);
        Storage::cloud()->put($filename, $fileData); // File lấy được sẽ gắn với tên tùy biến do coder đặt
        return 'Image Uploaded';
    }
    public function upload_video()
    {
        $filename = 'do-ta-khong-do-nang.mp4';
        $filePath = public_path('upload/document/videoplayback (online-video-cutter.com).mp4');
        $fileData = File::get($filePath);
        Storage::cloud()->put($filename, $fileData);
        return 'Video Uploaded';
    }

    public function download_document($path, $name)
    {
        $contents = collect(Storage::cloud()->listContents('/', false))
            ->where('type', '=', 'file')
            ->where('path', '=', $path)
            ->first();

        $filename_download = $name;


        $rawData = Storage::cloud()->get($path);

        return response($rawData, 200)
            ->header('Content-Type', $contents['mimetype'])
            ->header('Content-Disposition', " attachment; filename=$filename_download ");

        return redirect()->back();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create_folder()
    {
        Storage::cloud()->makeDirectory('Path_Child_1_Created');
        dd('created folder');
    }
    public function rename_folder()
    {
        $folderinfo = collect(Storage::cloud()->listContents('/', false))
            ->where('type', 'dir')
            ->where('name', 'Path_Child_1') // tên cũ của folder
            ->first();

        Storage::cloud()->move($folderinfo['path'], 'Path_Child_1_Renamed'); // tên mới của folder
        dd('renamed folder');
    }
    public function delete_folder()
    {

        $folderinfo = collect(Storage::cloud()->listContents('/', false))
            ->where('type', 'dir')
            ->where('name', 'Path_Child_1_Created')
            ->first();

        Storage::cloud()->delete($folderinfo['path']);
        dd('deleted folder');
    }

    public function list_document()
    {
        $dir = '/'; // đường dẫn đến thư mục folderId
        $recursive = true; // Có lấy file trong các thư mục con không?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive))
            ->where('type', '!=', 'dir'); // xác định loại bỏ các thư mục con dạng tệp folder
        return $contents;
    }

    public function delete_document($path)
    {

        $fileinfo = collect(Storage::cloud()->listContents('/', false))
            ->where('type', 'file')
            ->where('path', $path)
            ->first();

        Storage::cloud()->delete($fileinfo['path']);

        return redirect()->back();
    }

    public function read_data()
    {
        $dir = '/';
        $recursive = false; // Có lấy file trong các thư mục con không?

        $contents = collect(Storage::cloud()->listContents($dir, $recursive))
            ->where('type', '!=', 'dir');

        return view('backend.list-info-file')->with(compact('contents'));
    }
}
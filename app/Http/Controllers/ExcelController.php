<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ExportExcelProduct;
use App\Imports\ImportExcelProduct;
use App\Model\Product;
use Excel;
use PDF;
use Illuminate\Support\Facades\Session;
use DB;

use  App\Jobs\NotifyUserOfCompletedImport;
use  App\Jobs\NotifyUserOfCompletedExport;

class ExcelController extends Controller
{
    public function export_excel()
    {
        return Excel::download(new ExportExcelProduct, 'Product.xlsx');
    }
    public function export_pdf()
    {
        $all_product = Product::all();
        $view = \View::make('exportimport.product-pdf')->with(compact('all_product'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf = \PDF::loadHTML($view);
        return $pdf->stream("printf_product.pdf");
    }
    public function import_excel_product(Request $request)
    {
        $path = $request->file('product_excel')->getRealPath(); // Lấy path
        $get_product = Product::find(18);

        $import = (new ImportExcelProduct($get_product))->queue($path)->chain([
            new NotifyUserOfCompletedImport($get_product)
        ]);

        $get_notify = DB::table('notifications')->Where('notifiable_type', 'App\Model\Product')->first();

        if ($get_notify) {
            DB::table('notifications')->Where('notifiable_type', 'App\Model\Product')->delete();
            Session::flash('get_errors', $get_notify->data);
        }

        return back();
    }

    function isJson($string)
    {
        return is_object(json_decode($string)) ? true : false;
    }
    public function get_notify_product(Request $request)
    {
        foreach (DB::table('notifications')->where('notifiable_type', 'App\Model\Product')->get() as $value) {
            if ($this->isJson($value->data) == false) {
                $get_notify_success = json_decode($value->data);
                $get_notify_data = 0;
            } else {
                $get_notify_success = 0;
                foreach (json_decode($value->data, true) as $value) {
                    $get_notify_data[] =  $value[0];
                }
            }
        }

        $chart_data = [
            "get_notify_success" => $get_notify_success,
            "get_notify_data" => $get_notify_data
        ];
        // lưu ý: echo json_encode() sẽ khó chuyển từ tiếng việt tổ hợp sang dựng sẵn
        return response()->json($chart_data);
    }
}
<?php

namespace App\Imports;

use App\Model\Product;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\AddProductQueue;
use App\Jobs\ControllerQueueJob;
use Maatwebsite\Excel\Events\ImportFailed;

use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Notifications\ImportHasFailedNotification;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Illuminate\Support\Facades\Notification;

use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

HeadingRowFormatter::default('none'); //Bỏ qua tiêu đề trong dữ liệu ản phẩm

class ImportExcelProduct implements
    ToCollection,
    WithHeadingRow,
    ShouldQueue,
    WithChunkReading,
    WithEvents
{
    use Importable;

    public function __construct($importedBy)
    {
        $this->importedBy = $importedBy;
    }

    public function collection(Collection $rows)
    {
        Validator::make(
            $rows->toArray(),
            [
                '*.Tên sản phẩm' => ['required'],
                '*.Slug sản phẩm' => ['required'],
                '*.Danh mục' => ['required'],
                '*.Tóm tắt sản phẩm' => ['required'],
                '*.Mô tả sản phẩm' => ['required'],
                '*.Nội dung sản phẩm' => ['required'],
                '*.Giá sản phẩm' => ['required'],
                '*.Giá gốc sản phẩm' => ['required'],
                '*.Số lượng sản phẩm' => ['required'],
                '*.Hình ảnh sản phẩm' => ['required'],
                '*.Trạng thái sản phẩm' => ['required'],
                '*.Tài liệu' => ['required'],
                '*.Đường dẫn' => ['required'],
                '*.Tag sản phẩm' => ['required']
            ],
            [
                '*.Tên sản phẩm.required' => 'Hàng :attribute không được để trống',
                '*.Slug sản phẩm.required' => 'Hàng :attribute không được để trống',
                '*.Danh mục.required' => "Hàng :attribute không được để trống",
                '*.Tóm tắt sản phẩm.required' => "Hàng :attribute không được để trống",
                '*.Mô tả sản phẩm.required' => 'Hàng :attribute không được để trống',
                '*.Nội dung sản phẩm.required' => 'Hàng :attribute không được để trống',
                '*.Giá sản phẩm.required' => 'Hàng :attribute không được để trống',
                '*.Giá gốc sản phẩm.required' => 'Hàng :attribute không được để trống',
                '*.Số lượng sản phẩm.required' => 'Hàng :attribute không được để trống',
                '*.Hình ảnh sản phẩm.required' => 'Hàng :attribute không được để trống',
                '*.Trạng thái sản phẩm.required' => 'Hàng :attribute không được để trống',
                '*.Tài liệu.required' => 'Hàng :attribute không được để trống',
                '*.Đường dẫn.required' => 'Hàng :attribute không được để trống',
                '*.Tag sản phẩm.required' => 'Hàng :attribute không được để trống'
            ]
        )->validate();

        foreach ($rows as $row) {
            if ($row['Số lượng view']) {
                $view = $row['Số lượng view'];
            } else {
                $view = 0;
            }
            Product::create([
                'Meta_Keywords_Product' => $row['Từ khóa thẻ meta'],
                'Product_Name' => $row['Tên sản phẩm'],
                'Product_Slug' => $row['Slug sản phẩm'],
                'Category_ID' => $row['Danh mục'],
                'Product_Summary' => $row['Tóm tắt sản phẩm'],
                'Product_Desc' => $row['Mô tả sản phẩm'],
                'Product_Content' => $row['Nội dung sản phẩm'],
                'Product_Price' =>  filter_var($row['Giá sản phẩm'], FILTER_SANITIZE_NUMBER_INT),
                'Product_Cost' =>  filter_var($row['Giá gốc sản phẩm'], FILTER_SANITIZE_NUMBER_INT),
                'Product_Quantity' => filter_var($row['Số lượng sản phẩm'], FILTER_SANITIZE_NUMBER_INT),
                'Product_Image' => $row['Hình ảnh sản phẩm'],
                'Product_Status' => $row['Trạng thái sản phẩm'],
                'Product_Document' => $row['Tài liệu'],
                'Product_Path' => $row['Đường dẫn'],
                'Product_Tag' => $row['Tag sản phẩm'],
                'Product_View' => $view,
            ]);
        }
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function (ImportFailed $errorsValidation) {
                // Product::find(12)->notify(new ImportHasFailedNotification("Lần thứ 4"));
                $errors = $errorsValidation->getException()->errors();
                // dd($errors);
                $this->importedBy->notify(new ImportHasFailedNotification($errors));
            },
        ];
    }

    public function headingRow(): int
    {
        return 2;
    }
    public function chunkSize(): int
    {
        return 300;
    }
}
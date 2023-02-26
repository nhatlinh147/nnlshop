<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use App\Imports\ToCollectionImport;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

use App\Model\Product;

HeadingRowFormatter::default('none');

class ProductContentImport extends ToCollectionImport implements
    ShouldQueue,
    SkipsOnError,
    SkipsOnFailure,
    WithValidation,
    WithHeadingRow,
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param Collection $rows
     */
    public function processImport(Collection $rows)
    {
        foreach ($rows as $row) {
           Product::create([
                'Meta_Keywords_Product' => $row['Từ khóa thẻ meta'],
                'Product_Name' => $row['Tên sản phẩm'],
                'Product_Slug' => $row['Slug sản phẩm'],
                'Category_ID' => $row['Danh mục'],
                'Brand_ID' => $row['Thương hiệu'],
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

    public function rules(): array
    {
        return [
            '*.Tên sản phẩm' => ['required'],
            '*.Slug sản phẩm' => ['required'],
            '*.Danh mục' => ['required'],
            '*.Thương hiệu' => ['required'],
            '*.Mô tả sản phẩm' => ['required'],
            '*.Nội dung sản phẩm' => ['required'],
            '*.Giá sản phẩm' => ['required'],
            '*.Giá gốc sản phẩm' => ['required'],
            '*.Số lượng sản phẩm' => ['required'],
            '*.Hình ảnh sản phẩm' => ['required'],
            '*.Trạng thái sản phẩm' => ['required'],
            '*.Tài liệu' => ['required', 'mimes:pdf'],
            '*.Đường dẫn' => ['required'],
            '*.Tag sản phẩm' => ['required']
        ];
    }
    public function headingRow(): int
    {
        return 2;
    }
}
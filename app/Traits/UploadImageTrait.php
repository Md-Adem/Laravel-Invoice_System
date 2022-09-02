<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UploadImageTrait
{

    public function uploadImage(Request $request, $folderName)
    {

        $invoice_number = $request->invoice_number;
        $imageName = $invoice_number . '-' . date_format(date_create(), "YmdHis") . '.png';
        $path = $request->file('pic')->storeAs($folderName, $imageName, 'public_uploads');

        return $path;
    }
}

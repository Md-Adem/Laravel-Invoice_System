<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;
use App\Models\invoices_details;
use App\Models\invoices_attachments;
use Illuminate\Support\Facades\Storage;
use File;



class InvoicesDetailsController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(invoices_details $invoices_details)
    {
        //
    }


    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();

        $details = invoices_details::where('invoice_id', $id)->get();

        $attachments = invoices_attachments::where('invoice_id', $id)->get();

        return view('invoices.invoices_details', compact('invoices', 'details', 'attachments'));
    }


    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }


    public function destroy(invoices_details $invoices_details)
    {
        //
    }

    public function open_file($file_name)
    {
        // $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
        $files = Storage::disk('public_uploads')->get($file_name);
        return response()->file($files);
    }

    public function get_file($invoice_number, $file_name)
    {

        // $files = Storage::disk('public_uploads')->get($invoice_number . '/' . $file_name);
        // $files = Storage::download('public_uploads', $file_name);
        return Storage::download($file_name);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class invoiceArchiveController extends Controller
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


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        $id = $request->invoice_id;

        $archived = invoices::withTrashed()->where('id', $id)->restore();
        session()->flash('archive_restore');
        return redirect('/invoices_archive');
    }


    public function destroy($id)
    {
        //
    }
}

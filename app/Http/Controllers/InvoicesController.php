<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;
use App\Models\invoices_details;
use App\Traits\UploadImageTrait;
use App\Notifications\ADDinvoice;
use Illuminate\Support\Facades\DB;
use App\Models\invoices_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notification;


class InvoicesController extends Controller
{
    use UploadImageTrait;

    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }


    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoice', compact('sections'));
    }


    public function store(Request $request)
    {
        invoices::create([

            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'غير مدفوعة',
            'status_value' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            // $file_name = $image->getClientOriginalName();
            // $file_name = date_format(date_create(), "YmdHis");

            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $this->uploadImage($request, 'invoice_attachments');
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic first metho old
            // $imageName = $request->pic->getClientOriginalName();
            // $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);

            // -------------//
            // second method new laravel
            // $imageName = date_format(date_create(), "YmdHis");
            // $request->file('pic')->storeAs('invoice_attachments', $imageName . '.png', 'public_uploads');

            // using traits
            // $this->uploadImage($request, 'invoice_admin');
        }

        // $user = User::first();
        // $user->notify(new ADDinvoice($invoice_id));

        // another method
        // Notification::send($user, new ADDinvoice($invoice_id));


        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }


    public function show($id)
    {
        $invoices = invoices::WHERE('id', $id)->first();
        return view('invoices.update_status', compact('invoices'));
    }


    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = sections::all();

        return view('invoices.edit_invoice', compact('invoices', 'sections'));
    }


    public function update(Request $request)
    {
        $invoices = invoices::find($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }


    public function destroy(Request $request)
    {

        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();

        $id_page = $request->id_page;


        if (!$id_page == 2) {


            $invoices->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');
        } else {

            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/invoices');
        }
    }



    public function getproducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }


    public function update_status($id, Request $request)
    {
        $invoices = invoices::find($id);

        if ($request->status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);

            invoices_details::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'status_value' => 1,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);
            invoices_Details::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'status_value' => 3,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('update_status');
        return redirect('/invoices');
    }

    public function invoices_paid()
    {
        $invoices = invoices::where('value_status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }


    public function invoices_unpaid()
    {
        $invoices = invoices::where('value_status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }

    public function invoices_partial()
    {
        $invoices = invoices::where('value_status', 3)->get();
        return view('invoices.invoices_partial', compact('invoices'));
    }

    public function invoices_archive()
    {
        $invoices = invoices::onlyTrashed()->get();
        return view('invoices.invoices_archive', compact('invoices'));
    }


    public function archive_restore(Request $request)
    {

        $id = $request->invoice_id;

        $archived = invoices::withTrashed()->where('id', $id);
        $archived->restore();
        session()->flash('archive_restore');
        return redirect('/invoices');
    }

    public function archive_destroy(Request $request)
    {

        $id = $request->invoice_id;

        $archived = invoices::withTrashed()->where('id', $id)->first();
        $archived->forceDelete();
        session()->flash('archive_destroy');
        return redirect('/invoices_archive');
    }


    public function print_invoice($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.print_invoice', compact('invoices'));
    }
}

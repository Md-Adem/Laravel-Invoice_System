<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
use App\Models\sections;

class InvoicesReportController extends Controller
{
    public function index()
    {

        return view('reports.invoices_report');
    }



    public function search_invoices(Request $request)
    {
        $rdio = $request->rdio;

        // in case search by invoice type

        if ($rdio == 1) {

            // in case didnt select search date

            if ($request->type && $request->start_at == '' && $request->end_at == '') {


                $invoices = invoices::select('*')->where('status', '=', $request->type)->get();
                $type = $request->type;

                return view('reports.invoices_report', compact('type', 'invoices'));

                // in case select search date

            } else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;


                $invoices = invoices::whereBetween('invoice_date', [$start_at, $end_at])->where('status', '=', $request->type)->get();
                return view('reports.invoices_report', compact('type', 'start_at', 'end_at', 'invoices'));
            }

            // in case search by invoice number

        } else {

            $invoices = invoices::select('*')->where('invoice_number', '=', $request->invoice_number)->get();


            return view('reports.invoices_report', compact('invoices'));
        }
    }



    //------------------------------------

    public function index_customers()
    {
        $sections = sections::all();
        return view('reports.customers_report', compact('sections'));
    }


    public function search_customers(Request $request)
    {

        // in case didnt select search date

        if ($request->section && $request->product && $request->start_at == '' && $request->end_at == '') {


            $invoices = invoices::select('*')->where('section_id', '=', $request->section)->where('product', '=', $request->product)->get();
            $sections = sections::all();
            return view('reports.customers_report', compact('sections', 'invoices'));
        }


        // in case select search date

        else {

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = invoices::whereBetween('invoice_date', [$start_at, $end_at])->where('section_id', '=', $request->section)->where('product', '=', $request->product)->get();
            $sections = sections::all();
            return view('reports.customers_report', compact('sections', 'invoices'));
        }
    }
}

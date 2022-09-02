<?php

namespace App\Http\Controllers;

use App\Models\invoices;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $Totalinvoices = invoices::count();
        $TotalInvoicesNotPaid = invoices::select('*')->where('value_status', 2)->count();
        $TotalInvoicesPaid = invoices::select('*')->where('value_status', 1)->count();
        $TotalInvoicesHalfPaid = invoices::select('*')->where('value_status', 3)->count();

        $TotalAmounts = invoices::sum('total');
        $TotalAmountsNotPaid = invoices::select('*')->where('value_status', 2)->sum('total');
        $TotalAmountsPaid = invoices::select('*')->where('value_status', 1)->sum('total');
        $TotalAmountsHalfPaid = invoices::select('*')->where('value_status', 3)->sum('total');


        /////////////////////////////////////////////

        $chartjs1 = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Label x', 'Label y'])
            ->datasets([
                [
                    "label" => "My First dataset",
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'
                    ],
                    'data' => [69, 59]
                ],
                [
                    "label" => "My First dataset",
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.3)', 'rgba(54, 162, 235, 0.3)'
                    ],
                    'data' => [65, 12]
                ]
            ])
            ->options([]);




        //=================احصائية نسبة تنفيذ الحالات======================



        $count_all = invoices::count();
        $count_invoices1 = invoices::where('Value_Status', 1)->count();
        $count_invoices2 = invoices::where('Value_Status', 2)->count();
        $count_invoices3 = invoices::where('Value_Status', 3)->count();

        if ($count_invoices2 == 0) {
            $nspainvoices2 = 0;
        } else {
            $nspainvoices2 = $count_invoices2 / $count_all * 100;
        }

        if ($count_invoices1 == 0) {
            $nspainvoices1 = 0;
        } else {
            $nspainvoices1 = $count_invoices1 / $count_all * 100;
        }

        if ($count_invoices3 == 0) {
            $nspainvoices3 = 0;
        } else {
            $nspainvoices3 = $count_invoices3 / $count_all * 100;
        }


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$nspainvoices2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$nspainvoices1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$nspainvoices3]
                ],


            ])
            ->options([]);


        /////////////////////////////////////////////


        $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214', '#ff9642'],
                    'data' => [$nspainvoices2, $nspainvoices1, $nspainvoices3]
                ]
            ])
            ->options([]);



        return view('home', compact(

            'Totalinvoices',
            'TotalInvoicesPaid',
            'TotalInvoicesHalfPaid',
            'TotalInvoicesNotPaid',
            'TotalAmounts',
            'TotalAmountsNotPaid',
            'TotalAmountsPaid',
            'TotalAmountsHalfPaid',
            'chartjs',
            'chartjs2'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{PayOrdersAcqV1, PayOrdersVernapayment, PayOrdersVernapaymentv1, PayOrdersVernapaymentv3, PayOrdersVernapaymentv4, User, ClientTransaction, WeeklyReports, ClientDetails};
use App\Export\Report;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Export\PayOrdersVernapaymentwithDate;
use App\Export\PayOrdersVernapaymentv1withDate;
use App\Export\PayOrdersVernapaymentv3withDate;
use App\Export\PayOrdersVernapaymentv4withDate;
use App\Export\PayOrdersAcqV1MrvwithDate;
use App\Export\PayOrdersAcqV1MstreetwithDate;
use App\Export\PayOrdersAcqV1RalseftwithDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ReportingController extends Controller
{
    public function index(Request $request)
    {

        return view('reporting.index', compact('request'));
    }

    public function Sales_index(Request $request)
    {

        $result_v1 = PayOrdersVernapayment::select();

        $result_v2 = PayOrdersVernapaymentv1::select();

        $result_v3 = PayOrdersVernapaymentv3::select();

        $result_v4 = PayOrdersVernapaymentv4::select();

        $resultmrv = PayOrdersAcqV1::where('merchantName', 'MRV')->select();

        $resultmstreet = PayOrdersAcqV1::where('merchantName', 'Mstreet')->select();

        $resultralseft = PayOrdersAcqV1::where('merchantName', 'Ralseft')->select();


        if ($request->s_date != null && $request->e_date != null) {
            // for v1

            $tusd_v1 = $result_v1->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('currency', 'USD')->sum('amount');

            $teur_v1 = $result_v1->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('currency', 'EUR')->sum('amount');

            // for v2

            $tusd_v2 = $result_v2->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('currency', 'USD')->sum('amount');

            $teur_v2 = $result_v2->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('currency', 'EUR')->sum('amount');

            // for v3

            $tusd_v3 = $result_v3->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('currency', 'USD')->sum('amount');

            $teur_v3 = $result_v3->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('currency', 'EUR')->sum('amount');


            // for v4

            $tusd_v4 = $result_v4->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('currency', 'USD')->sum('amount');

            $teur_v4 = $result_v4->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('currency', 'EUR')->sum('amount');


            // for mrv

            $tusd_mrv = $resultmrv->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('merchantName', 'MRV')->where('currency', 'USD')->sum('amount');

            $teur_mrv = $resultmrv->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('merchantName', 'MRV')->where('currency', 'EUR')->sum('amount');


            // for mstreet

            $tusd_mstreet = $resultmstreet->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('merchantName', 'Mstreet')->where('currency', 'USD')->sum('amount');

            $teur_mstreet = $resultmstreet->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('merchantName', 'Mstreet')->where('currency', 'EUR')->sum('amount');

            // for ralself

            $tusd_ral = $resultralseft->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('merchantName', 'Ralseft')->where('currency', 'USD')->sum('amount');

            $teur_ral = $resultralseft->when(
                $request->s_date && $request->e_date,
                function (Builder $builder) use ($request) {
                    $builder->whereBetween(
                        DB::raw('DATE(orderDate)'),
                        [
                            $request->s_date,
                            $request->e_date
                        ]
                    );
                }
            )->where('merchantName', 'Ralseft')->where('currency', 'EUR')->sum('amount');
        } elseif ($request->s_date != null) {
            // for v1

            $tusd_v1 = $result_v1->where('currency', 'USD')->whereDate('orderDate', $request->s_date)->sum('amount');


            $teur_v1 = $result_v1->where('currency', 'EUR')->whereDate('orderDate', $request->s_date)->sum('amount');

            // for v2

            $tusd_v2 = $result_v2->where('currency', 'USD')->whereDate('orderDate', $request->s_date)->sum('amount');


            $teur_v2 = $result_v2->where('currency', 'EUR')->whereDate('orderDate', $request->s_date)->sum('amount');

            // for v3

            $tusd_v3 = $result_v3->where('currency', 'USD')->whereDate('orderDate', $request->s_date)->sum('amount');


            $teur_v3 = $result_v3->where('currency', 'EUR')->whereDate('orderDate', $request->s_date)->sum('amount');

            // for v4

            $tusd_v4 = $result_v4->where('currency', 'USD')->whereDate('orderDate', $request->s_date)->sum('amount');


            $teur_v4 = $result_v4->where('currency', 'EUR')->whereDate('orderDate', $request->s_date)->sum('amount');


            // for mrv

            $tusd_mrv = $resultmrv->where('currency', 'USD')->whereDate('orderDate', $request->s_date)->sum('amount');


            $teur_mrv = $resultmrv->where('currency', 'EUR')->whereDate('orderDate', $request->s_date)->sum('amount');


            // for mstreet

            $tusd_mstreet = $resultmstreet->where('currency', 'USD')->whereDate('orderDate', $request->s_date)->sum('amount');


            $teur_mstreet = $resultmstreet->where('currency', 'EUR')->whereDate('orderDate', $request->s_date)->sum('amount');


            // for ralself

            $tusd_ral = $resultralseft->where('currency', 'USD')->whereDate('orderDate', $request->s_date)->sum('amount');


            $teur_ral = $resultralseft->where('currency', 'EUR')->whereDate('orderDate', $request->s_date)->sum('amount');
        } elseif ($request->e_date != null) {
            // for v1
            $tusd_v1 = $result_v1->where('currency', 'USD')->whereDate('orderDate', $request->e_date)->sum('amount');


            $teur_v1 = $result_v1->where('currency', 'EUR')->whereDate('orderDate', $request->e_date)->sum('amount');

            // for v2

            $tusd_v2 = $result_v2->where('currency', 'USD')->whereDate('orderDate', $request->e_date)->sum('amount');


            $teur_v2 = $result_v2->where('currency', 'EUR')->whereDate('orderDate', $request->e_date)->sum('amount');


            // for v3

            $tusd_v3 = $result_v3->where('currency', 'USD')->whereDate('orderDate', $request->e_date)->sum('amount');


            $teur_v3 = $result_v3->where('currency', 'EUR')->whereDate('orderDate', $request->e_date)->sum('amount');

            // for v4

            $tusd_v4 = $result_v4->where('currency', 'USD')->whereDate('orderDate', $request->e_date)->sum('amount');


            $teur_v4 = $result_v4->where('currency', 'EUR')->whereDate('orderDate', $request->e_date)->sum('amount');


            // for mrv

            $tusd_mrv = $resultmrv->where('currency', 'USD')->whereDate('orderDate', $request->e_date)->sum('amount');


            $teur_mrv = $resultmrv->where('currency', 'EUR')->whereDate('orderDate', $request->e_date)->sum('amount');


            // for mstreet

            $tusd_mstreet = $resultmstreet->where('currency', 'USD')->whereDate('orderDate', $request->e_date)->sum('amount');


            $teur_mstreet = $resultmstreet->where('currency', 'EUR')->whereDate('orderDate', $request->e_date)->sum('amount');


            // for ralself

            $tusd_ral = $resultralseft->where('currency', 'USD')->whereDate('orderDate', $request->e_date)->sum('amount');


            $teur_ral = $resultralseft->where('currency', 'EUR')->whereDate('orderDate', $request->e_date)->sum('amount');
        } else {
            // for v1

            $tusd_v1 = $result_v1->where('currency', 'USD')->whereDate('orderDate', '=', '2023-11-24')->sum('amount');


            $teur_v1 = $result_v1->where('currency', 'EUR')->whereDate('orderDate', '=', '2023-11-24')->sum('amount');

            // for v2

            $tusd_v2 = $result_v2->where('currency', 'USD')->whereDate('orderDate', '=', '2023-11-24')->sum('amount');


            $teur_v2 = $result_v2->where('currency', 'EUR')->whereDate('orderDate', '=', '2023-11-24')->sum('amount');

            // for v3

            $tusd_v3 = $result_v3->where('currency', 'USD')->whereDate('orderDate', '=', '2023-11-24')->sum('amount');


            $teur_v3 = $result_v3->where('currency', 'EUR')->whereDate('orderDate', '=', '2023-11-24')->sum('amount');

            // for v4

            $tusd_v4 = $result_v4->where('currency', 'USD')->whereDate('orderDate', '=', '2023-11-24')->sum('amount');


            $teur_v4 = $result_v4->where('currency', 'EUR')->whereDate('orderDate', '=', '2023-11-24')->sum('amount');


            // for mrv

            $tusd_mrv = $resultmrv->where('currency', 'USD')->whereDate('orderDate', '=', '2023-11-2')->sum('amount');


            $teur_mrv = $resultmrv->where('currency', 'EUR')->whereDate('orderDate', '=', '2023-11-2')->sum('amount');


            // for mstreet

            $tusd_mstreet = $resultmstreet->where('currency', 'USD')->whereDate('orderDate', '=', '2023-11-2')->sum('amount');


            $teur_mstreet = $resultmstreet->where('currency', 'EUR')->whereDate('orderDate', '=', '2023-11-2')->sum('amount');


            // for ralself

            $tusd_ral = $resultralseft->where('currency', 'USD')->whereDate('orderDate', '=', '2023-11-2')->sum('amount');


            $teur_ral = $resultralseft->where('currency', 'EUR')->whereDate('orderDate', '=', '2023-11-2')->sum('amount');
        }

        //for v1 

        $totalusdv1 = round($tusd_v1, 2);

        $totaleurv1 = round($teur_v1, 2);

        // for v2

        $totalusdv2 = round($tusd_v2, 2);

        $totaleurv2 = round($teur_v2, 2);

        // for v3

        $totalusdv3 = round($tusd_v3, 2);

        $totaleurv3 = round($teur_v3, 2);

        // for v4

        $totalusdv4 = round($tusd_v4, 2);

        $totaleurv4 = round($teur_v4, 2);

        // for mrv

        $totalusdmrv = round($tusd_mrv, 2);

        $totaleurmrv = round($teur_mrv, 2);

        // for mstreet

        $totalusdmstreet = round($tusd_mstreet, 2);

        $totaleurmstreet = round($teur_mstreet, 2);

        // for ralseft

        $totalusdralseft = round($tusd_ral, 2);

        $totaleurralseft = round($teur_ral, 2);



        return view('reporting.sales', compact('request', 'totalusdv1', 'totaleurv1', 'totalusdv2', 'totaleurv2', 'totalusdv3', 'totaleurv3', 'totalusdv4', 'totaleurv4', 'totalusdmrv', 'totaleurmrv', 'totalusdmstreet', 'totaleurmstreet', 'totalusdralseft', 'totaleurralseft'));
    }

    public function new_Report_Index(Request $request)
    {
        return view('reporting.report_new', compact('request'));
    }

    // public function new_Post_Report_Index(Request $request)
    // {


    //     if($request->input('chargebackto') && $request->input('chargebackfrom'))
    //     {

    //         $s_date = $request->input('chargebackfrom');
    //         $e_date = $request->input('chargebackto');
    //         // $s_date='2023-11-26';
    //         // $e_date='2023-11-30';


    //         $result_c_1 = PayOrdersAcqV1::whereNotNull('chargeback_date')->whereBetween('chargeback_date', [$s_date, $e_date])->count();

    //         $result_c_2 = PayOrdersVernapayment::whereNotNull('chargeback_date')->whereBetween('chargeback_date', [$s_date, $e_date])->count();

    //         $result_c_3 = PayOrdersVernapaymentv1::whereNotNull('chargeback_date')->whereBetween('chargeback_date', [$s_date, $e_date])->count();

    //         $result_c_4 = PayOrdersVernapaymentv3::whereNotNull('chargeback_date')->whereBetween('chargeback_date', [$s_date, $e_date])->count();

    //         $result_c_5 = PayOrdersVernapaymentv4::whereNotNull('chargeback_date')->whereBetween('chargeback_date', [$s_date, $e_date])->count();

    //     }

    //     elseif($request->input('cardtypeFilter'))
    //     {

    //         $search = $request->input('cardtypeFilter');

    //         $result_c_1 = PayOrdersAcqV1::where('card_type',  $search )->count();

    //         $result_c_2 = PayOrdersVernapayment::where('card_type',  $search )->count();

    //         $result_c_3 = PayOrdersVernapaymentv1::where('card_type',  $search )->count();

    //         $result_c_4 = PayOrdersVernapaymentv3::where('card_type',  $search )->count();

    //         $result_c_5 = PayOrdersVernapaymentv4::where('card_type',  $search )->count();

    //     }

    //     elseif($request->input('amountFilter'))
    //     {

    //         $search = $request->input('amountFilter');

    //         $result_c_1 = PayOrdersAcqV1::where('amount',  $search )->count();

    //         $result_c_2 = PayOrdersVernapayment::where('amount',  $search )->count();

    //         $result_c_3 = PayOrdersVernapaymentv1::where('amount',  $search )->count();

    //         $result_c_4 = PayOrdersVernapaymentv3::where('amount',  $search )->count();

    //         $result_c_5 = PayOrdersVernapaymentv4::where('amount',  $search )->count();

    //     }

    //     elseif(empty($request->input('search.value')))
    //     {

    //         $result_c_1 = PayOrdersAcqV1::count();

    //         $result_c_2 = PayOrdersVernapayment::count();

    //         $result_c_3 = PayOrdersVernapaymentv1::count();

    //         $result_c_4 = PayOrdersVernapaymentv3::count();

    //         $result_c_5 = PayOrdersVernapaymentv4::count();

    //     }

    //     else
    //     {

    //         $search = $request->input('search.value');

    //         $result_c_1 = PayOrdersAcqV1::where('fullName','LIKE',"%{$search}%")
    //                         ->orWhere('merchantName', 'LIKE',"%{$search}%")
    //                         ->orWhere('phone', 'LIKE',"%{$search}%")
    //                         ->orWhere('cardnum', 'LIKE',"%{$search}%")
    //                         ->count();

    //         $result_c_2 = PayOrdersVernapayment::where('fullName','LIKE',"%{$search}%")
    //                         ->orWhere('merchantName', 'LIKE',"%{$search}%")
    //                         ->orWhere('phone', 'LIKE',"%{$search}%")
    //                         ->orWhere('cardnum', 'LIKE',"%{$search}%")
    //                         ->count();

    //         $result_c_3 = PayOrdersVernapaymentv1::where('fullName','LIKE',"%{$search}%")
    //                         ->orWhere('merchantName', 'LIKE',"%{$search}%")
    //                         ->orWhere('phone', 'LIKE',"%{$search}%")
    //                         ->orWhere('cardnum', 'LIKE',"%{$search}%")
    //                         ->count();

    //         $result_c_4 = PayOrdersVernapaymentv3::where('fullName','LIKE',"%{$search}%")
    //                         ->orWhere('merchantName', 'LIKE',"%{$search}%")
    //                         ->orWhere('phone', 'LIKE',"%{$search}%")
    //                         ->orWhere('cardnum', 'LIKE',"%{$search}%")
    //                         ->count();

    //         $result_c_5 = PayOrdersVernapaymentv4::where('fullName','LIKE',"%{$search}%")
    //                         ->orWhere('merchantName', 'LIKE',"%{$search}%")
    //                         ->orWhere('phone', 'LIKE',"%{$search}%")
    //                         ->orWhere('cardnum', 'LIKE',"%{$search}%")
    //                         ->count();

    //     }


    //     $final_report_count = $result_c_1+$result_c_2+$result_c_3+$result_c_4+$result_c_5;

    //     $columns = array( 
    //                         0 =>'orderDate', 
    //                         1 =>'orderStatus',
    //                         2=> 'bank_charge',
    //                         3=> 'refund_status',
    //                         4=> 'included_report',
    //                         5=> 'merchant_name',
    //                         6=> 'full_name',
    //                         7=> 'email',
    //                         8=> 'country',
    //                         9=> 'phone',
    //                         10=> 'card_no',
    //                         11=> 'bank_name',
    //                         12=> 'description',
    //                         13=> 'profile',
    //                         14=> 'card_type',
    //                         15=> 'amount',
    //                         16=> 'currency',
    //                         17=> 'invoice_number',
    //                         18=> 'client',
    //                         19=> 'order_message',
    //                         20=> 'transaction_id',
    //                         21=> 'order_paid'
    //                     );

    //     $totalData = $final_report_count;

    //     $totalFiltered = $totalData; 

    //     $limit = $request->input('length');
    //     $start = $request->input('start');

    //     if($request->input('chargebackto') && $request->input('chargebackfrom'))
    //     {

    //         // $s_date = $request->input('chargebackfrom');
    //         // $e_date = $request->input('chargebackto');
    //         $s_date='2023-11-26';
    //         $e_date='2023-11-30';

    //         $result1 = PayOrdersAcqV1::whereNotNull('chargeback_date')->whereBetween('chargeback_date', [$s_date, $e_date])->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result2 = PayOrdersVernapayment::whereNotNull('chargeback_date')->whereBetween('chargeback_date', [$s_date, $e_date])->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result3 = PayOrdersVernapaymentv1::whereNotNull('chargeback_date')->whereBetween('chargeback_date', [$s_date, $e_date])->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result4 = PayOrdersVernapaymentv3::whereNotNull('chargeback_date')->whereBetween('chargeback_date', [$s_date, $e_date])->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result5 = PayOrdersVernapaymentv4::whereNotNull('chargeback_date')->whereBetween('chargeback_date', [$s_date, $e_date])->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get(); 

    //         $report1 = array_merge($result1->toArray(),$result2->toArray());
    //         $report2  = array_merge($result3->toArray(),$result4->toArray());
    //         $report3  = array_merge($report1,$report2);

    //         $final_report = array_merge($report3,$result5->toArray());

    //         $posts =  $final_report;

    //     }

    //     elseif($request->input('cardtypeFilter'))
    //     {

    //         $search = $request->input('cardtypeFilter');

    //         $result1 = PayOrdersAcqV1::where('card_type',  $search )
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result2 = PayOrdersVernapayment::where('card_type',  $search )
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result3 = PayOrdersVernapaymentv1::where('card_type', $search )
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result4 = PayOrdersVernapaymentv3::where('card_type', $search )
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result5 = PayOrdersVernapaymentv4::where('card_type', $search )
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get(); 

    //         $report1 = array_merge($result1->toArray(),$result2->toArray());
    //         $report2  = array_merge($result3->toArray(),$result4->toArray());
    //         $report3  = array_merge($report1,$report2);

    //         $final_report = array_merge($report3,$result5->toArray());

    //         $posts =  $final_report;

    //     }

    //     elseif($request->input('amountFilter'))
    //     {

    //         $search = $request->input('amountFilter');

    //         $result1 = PayOrdersAcqV1::where('amount',  $search )
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result2 = PayOrdersVernapayment::where('amount',  $search )
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result3 = PayOrdersVernapaymentv1::where('amount', $search )
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result4 = PayOrdersVernapaymentv3::where('amount', $search )
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result5 = PayOrdersVernapaymentv4::where('amount', $search )
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get(); 

    //         $report1 = array_merge($result1->toArray(),$result2->toArray());
    //         $report2  = array_merge($result3->toArray(),$result4->toArray());
    //         $report3  = array_merge($report1,$report2);

    //         $final_report = array_merge($report3,$result5->toArray());

    //         $posts =  $final_report;

    //     }

    //     elseif(empty($request->input('search.value')))
    //     {

    //         $result1 = PayOrdersAcqV1::offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result2 = PayOrdersVernapayment::offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result3 = PayOrdersVernapaymentv1::offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result4 = PayOrdersVernapaymentv3::offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result5 = PayOrdersVernapaymentv4::offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $report1 = array_merge($result1->toArray(),$result2->toArray());
    //         $report2  = array_merge($result3->toArray(),$result4->toArray());
    //         $report3  = array_merge($report1,$report2);

    //         $final_report = array_merge($report3,$result5->toArray());

    //         $posts =  $final_report;

    //     }

    //     else 
    //     {
    //         $search = $request->input('search.value');

    //         $result1 = PayOrdersAcqV1::where('fullName','LIKE',"%{$search}%")
    //                         ->orWhere('merchantName', 'LIKE',"%{$search}%")
    //                         ->orWhere('phone', 'LIKE',"%{$search}%")
    //                         ->orWhere('cardnum', 'LIKE',"%{$search}%")
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result2 = PayOrdersVernapayment::where('fullName','LIKE',"%{$search}%")
    //                         ->orWhere('merchantName', 'LIKE',"%{$search}%")
    //                         ->orWhere('phone', 'LIKE',"%{$search}%")
    //                         ->orWhere('cardnum', 'LIKE',"%{$search}%")
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result3 = PayOrdersVernapaymentv1::where('fullName','LIKE',"%{$search}%")
    //                         ->orWhere('merchantName', 'LIKE',"%{$search}%")
    //                         ->orWhere('phone', 'LIKE',"%{$search}%")
    //                         ->orWhere('cardnum', 'LIKE',"%{$search}%")
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result4 = PayOrdersVernapaymentv3::where('fullName','LIKE',"%{$search}%")
    //                         ->orWhere('merchantName', 'LIKE',"%{$search}%")
    //                         ->orWhere('phone', 'LIKE',"%{$search}%")
    //                         ->orWhere('cardnum', 'LIKE',"%{$search}%")
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get();

    //         $result5 = PayOrdersVernapaymentv4::where('fullName','LIKE',"%{$search}%")
    //                         ->orWhere('merchantName', 'LIKE',"%{$search}%")
    //                         ->orWhere('phone', 'LIKE',"%{$search}%")
    //                         ->orWhere('cardnum', 'LIKE',"%{$search}%")
    //                         ->offset($start)
    //                         ->limit($limit)
    //                         ->orderBy('orderId','desc')
    //                         ->get(); 

    //         $report1 = array_merge($result1->toArray(),$result2->toArray());
    //         $report2  = array_merge($result3->toArray(),$result4->toArray());
    //         $report3  = array_merge($report1,$report2);

    //         $final_report = array_merge($report3,$result5->toArray());

    //         $posts =  $final_report;


    //     }


    //     $totalFiltered = $totalData;

    //     $data = array();


    //     if(!empty($posts))
    //     {
    //         foreach ($posts as $post)
    //         {
    //             $nestedData = [];

    //             if ($post['orderStatus'] == '200') {
    //                 $orderStatus = 'Success';
    //             } 
    //             else if($post['orderStatus'] == '400'){
    //                 $orderStatus = 'Failed';
    //             }
    //             else if($post['orderStatus'] == '1000'){
    //                 $orderStatus = 'Pending';
    //             }
    //             else if($post['orderStatus'] == '2001'){
    //                 $orderStatus = 'Refunded';
    //             }
    //             else if($post['orderStatus'] == '2008'){
    //                 $orderStatus = 'Chargeback';
    //             }
    //             else if($post['orderStatus'] == '2009'){
    //                 $orderStatus = 'High Risk Client';
    //             }
    //             else if($post['orderStatus'] == '2005'){
    //                 $orderStatus = 'Fraud';
    //             }
    //             else{
    //                 $orderStatus = 'Refunding';
    //             }


    //             if($post['included_in_report']=='0'){
    //                 $included_in_report = 'No';
    //             } else {
    //                 $included_in_report = 'Yes';
    //             }

    //             $nestedData['orderDate']            = date('j M Y h:i a',strtotime($post['orderDate']));
    //             $nestedData['orderStatus']          = $orderStatus;
    //             $nestedData['bank_charge']          = $post['chargeback_date'];
    //             $nestedData['refund_status']        = 'No';
    //             $nestedData['included_report']      = $included_in_report;
    //             $nestedData['merchant_name']        = $post['merchantName'];
    //             $nestedData['full_name']            = $post['fullName'];
    //             $nestedData['email']                = $post['email'];
    //             $nestedData['country']              = $post['country'];
    //             $nestedData['phone']                = $post['phone'];
    //             $nestedData['card_no']              = $post['cardnum'];
    //             $nestedData['bank_name']            = $post['bank_name'];
    //             $nestedData['description']          = $post['descriptor'];
    //             $nestedData['profile']              = 'No';
    //             $nestedData['card_type']            = $post['card_type'];
    //             $nestedData['amount']               = $post['amount'];
    //             $nestedData['currency']             = $post['currency'];
    //             $nestedData['invoice_number']       = $post['invoiceNumber'];
    //             $nestedData['client']               = 'No';
    //             $nestedData['order_message']        = $post['orderMessage'];
    //             $nestedData['transaction_id']       = $post['transactionID'];
    //             $nestedData['order_paid']           = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post['orderPaid'])->format('d/m/Y h:i A');
    //             $data[]                             = $nestedData;

    //         }
    //     }

    //     $json_data = array(
    //                 "draw"            => intval($request->input('draw')),  
    //                 "recordsTotal"    => intval($totalData),  
    //                 "recordsFiltered" => intval($totalFiltered), 
    //                 "data"            => $data   
    //                 );

    //     echo json_encode($json_data); 

    // }




    public function Post_Report_Index(Request $request)
    {
        $modelClasses = [

            'App\Models\PayOrdersAcqV1',
            'App\Models\PayOrdersVernapayment',
            'App\Models\PayOrdersVernapaymentv1',
            'App\Models\PayOrdersVernapaymentv3',
            'App\Models\PayOrdersVernapaymentv4'

        ];

        // Initialize variables
        $data = array();
        $posts = array();
        $totalRecords = 0;
        $filteredRecords = 0;

        // Process the request parameters
        $lim = $request->input('length');
        $limit = $lim / 5;
        $start = $request->input('start');



        $columns = array(
            0 => 'orderDate',
            1 => 'orderStatus',
            2 => 'bank_charge',
            3 => 'refund_status',
            4 => 'included_report',
            5 => 'merchant_name',
            6 => 'full_name',
            7 => 'email',
            8 => 'country',
            9 => 'phone',
            10 => 'card_no',
            11 => 'bank_name',
            12 => 'description',
            13 => 'profile',
            14 => 'card_type',
            15 => 'amount',
            16 => 'currency',
            17 => 'invoice_number',
            18 => 'client',
            19 => 'order_message',
            20 => 'transaction_id',
            21 => 'order_paid'
        );


        foreach ($modelClasses as $modelClass) {

            $query = $modelClass::select();


            // Add conditions based on request parameters
            if ($request->input('chargebackto') && $request->input('chargebackfrom')) {

                $s_date = $request->input('chargebackfrom');
                $e_date = $request->input('chargebackto');

                $query->whereBetween('chargeback_date', [$s_date, $e_date]);
            }

            if ($request->input('orderdatefrom') && $request->input('orderdateto')) {

                $s_date = $request->input('orderdatefrom');
                $e_date = $request->input('orderdateto');

                $query->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('cardtypeFilter')) {
                $search = $request->input('cardtypeFilter');

                $query->where('card_type', $search);
            }

            if ($request->input('amountFilter')) {

                $search = $request->input('amountFilter');
                $epsilon = 0.001;
                $query->whereBetween('amount', [$search - $epsilon, $search + $epsilon]);
            }

            if ($request->input('currencyFilter')) {

                $search = $request->input('currencyFilter');

                $query->where('currency', $search);
            }

            if ($request->input('orderStatusFilter')) {

                $search = $request->input('orderStatusFilter');

                $query->where('orderStatus', $search);
            }

            if (empty($request->input('search.value'))) {
                // nothing to do..
            } else {
                $search = $request->input('search.value');

                $query->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            // Get total records for the current model
            $totalRecords += $query->count();

            // Apply limit and offset
            $query->offset($start)->limit($limit)->orderBy('orderId', 'desc');



            // Get filtered records for the current model
            $filteredRecords = $totalRecords;

            // Merge results
            $posts = array_merge($posts, $query->get()->toArray());
        }


        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData = [];

                if ($post['orderStatus'] == '200') {
                    $orderStatus = 'Success';
                } else if ($post['orderStatus'] == '400') {
                    $orderStatus = 'Failed';
                } else if ($post['orderStatus'] == '1000') {
                    $orderStatus = 'Pending';
                } else if ($post['orderStatus'] == '2001') {
                    $orderStatus = 'Refunded';
                } else if ($post['orderStatus'] == '2008') {
                    $orderStatus = 'Chargeback';
                } else if ($post['orderStatus'] == '2009') {
                    $orderStatus = 'High Risk Client';
                } else if ($post['orderStatus'] == '2005') {
                    $orderStatus = 'Fraud';
                } else {
                    $orderStatus = 'Refunding';
                }


                if ($post['included_in_report'] == '0') {
                    $included_in_report = 'No';
                } else {
                    $included_in_report = 'Yes';
                }

                $nestedData['orderDate']            = date('j M Y h:i a', strtotime($post['orderDate']));
                $nestedData['orderStatus']          = $orderStatus;
                $nestedData['bank_charge']          = $post['chargeback_date'];
                $nestedData['refund_status']        = '<button class="btn btn-sm btn-soft-info">Refund</button>
                                                       <button class="btn btn-sm btn-soft-info">Fraud</button>
                                                       <button class="btn btn-sm btn-soft-info">Chargeback</button>';
                $nestedData['included_report']      = $included_in_report;
                $nestedData['merchant_name']        = $post['merchantName'];
                $nestedData['full_name']            = $post['fullName'];
                $nestedData['email']                = $post['email'];
                $nestedData['country']              = $post['country'];
                $nestedData['phone']                = $post['phone'];
                $nestedData['card_no']              = $post['cardnum'];
                $nestedData['bank_name']            = $post['bank_name'];
                $nestedData['description']          = $post['descriptor'];
                $nestedData['profile']              = 'No';
                $nestedData['card_type']            = $post['card_type'];
                $nestedData['amount']               = $post['amount'];
                $nestedData['currency']             = $post['currency'];
                $nestedData['invoice_number']       = $post['invoiceNumber'];
                $nestedData['client']               = 'No';
                $nestedData['order_message']        = $post['orderMessage'];
                $nestedData['transaction_id']       = $post['transactionID'];
                $nestedData['order_paid']           = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post['orderPaid'])->format('d/m/Y h:i A');
                $data[]                             = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalRecords),
            "recordsFiltered" => intval($filteredRecords),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function admin_client_tran(Request $request)
    {
        // $merchent = ClientTransaction::select('user_name')->distinct()->get();
        $merchent = User::select('name')->where('role', '10')->where('status', '1')->get();

        return view('reporting.admin_client_tran', compact('request', 'merchent'));
    }

    public function Post_admin_client_tran(Request $request)
    {

        // Initialize variables
        $data = array();
        $posts = array();
        $totalRecords = 0;
        $filteredRecords = 0;

        // Process the request parameters
        $lim = $request->input('length');
        $limit = $lim / 5;
        $start = $request->input('start');

        $columns = array(
            0 => 'Merchant',
            1 => 'TransactionId',
            2 => 'Date',
            3 => 'Status',
            4 => 'Corrency',
            5 => 'Amount',
            6 => 'Fee',
            7 => 'BeforeRollingRe',
            8 => 'RollingRe',
            9 => 'Payabletoclient',
            10 => 'PSPFees',
            11 => 'NetAfterPSP',
            12 => 'PPFriend',
            13 => 'Majestic',
            14 => 'Limegrove',
            15 => 'Invoice'
        );

        $limit = $request->input('length');
        $start = $request->input('start');

        $q = ClientTransaction::query();

        if ($request->merchent) {
            $q->where('user_name', $request->merchent);
        }

        if ($request->to_date != '' || $request->from_date != '') {
            $q->whereBetween('transaction_date', [$request->to_date, $request->from_date]);
        }

        $posts = $q->offset($start)->limit($limit)->orderBy('id', 'DESC')->get();

        $qa = ClientTransaction::query();

        if ($request->merchent) {
            $qa->where('user_name', $request->merchent);
        }

        if ($request->to_date != '' || $request->from_date != '') {
            $qa->whereBetween('transaction_date', [$request->to_date, $request->from_date]);
        }

        $totalRecords = $qa->count();

        $filteredRecords = $totalRecords;

        if (!empty($posts)) {
            foreach ($posts as $item) {

                if ($item) {

                    $nestedData = [];

                    $nestedData['Merchant']         = $item->user_name;
                    $nestedData['TransactionId']    = $item->transaction_id;
                    $nestedData['Date']             = date("d-m-Y", strtotime($item->transaction_date));
                    $nestedData['Status']           = $item->status;
                    $nestedData['Corrency']         = $item->currency;
                    $nestedData['Amount']           = number_format($item->amount, 2);

                    $users = User::where('name', $item->user_name)->first();

                    if ($users && $users->clientDetails) {
                        $client_commission = $users->clientDetails->client_commission;
                    } else {
                        $client_commission = '0';
                    }

                    if ($users && $users->clientDetails && $users->clientDetails->extra_client_fee) {
                        $extra_client_fee = $users->clientDetails->extra_client_fee;
                    } else {
                        $extra_client_fee = '0';
                    }

                    $fee = (($client_commission / 100) * $item->amount) + $extra_client_fee;

                    $nestedData['Fee'] = number_format($fee, 2);

                    if ($users && $users->clientDetails) {
                        $before_rolling_reserve = $users->clientDetails->before_rolling_reserve;
                    } else {
                        $before_rolling_reserve = '0';
                    }

                    $before_roll_rec = (($before_rolling_reserve / 100) * $item->amount);

                    $nestedData['BeforeRollingRe'] = number_format($before_roll_rec, 2);

                    if ($users && $users->clientDetails) {
                        $rolling_reserve = $users->clientDetails->rolling_reserve;
                    } else {
                        $rolling_reserve = '0';
                    }

                    $rolling_rec_per = ($rolling_reserve / 100) * $item->amount;

                    $nestedData['RollingRe'] = number_format($rolling_rec_per, 2);

                    if ($users && $users->clientDetails) {
                        $payabletoclient = $users->clientDetails->payabletoclient;
                    } else {
                        $payabletoclient = '0';
                    }

                    $payable_to_clnt = ($payabletoclient / 100) * $item->amount;

                    $nestedData['Payabletoclient'] = number_format($payable_to_clnt, 2);

                    if ($users && $users->clientDetails) {
                        $psp = $users->clientDetails->psp;
                    } else {
                        $psp = '0';
                    }

                    $PSP_fees = ($psp / 100) * $item->amount;

                    $nestedData['PSPFees'] = number_format($PSP_fees, 2);

                    if ($users && $users->clientDetails) {
                        $net_after_PSP_amt = $users->clientDetails->net_after_psp_client;
                    } else {
                        $net_after_PSP_amt = '0';
                    }

                    $net_after_PSP = $item->amount - $net_after_PSP_amt;

                    $nestedData['NetAfterPSP'] = number_format($net_after_PSP, 2);

                    if ($users && $users->clientDetails) {
                        $pp_friend = $users->clientDetails->extra_client_fee;
                    } else {
                        $pp_friend = '0';
                    }

                    $PP_frnd = ($pp_friend / 100) * $item->amount;

                    $nestedData['PPFriend'] = number_format($PP_frnd, 2);

                    if ($users && $users->clientDetails) {
                        $majestic_p = $users->clientDetails->majestic;
                    } else {
                        $majestic_p = '0';
                    }

                    $majestic = ($majestic_p / 100) * $item->amount;

                    $nestedData['Majestic'] = number_format($majestic, 2);

                    if ($users && $users->clientDetails) {
                        $payit123share = $users->clientDetails->payit123share;
                    } else {
                        $payit123share = '0';
                    }

                    $limegrove =  ($payit123share / 100) * ($net_after_PSP - $majestic - $PP_frnd);

                    $nestedData['Limegrove'] = number_format($limegrove, 2);

                    $PYY_share =  ($payit123share / 100) * ($net_after_PSP - $majestic - $PP_frnd);

                    $nestedData['Invoice'] = $item->invoice;

                    $data[]                         = $nestedData;
                }
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalRecords),
            "recordsFiltered" => intval($filteredRecords),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function Post_admin_client_tran_old(Request $request)
    {

        // Initialize variables
        $data = array();
        $posts = array();
        $totalRecords = 0;
        $filteredRecords = 0;

        // Process the request parameters
        $lim = $request->input('length');
        $limit = $lim / 5;
        $start = $request->input('start');

        $columns = array(
            0 => 'Merchant',
            1 => 'TransactionId',
            2 => 'Date',
            3 => 'Status',
            4 => 'Corrency',
            5 => 'Amount',
            6 => 'Fee',
            7 => 'BeforeRollingRe',
            8 => 'RollingRe',
            9 => 'Payabletoclient',
            10 => 'PSPFees',
            11 => 'NetAfterPSP',
            12 => 'PPFriend',
            13 => 'Majestic',
            14 => 'Limegrove',
            15 => 'Invoice'
        );

        $limit = $request->input('length');
        $start = $request->input('start');

        // $posts = ClientTransaction::offset($start)
        //                  ->limit($limit)
        //                  ->orderBy('id','desc')
        //                  ->get();

        // $totalRecords = ClientTransaction::count();

        $q = ClientTransaction::query();

        if ($request->merchent) {
            $q->where('user_name', $request->merchent);
        }

        if ($request->to_date != '' || $request->from_date != '') {
            $q->whereBetween('transaction_date', [$request->to_date, $request->from_date]);
        }

        $posts = $q->offset($start)->limit($limit)->orderBy('id', 'DESC')->get();

        $qa = ClientTransaction::query();

        if ($request->merchent) {
            $qa->where('user_name', $request->merchent);
        }

        if ($request->to_date != '' || $request->from_date != '') {
            $qa->whereBetween('transaction_date', [$request->to_date, $request->from_date]);
        }

        $totalRecords = $qa->count();

        $filteredRecords = $totalRecords;

        if (!empty($posts)) {
            foreach ($posts as $item) {

                if ($item) {

                    $nestedData = [];

                    $nestedData['Merchant']         = $item->user_name;
                    $nestedData['TransactionId']    = $item->transaction_id;
                    $nestedData['Date']             = date("d-m-Y", strtotime($item->transaction_date));
                    $nestedData['Status']           = $item->status;
                    $nestedData['Corrency']         = $item->currency;
                    $nestedData['Amount']           = number_format($item->amount, 2);

                    $users = User::where('name', $item->user_name)->first();

                    if ($users && $users->clientDetails) {
                        $client_commission = $users->clientDetails->client_commission;
                    } else {
                        $client_commission = '0';
                    }

                    if ($users && $users->clientDetails && $users->clientDetails->extra_client_fee) {
                        $extra_client_fee = $users->clientDetails->extra_client_fee;
                    } else {
                        $extra_client_fee = '0';
                    }

                    $fee = (($client_commission / 100) * $item->amount) + $extra_client_fee;

                    $nestedData['Fee'] = number_format($fee, 2);

                    $before_roll_rec = $item->amount - $fee;

                    $nestedData['BeforeRollingRe'] = number_format($before_roll_rec, 2);

                    if ($users && $users->clientDetails) {
                        $rolling_reserve = $users->clientDetails->rolling_reserve;
                    } else {
                        $rolling_reserve = '0';
                    }

                    $rolling_rec_per = ($rolling_reserve / 100) * $item->amount;

                    $nestedData['RollingRe'] = number_format($rolling_rec_per, 2);

                    $payable_to_clnt = $before_roll_rec - $rolling_rec_per;

                    $nestedData['Payabletoclient'] = number_format($payable_to_clnt, 2);

                    if ($users && $users->clientDetails) {
                        $psp = $users->clientDetails->psp;
                    } else {
                        $psp = '0';
                    }

                    $PSP_fees = ($psp / 100) * $item->amount;

                    $nestedData['PSPFees'] = number_format($PSP_fees, 2);

                    $net_after_PSP = $item->amount - $before_roll_rec - $PSP_fees;

                    $nestedData['NetAfterPSP'] = number_format($net_after_PSP, 2);

                    if ($users && $users->clientDetails) {
                        $pp_friend = $users->clientDetails->pp_friend;
                    } else {
                        $pp_friend = '0';
                    }

                    $PP_frnd = ($pp_friend / 100) * $item->amount;

                    $nestedData['PPFriend'] = number_format($PP_frnd, 2);

                    if ($users && $users->clientDetails) {
                        $majestic_p = $users->clientDetails->majestic;
                    } else {
                        $majestic_p = '0';
                    }

                    $majestic = ($majestic_p / 100) * $item->amount;

                    $nestedData['Majestic'] = number_format($majestic, 2);

                    if ($users && $users->clientDetails) {
                        $payit123share = $users->clientDetails->payit123share;
                    } else {
                        $payit123share = '0';
                    }

                    $limegrove =  ($payit123share / 100) * ($net_after_PSP - $majestic - $PP_frnd);

                    $nestedData['Limegrove'] = number_format($limegrove, 2);

                    $PYY_share =  ($payit123share / 100) * ($net_after_PSP - $majestic - $PP_frnd);

                    $nestedData['Invoice'] = $item->invoice;

                    $data[]                         = $nestedData;
                }
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalRecords),
            "recordsFiltered" => intval($filteredRecords),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function Download_Report_Pdf(Request $request) {}


    public function new_Sales_Report(Request $request, $data)
    {
        $info = $data;
        if ($data == 'vernapayments') {
            $cname = 'Verna1';
        } elseif ($data == 'vernapaymentv1') {
            $cname = 'Verna2';
        } elseif ($data == 'vernapaymentv3') {
            $cname = 'Verna3';
        } elseif ($data == 'vernapaymentv4') {
            $cname = 'Verna4';
        } elseif ($data == 'vernapaymentMRV') {
            $cname = 'MRV';
        } elseif ($data == 'vernapaymentMstreet') {
            $cname = 'Mstreet';
        } else {
            $cname = 'Ralseft';
        }


        return view('reporting.sales_report', compact('request', 'cname'));
    }


    public function post_Sales_Reports(Request $request, $data)
    {

        $info = $data;

        if ($data == 'Verna1') {

            $resultcount = PayOrdersVernapayment::select();

            if ($request->input('date_to') && $request->input('date_from')) {
                $s_date = $request->input('date_from');
                $e_date = $request->input('date_to');

                $resultcount->whereBetween('orderDate', [$s_date, $e_date]);
            }

            $final_report_count = $resultcount->count();

            $columns = array(
                0 => '#',
                1 => 'transaction_id',
                2 => 'orderDate',
                3 => 'amount',
                4 => 'Currency',
                5 => 'Fee',
                6 => 'TransFee',
                7 => 'PayableToClient',
                8 => 'RollingReserve',
                9 => 'PayableToClient',
                10 => 'Invoice',
            );

            $totalData = $final_report_count;

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $data = array();

            $result = PayOrdersVernapayment::select();

            if ($request->input('date_to') && $request->input('date_from')) {
                $s_date = $request->input('date_from');
                $e_date = $request->input('date_to');

                $result->whereBetween('orderDate', [$s_date, $e_date]);
            }

            $posts = $result->offset($start)
                ->limit($limit)
                ->orderBy('orderId', 'desc')
                ->get();

            foreach ($posts as $key => $post) {
                $nestedData = [];

                $nestedData['#']                        = ++$key;
                $nestedData['transaction_id']           = $post->transactionID;
                $nestedData['orderDate']                = date('j M Y h:i a', strtotime($post->orderDate));
                $nestedData['amount']                   = $post->amount;
                $nestedData['Currency']                 = $post->currency;
                $nestedData['Fee']                      = round($post->amount * (6.30 / 100), 2);
                $nestedData['TransFee']                 = round($post->amount * (0.50 / 100), 2);
                $nestedData['PayableToClient']          = round($post->amount - ($post->amount * (6.30 / 100)), 2);
                $nestedData['RollingReserve']           = round($post->amount - ($post->amount * (6.30 / 100)) * 5 / 100, 2);
                $nestedData['PayableToClient']          = round(($post->amount - ($post->amount * (6.30 / 100))) - (($post->amount - ($post->amount * (6.30 / 100))) * 5 / 100), 2);
                $nestedData['Invoice']                  = $post->invoiceNumber;

                $data[] = $nestedData;
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data);
        }

        if ($data == 'Verna2') {

            $resultcount = PayOrdersVernapaymentv1::select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $resultcount->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $resultcount->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $resultcount->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $resultcount->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // nothing
            } else {
                $search = $request->input('search.value');

                $resultcount->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $final_report_count = $resultcount->count();

            $columns = array(
                0 => 'orderDate',
                1 => 'orderStatus',
                2 => 'full_name',
                3 => 'email',
                4 => 'country',
                5 => 'phone',
                6 => 'card_no',
                7 => 'amount',
                8 => 'invoice_number',
                9 => 'merchant_name',
                10 => 'paymentMethod',
                11 => 'order_message',
                12 => 'transaction_id',
                13 => 'order_paid'
            );

            $totalData = $final_report_count;

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $data = array();

            $result = PayOrdersVernapaymentv1::select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $result->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $result->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $result->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $result->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // $result->offset($start)
                //               ->limit($limit)
                //               ->orderBy('orderId', 'desc')
                //               ->get();
            } else {
                $search = $request->input('search.value');

                $result->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $posts = $result->offset($start)
                ->limit($limit)
                ->orderBy('orderId', 'desc')
                ->get();

            foreach ($posts as $post) {
                $nestedData = [];

                if ($post->orderStatus == '200') {
                    $orderStatus = 'Success';
                } else if ($post->orderStatus == '400') {
                    $orderStatus = 'Failed';
                } else if ($post->orderStatus == '1000') {
                    $orderStatus = 'Pending';
                } else if ($post->orderStatus == '2001') {
                    $orderStatus = 'Refunded';
                } else if ($post->orderStatus == '2008') {
                    $orderStatus = 'Chargeback';
                } else if ($post->orderStatus == '2009') {
                    $orderStatus = 'High Risk Client';
                } else if ($post->orderStatus == '2005') {
                    $orderStatus = 'Fraud';
                } else {
                    $orderStatus = 'Refunding';
                }

                $nestedData['orderDate']        = date('j M Y h:i a', strtotime($post->orderDate));
                $nestedData['orderStatus']      = $orderStatus;
                $nestedData['full_name']        = $post->fullName;
                $nestedData['email']            = $post->email;
                $nestedData['country']          = $post->country;
                $nestedData['phone']            = $post->phone;
                $nestedData['card_no']          = $post->cardnum;
                $nestedData['amount']           = $post->amount;
                $nestedData['invoice_number']   = $post->invoiceNumber;
                $nestedData['merchant_name']    = $post->merchantName;
                $nestedData['paymentMethod']    = $post->paymentMethod;
                $nestedData['order_message']    = $post->orderMessage;
                $nestedData['transaction_id']   = $post->transactionID;
                $nestedData['order_paid']       = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->orderPaid)->format('d/m/Y h:i A');

                $data[] = $nestedData;
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data);
        }

        if ($data == 'Verna3') {

            $resultcount = PayOrdersVernapaymentv3::select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $resultcount->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $resultcount->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $resultcount->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $resultcount->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // nothing
            } else {
                $search = $request->input('search.value');

                $resultcount->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $final_report_count = $resultcount->count();

            $columns = array(
                0 => 'orderDate',
                1 => 'orderStatus',
                2 => 'full_name',
                3 => 'email',
                4 => 'country',
                5 => 'phone',
                6 => 'card_no',
                7 => 'amount',
                8 => 'invoice_number',
                9 => 'merchant_name',
                10 => 'paymentMethod',
                11 => 'order_message',
                12 => 'transaction_id',
                13 => 'order_paid'
            );

            $totalData = $final_report_count;

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $data = array();

            $result = PayOrdersVernapaymentv3::select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $result->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $result->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $result->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $result->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // $result->offset($start)
                //               ->limit($limit)
                //               ->orderBy('orderId', 'desc')
                //               ->get();
            } else {
                $search = $request->input('search.value');

                $result->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $posts = $result->offset($start)
                ->limit($limit)
                ->orderBy('orderId', 'desc')
                ->get();

            foreach ($posts as $post) {
                $nestedData = [];

                if ($post->orderStatus == '200') {
                    $orderStatus = 'Success';
                } else if ($post->orderStatus == '400') {
                    $orderStatus = 'Failed';
                } else if ($post->orderStatus == '1000') {
                    $orderStatus = 'Pending';
                } else if ($post->orderStatus == '2001') {
                    $orderStatus = 'Refunded';
                } else if ($post->orderStatus == '2008') {
                    $orderStatus = 'Chargeback';
                } else if ($post->orderStatus == '2009') {
                    $orderStatus = 'High Risk Client';
                } else if ($post->orderStatus == '2005') {
                    $orderStatus = 'Fraud';
                } else {
                    $orderStatus = 'Refunding';
                }

                $nestedData['orderDate']        = date('j M Y h:i a', strtotime($post->orderDate));
                $nestedData['orderStatus']      = $orderStatus;
                $nestedData['full_name']        = $post->fullName;
                $nestedData['email']            = $post->email;
                $nestedData['country']          = $post->country;
                $nestedData['phone']            = $post->phone;
                $nestedData['card_no']          = $post->cardnum;
                $nestedData['amount']           = $post->amount;
                $nestedData['invoice_number']   = $post->invoiceNumber;
                $nestedData['merchant_name']    = $post->merchantName;
                $nestedData['paymentMethod']    = $post->paymentMethod;
                $nestedData['order_message']    = $post->orderMessage;
                $nestedData['transaction_id']   = $post->transactionID;
                $nestedData['order_paid']       = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->orderPaid)->format('d/m/Y h:i A');

                $data[] = $nestedData;
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data);
        }

        if ($data == 'Verna4') {

            $resultcount = PayOrdersVernapaymentv4::select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $resultcount->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $resultcount->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $resultcount->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $resultcount->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // nothing
            } else {
                $search = $request->input('search.value');

                $resultcount->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $final_report_count = $resultcount->count();

            $columns = array(
                0 => 'orderDate',
                1 => 'orderStatus',
                2 => 'full_name',
                3 => 'email',
                4 => 'country',
                5 => 'phone',
                6 => 'card_no',
                7 => 'amount',
                8 => 'invoice_number',
                9 => 'merchant_name',
                10 => 'paymentMethod',
                11 => 'order_message',
                12 => 'transaction_id',
                13 => 'order_paid'
            );

            $totalData = $final_report_count;

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $data = array();

            $result = PayOrdersVernapaymentv4::select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $result->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $result->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $result->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $result->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // $result->offset($start)
                //               ->limit($limit)
                //               ->orderBy('orderId', 'desc')
                //               ->get();
            } else {
                $search = $request->input('search.value');

                $result->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $posts = $result->offset($start)
                ->limit($limit)
                ->orderBy('orderId', 'desc')
                ->get();

            foreach ($posts as $post) {
                $nestedData = [];

                if ($post->orderStatus == '200') {
                    $orderStatus = 'Success';
                } else if ($post->orderStatus == '400') {
                    $orderStatus = 'Failed';
                } else if ($post->orderStatus == '1000') {
                    $orderStatus = 'Pending';
                } else if ($post->orderStatus == '2001') {
                    $orderStatus = 'Refunded';
                } else if ($post->orderStatus == '2008') {
                    $orderStatus = 'Chargeback';
                } else if ($post->orderStatus == '2009') {
                    $orderStatus = 'High Risk Client';
                } else if ($post->orderStatus == '2005') {
                    $orderStatus = 'Fraud';
                } else {
                    $orderStatus = 'Refunding';
                }

                $nestedData['orderDate']        = date('j M Y h:i a', strtotime($post->orderDate));
                $nestedData['orderStatus']      = $orderStatus;
                $nestedData['full_name']        = $post->fullName;
                $nestedData['email']            = $post->email;
                $nestedData['country']          = $post->country;
                $nestedData['phone']            = $post->phone;
                $nestedData['card_no']          = $post->cardnum;
                $nestedData['amount']           = $post->amount;
                $nestedData['invoice_number']   = $post->invoiceNumber;
                $nestedData['merchant_name']    = $post->merchantName;
                $nestedData['paymentMethod']    = $post->paymentMethod;
                $nestedData['order_message']    = $post->orderMessage;
                $nestedData['transaction_id']   = $post->transactionID;
                $nestedData['order_paid']       = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->orderPaid)->format('d/m/Y h:i A');

                $data[] = $nestedData;
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data);
        }

        if ($data == 'MRV') {

            $resultcount = PayOrdersAcqV1::where('merchantName',  'MRV')->select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $resultcount->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $resultcount->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $resultcount->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $resultcount->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // nothing
            } else {
                $search = $request->input('search.value');

                $resultcount->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $final_report_count = $resultcount->count();

            $columns = array(
                0 => 'orderDate',
                1 => 'orderStatus',
                2 => 'full_name',
                3 => 'email',
                4 => 'country',
                5 => 'phone',
                6 => 'card_no',
                7 => 'amount',
                8 => 'invoice_number',
                9 => 'merchant_name',
                10 => 'paymentMethod',
                11 => 'order_message',
                12 => 'transaction_id',
                13 => 'order_paid'
            );

            $totalData = $final_report_count;

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $data = array();

            $result = PayOrdersAcqV1::where('merchantName',  'MRV')->select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $result->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $result->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $result->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $result->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // $result->offset($start)
                //               ->limit($limit)
                //               ->orderBy('orderId', 'desc')
                //               ->get();
            } else {
                $search = $request->input('search.value');

                $result->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $posts = $result->offset($start)
                ->limit($limit)
                ->orderBy('orderId', 'desc')
                ->get();

            foreach ($posts as $post) {
                $nestedData = [];

                if ($post->orderStatus == '200') {
                    $orderStatus = 'Success';
                } else if ($post->orderStatus == '400') {
                    $orderStatus = 'Failed';
                } else if ($post->orderStatus == '1000') {
                    $orderStatus = 'Pending';
                } else if ($post->orderStatus == '2001') {
                    $orderStatus = 'Refunded';
                } else if ($post->orderStatus == '2008') {
                    $orderStatus = 'Chargeback';
                } else if ($post->orderStatus == '2009') {
                    $orderStatus = 'High Risk Client';
                } else if ($post->orderStatus == '2005') {
                    $orderStatus = 'Fraud';
                } else {
                    $orderStatus = 'Refunding';
                }

                $nestedData['orderDate']        = date('j M Y h:i a', strtotime($post->orderDate));
                $nestedData['orderStatus']      = $orderStatus;
                $nestedData['full_name']        = $post->fullName;
                $nestedData['email']            = $post->email;
                $nestedData['country']          = $post->country;
                $nestedData['phone']            = $post->phone;
                $nestedData['card_no']          = $post->cardnum;
                $nestedData['amount']           = $post->amount;
                $nestedData['invoice_number']   = $post->invoiceNumber;
                $nestedData['merchant_name']    = $post->merchantName;
                $nestedData['paymentMethod']    = $post->paymentMethod;
                $nestedData['order_message']    = $post->orderMessage;
                $nestedData['transaction_id']   = $post->transactionID;
                $nestedData['order_paid']       = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->orderPaid)->format('d/m/Y h:i A');

                $data[] = $nestedData;
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data);
        }

        if ($data == 'Mstreet') {

            $resultcount = PayOrdersAcqV1::where('merchantName',  'Mstreet')->select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $resultcount->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $resultcount->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $resultcount->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $resultcount->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // nothing
            } else {
                $search = $request->input('search.value');

                $resultcount->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $final_report_count = $resultcount->count();

            $columns = array(
                0 => 'orderDate',
                1 => 'orderStatus',
                2 => 'full_name',
                3 => 'email',
                4 => 'country',
                5 => 'phone',
                6 => 'card_no',
                7 => 'amount',
                8 => 'invoice_number',
                9 => 'merchant_name',
                10 => 'paymentMethod',
                11 => 'order_message',
                12 => 'transaction_id',
                13 => 'order_paid'
            );

            $totalData = $final_report_count;

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $data = array();

            $result = PayOrdersAcqV1::where('merchantName',  'Mstreet')->select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $result->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $result->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $result->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $result->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // $result->offset($start)
                //               ->limit($limit)
                //               ->orderBy('orderId', 'desc')
                //               ->get();
            } else {
                $search = $request->input('search.value');

                $result->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $posts = $result->offset($start)
                ->limit($limit)
                ->orderBy('orderId', 'desc')
                ->get();

            foreach ($posts as $post) {
                $nestedData = [];

                if ($post->orderStatus == '200') {
                    $orderStatus = 'Success';
                } else if ($post->orderStatus == '400') {
                    $orderStatus = 'Failed';
                } else if ($post->orderStatus == '1000') {
                    $orderStatus = 'Pending';
                } else if ($post->orderStatus == '2001') {
                    $orderStatus = 'Refunded';
                } else if ($post->orderStatus == '2008') {
                    $orderStatus = 'Chargeback';
                } else if ($post->orderStatus == '2009') {
                    $orderStatus = 'High Risk Client';
                } else if ($post->orderStatus == '2005') {
                    $orderStatus = 'Fraud';
                } else {
                    $orderStatus = 'Refunding';
                }

                $nestedData['orderDate']        = date('j M Y h:i a', strtotime($post->orderDate));
                $nestedData['orderStatus']      = $orderStatus;
                $nestedData['full_name']        = $post->fullName;
                $nestedData['email']            = $post->email;
                $nestedData['country']          = $post->country;
                $nestedData['phone']            = $post->phone;
                $nestedData['card_no']          = $post->cardnum;
                $nestedData['amount']           = $post->amount;
                $nestedData['invoice_number']   = $post->invoiceNumber;
                $nestedData['merchant_name']    = $post->merchantName;
                $nestedData['paymentMethod']    = $post->paymentMethod;
                $nestedData['order_message']    = $post->orderMessage;
                $nestedData['transaction_id']   = $post->transactionID;
                $nestedData['order_paid']       = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->orderPaid)->format('d/m/Y h:i A');

                $data[] = $nestedData;
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data);
        }

        if ($data == 'Ralself') {

            $resultcount = PayOrdersAcqV1::where('merchantName',  'Ralseft')->select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $resultcount->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $resultcount->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $resultcount->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $resultcount->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // nothing
            } else {
                $search = $request->input('search.value');

                $resultcount->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $final_report_count = $resultcount->count();

            $columns = array(
                0 => 'orderDate',
                1 => 'orderStatus',
                2 => 'full_name',
                3 => 'email',
                4 => 'country',
                5 => 'phone',
                6 => 'card_no',
                7 => 'amount',
                8 => 'invoice_number',
                9 => 'merchant_name',
                10 => 'paymentMethod',
                11 => 'order_message',
                12 => 'transaction_id',
                13 => 'order_paid'
            );

            $totalData = $final_report_count;

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $data = array();

            $result = PayOrdersAcqV1::where('merchantName',  'Ralseft')->select();

            if ($request->input('orderto') && $request->input('orderfrom')) {
                $s_date = $request->input('orderfrom');
                $e_date = $request->input('orderto');

                $result->whereBetween('orderDate', [$s_date, $e_date]);
            }

            if ($request->input('MerchantFilter')) {
                $search = $request->input('MerchantFilter');

                $result->where('merchantName',  $search);
            }

            if ($request->input('orderStatusFilter')) {
                $search = $request->input('orderStatusFilter');

                $result->where('orderStatus',  $search);
            }

            if ($request->input('PaymentMethodFilter')) {
                $search = $request->input('PaymentMethodFilter');

                $result->where('paymentMethod',  $search);
            }

            if (empty($request->input('search.value'))) {
                // $result->offset($start)
                //               ->limit($limit)
                //               ->orderBy('orderId', 'desc')
                //               ->get();
            } else {
                $search = $request->input('search.value');

                $result->where('fullName', 'LIKE', "%{$search}%")
                    ->orWhere('merchantName', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('cardnum', 'LIKE', "%{$search}%");
            }

            $posts = $result->offset($start)
                ->limit($limit)
                ->orderBy('orderId', 'desc')
                ->get();

            foreach ($posts as $post) {
                $nestedData = [];

                if ($post->orderStatus == '200') {
                    $orderStatus = 'Success';
                } else if ($post->orderStatus == '400') {
                    $orderStatus = 'Failed';
                } else if ($post->orderStatus == '1000') {
                    $orderStatus = 'Pending';
                } else if ($post->orderStatus == '2001') {
                    $orderStatus = 'Refunded';
                } else if ($post->orderStatus == '2008') {
                    $orderStatus = 'Chargeback';
                } else if ($post->orderStatus == '2009') {
                    $orderStatus = 'High Risk Client';
                } else if ($post->orderStatus == '2005') {
                    $orderStatus = 'Fraud';
                } else {
                    $orderStatus = 'Refunding';
                }

                $nestedData['orderDate']        = date('j M Y h:i a', strtotime($post->orderDate));
                $nestedData['orderStatus']      = $orderStatus;
                $nestedData['full_name']        = $post->fullName;
                $nestedData['email']            = $post->email;
                $nestedData['country']          = $post->country;
                $nestedData['phone']            = $post->phone;
                $nestedData['card_no']          = $post->cardnum;
                $nestedData['amount']           = $post->amount;
                $nestedData['invoice_number']   = $post->invoiceNumber;
                $nestedData['merchant_name']    = $post->merchantName;
                $nestedData['paymentMethod']    = $post->paymentMethod;
                $nestedData['order_message']    = $post->orderMessage;
                $nestedData['transaction_id']   = $post->transactionID;
                $nestedData['order_paid']       = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->orderPaid)->format('d/m/Y h:i A');

                $data[] = $nestedData;
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data);
        }
    }

    public function InvoiceGenerate($data, $id)
    {

        if ($data == 'MRV') {
            $inv = PayOrdersAcqV1::where('orderId', $id)->first();
        } elseif ($data == 'Mstreet') {
            $inv = PayOrdersAcqV1::where('orderId', $id)->first();
        } elseif ($data == 'Ralseft') {
            $inv = PayOrdersAcqV1::where('orderId', $id)->first();
        } elseif ($data == 'Verna1') {
            $inv = PayOrdersVernapayment::where('orderId', $id)->first();
        } elseif ($data == 'Verna2') {
            $inv = PayOrdersVernapaymentv1::where('orderId', $id)->first();
        } elseif ($data == 'Verna3') {
            $inv = PayOrdersVernapaymentv3::where('orderId', $id)->first();
        } elseif ($data == 'Verna4') {
            $inv = PayOrdersVernapaymentv4::where('orderId', $id)->first();
        } else {
            return back()->with('error', 'Something Wrong');
        }


        return view('reporting.invoice', compact('inv'));
    }

    public function weeklyreports()
    {
        // $clients = DB::select("SHOW TABLES LIKE 'pay_orders_%'");

        // $clients = DB::table('information_schema.tables')
        //     ->select('table_name')
        //     ->where('table_schema', 'payit123crm_new_db') // Replace with your database name or use ENV
        //     ->where('table_name', 'like', 'pay_orders_%')
        //     ->get();

        // Add a simplified name without the prefix
        // $clients = $clients->map(function ($client) {
        //     $client->client_name = str_replace('pay_orders_', '', $client->table_name);
        //     return $client;
        // });

        $clients = User::where('role',10)->get()->all();

        $reports = WeeklyReports::get()->all();


        return view('reporting.weeklyreports', compact('clients', 'reports'));
    }
    
    public function get_agent_details($id)
    {
        $clientName = $id;
        $user = User::where('name', $clientName)->first();
        $agentConfig = $user && $user->clientDetails ? $user->clientDetails->agentConfig : null;

        $explode_id = json_decode($agentConfig, true);
        // Log::info(count($explode_id));

        if (!$agentConfig || empty($agentConfig)) {
            return response()->json([]); // Return an empty array if no data
        }

        return response()->json(json_decode($agentConfig, true));
    }

    public function updateAgentDetails(Request $request)
    {
        $clientName = $request->clientName;
        $agents = $request->agents;

        Log::info($agents);
        Log::info($clientName);

        // $implode_agents = json_encode($agents, true);

        // Log::info($implode_agents);

        $userId = User::where('name', $clientName)->first();
        $result = ClientDetails::where('client_id', $userId->id)->update(['agentConfig' => $agents]);

        Log::info($result);

        if ($result) {
            return response()->json(['message' => 'Client details updated successfully']);
        } else {
            return response()->json(['error' => 'Update failed'], 500);
        }
    }

    public function deleteAgent(Request $request)
    {
        $request->validate([
            'agent' => 'required|string',
        ]);

        $clientName = $request->clientName;
        $user = User::where('name', $clientName)->first();
        $record = $user && $user->clientDetails ? $user->clientDetails->agentConfig : null;


        Log::info($record);

        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record not found'], 404);
        }

        // Decode JSON
        $pspArray = json_decode($record, true);

        Log::info($pspArray);

        // Filter out the item to be removed
        $filteredArray = array_filter($pspArray, function ($item) use ($request) {
            return $item['agent'] !== $request->agent;
        });

        // Re-index array
        $filteredArray = array_values($filteredArray);

        // Save back to the database
        $updatedAgents = json_encode($filteredArray);
        Log::info("Updated AGents : " . $updatedAgents);
        $agent = User::where('name', $clientName)->first();
        $result = ClientDetails::where('client_id', $agent->id)
            ->update(['agentConfig' => json_encode($updatedAgents)]);


        if ($result) {
            return response()->json(['success' => true, 'updated_data' => $filteredArray]);
        } else {
            return response()->json(['success' => false, 'Message' => 'Record Not Found']);
        }
    }

    public function get_psp_details($id)
    {
        $clientName = $id;
        $user = User::where('name', $clientName)->first();
        $pspConfig = $user && $user->clientDetails ? $user->clientDetails->pspConfig : null;

        $explode_id = json_decode($pspConfig, true);
        if (!$pspConfig || empty($pspConfig)) {
            return response()->json([]); // Return an empty array if no data
        }

        return response()->json(json_decode($pspConfig, true));
    }

    public function updatePSPDetails(Request $request)
    {
        $clientName = $request->clientName;
        $psps = $request->psps;

        Log::info($psps);
        Log::info($clientName);

        $implode_psps = json_encode($psps, true);

        Log::info($implode_psps);

        $userId = User::where('name', $clientName)->first();
        $result = ClientDetails::where('client_id', $userId->id)->update(['pspConfig' => $implode_psps]);

        Log::info($result);

        if ($result) {
            return response()->json(['message' => 'PSP details updated successfully']);
        } else {
            return response()->json(['error' => 'Update failed'], 500);
        }
    }

    public function deletePSP(Request $request)
    {
        $request->validate([
            'psp' => 'required|string',
        ]);

        $clientName = $request->clientName;
        $user = User::where('name', $clientName)->first();
        $record = ($user && $user->clientDetails) ? $user->clientDetails->pspConfig : null;


        Log::info($record);

        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record not found'], 404);
        }

        // Decode JSON
        $pspArray = json_decode($record, true);

        Log::info($pspArray);

        // Filter out the item to be removed
        $filteredArray = array_filter($pspArray, function ($item) use ($request) {
            return $item['pspName'] !== $request->psp;
        });

        // Re-index array
        $filteredArray = array_values($filteredArray);

        // Save back to the database
        $updatedPSPs = json_encode($filteredArray);
        Log::info("Updated PSPs : " . $updatedPSPs);
        $agent = User::where('name', $clientName)->first();
        $result = ClientDetails::where('client_id', $agent->id)
            ->update(['pspConfig' => json_encode($updatedPSPs)]);


        if ($result) {
            return response()->json(['success' => true, 'updated_data' => $updatedPSPs]);
        } else {
            return response()->json(['success' => false, 'Message' => 'Record Not Found']);
        }
    }
}

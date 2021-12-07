<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Models\Commission;
use App\Models\CommissionSlip;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashbackController extends ApiController
{
    public function index(Request $request)
    {
        $year = '';
        $years = explode(',', Config::get('cashback', 'year'));
        $years = array_combine($years, $years);
        krsort($years);

        if (!array_key_exists($year, $years)) {
            $keys = array_keys($years);
            $year = reset($keys);
        }

        $year = $request->year ? $request->year : $year;

        $getCommission = Commission::where('SCM_REP_EPC', $request->user()->code)
            ->whereRaw('substr(SCM_PERIODE,1,4) = ?', $year)
            ->select(
                DB::raw('sum(SCM_OTHER_COM) as other'),
                DB::raw('sum(SCM_PR_CB) as cashback'),
                'SCM_PERIODE as periode'
            )->groupBy('periode')->get();

        $getCashback = CommissionSlip::where('rp_rep_id', $request->user()->code)->where('rp_period_year', $year)
            ->join('market_places', 'market_places.id', '=', 'tbl_slip_commission.marketplace')
            ->select(
                'paid',
                'rp_net as cashback',
                'market_places.label as marketplace',
                'sih_so_invoice_date as order_date',
                DB::raw('TRIM(rp_no_invoice) as order_inv'),
                DB::raw('TRIM(sih_so_kp_number) as order_kp'),
                DB::raw('TRIM(mp_number) as order_mp'),
                DB::raw('CONCAT(rp_period_year, "", rp_period_month) as periode')
            )->orderBy('sih_so_invoice_date', 'asc')->get();

        $commission = [];
        $cashback = [];
        $fields = ['cashback', 'other', 'subtotal'];
        $total = [];

        foreach ($fields as $key)
            $total[$key] = 0;

        foreach ($getCommission as $data)
            $commission[$data->periode] = $data;

        foreach ($getCashback as $data)
            $cashback[$data->periode][] = $data;

        setlocale(LC_ALL, 'IND');
        for ($i=1; $i<=12; $i++) {
            $month = $i <= 9 ? $year.'-0'.$i : (string) $year.'-'.$i;
            $monthYear = strftime('%B, %Y', strtotime(date('F Y', strtotime($month.'-01'))));
            $key = str_replace('-', '', $month);

            if (array_key_exists($key, $commission)) {
                $item = $commission[$key];
                $item->subtotal = 0;
                $subtotalCashback = 0;

                foreach ($cashback[$key] as $v) {
                    $v->order_date = strftime('%d %B %Y', strtotime($v->order_date));
                    $subtotalCashback += $v->cashback;
                    if ($v->paid == 'Y')
                        $item->cashback += $v->cashback;
                }

                foreach (array_keys($total) as $k) {
                    if ($k == 'subtotal')
                        continue;
                    $item->subtotal += (double) $item->{$k};
                }

                foreach (array_keys($total) as $k)
                    $total[$k] += $item->{$k};

                $item->label = $monthYear;
                $item->subtotalCashback = $subtotalCashback;
            }
        }

        $response = [
            'years' => $years,
            'paid' => $commission,
            'cashback' => $cashback,
        ];

        return $this->respondWithSuccess($response);
    }

    public function pdf(Request $request)
    {
        $data = CommissionSlip::where('rp_rep_id', $request->user()->code)->where('rp_period', $request->periode)->where('paid', 'Y')
            ->join('market_places', 'market_places.id', '=', 'tbl_slip_commission.marketplace')
            ->select('tbl_slip_commission.*', 'market_places.label as mp')
            ->orderBy('rp_date_paid')->get();

        setlocale(LC_ALL, 'IND');
        $year = substr($request->periode, 0, 4);
        $month = substr($request->periode, 4, 2);
        $total = ['cashback' => 0, 'cwh' => 0, 'tax' => 0, 'net' => 0];
        $total['date'] = strftime('%d %B %Y', strtotime(date('d M Y')));
        $total['month'] = strftime('%B', strtotime(date('F',strtotime($year.'-'.$month.'-01'))));
        $total['periode'] = strftime('%B %Y', strtotime(date('F Y',strtotime($year.'-'.$month.'-01'))));

        foreach ($data as $value) {
            $total['cashback'] += $value->rp_gross;
            $total['cwh'] += $value->rp_cwh;
            $total['tax'] += $value->rp_tax;
            $total['net'] += $value->rp_net;
            $value->rp_name = trim($value->rp_name);
            $value->rp_date_paid = strftime('%d %B %Y', strtotime(date('d M Y',strtotime($value->rp_date_paid))));
        }

        $response = [
            'total' => $total,
            'data' => $data
        ];

        $filename = $request->user()->code . $request->periode;
        $path = 'media/download/pdf/' . $filename . '.pdf';
        $pdf = \PDF::loadView('common.pdf', compact('data'))->setPaper('a4', 'landscape')->save($path);

        return response($path);
    }

    public function excel(Request $request)
    {
        $commission = CommissionSlip::where('rp_rep_id', $request->user()->code)->where('rp_period', $request->periode)
            ->join('market_places', 'market_places.id', '=', 'tbl_slip_commission.marketplace')
            ->select('tbl_slip_commission.*', 'market_places.label as mp')
            ->orderBy('rp_date_paid')->get();

        $data = [];
        $no = 1;
        $cashback = 0;
        $cashvalue = 0;
        $tax = 0;
        $net = 0;
        foreach ($commission as $item) {
            $cashback += @$item->rp_gross;
            $cashvalue += @$item->rp_cashvalue;
            $tax += @$item->rp_tax;
            $net += @$item->rp_net;
            $data[] = [
                $no,
                date('d F Y', strtotime(@$item->sih_so_invoice_date)),
                @$item->sih_so_kp_number,
                @$item->rp_no_invoice,
                @$item->mp_number,
                @$item->mp,
                @$item->rp_nama_cust,
                Common::idr(@$item->rp_cashvalue),
                Common::idr(@$item->rp_gross),
                Common::idr(@$item->rp_tax),
                Common::idr(@$item->rp_net),
            ];
            $no++;
        }

        $data[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            Common::idr($cashvalue),
            Common::idr($cashback),
            Common::idr($tax),
            Common::idr($net),
        ];

        $response = Common::excel(
            ['No', 'Tanggal', 'No. KP', 'No. Invoice', 'No. MP', 'Market Place', 'Nama Customer',  'Cash Value', 'Cashback', 'Pajak', 'Net Cashback'],
            $data,
            $request->user()->code . $request->periode
        );

        return response($response);
    }
}

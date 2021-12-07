<!DOCTYPE html>
<html xml:lang="id" lang="id">
<head>
    <link href="{{ asset('media/icon.png') }}" rel="icon">
    <link href="{{ asset('media/icon.png') }}" rel="apple-touch-icon">
    <title>Tiramart - Slip Pembayaran</title>
    <style>
        /* General
-----------------------------------------------------------------------*/
        body {
            background-color: transparent;
            color: black;
            font-family: "arial", "verdana", "sans-serif";
            margin: 0px;
            padding-top: 0px;
            font-size: 10px;
        }

        h1 {
            font-size: 1.1em;
            font-style: normal;
            text-align: center;
            vertical-align: middle;
        }

        h2 {
            font-size: 1.05em;
        }

        img {
            border: none;
            margin-bottom: 5px;
            width: 75px
        }

        ul {
            list-style-type: circle;
            list-style-position: inside;
            margin: 0px;
            padding: 3px;
        }

        li.alpha {
            list-style-type: lower-alpha;
            margin-left: 15px;
        }

        p {
            font-size: 0.8em;
        }

        a:link,
        a:visited {
            text-decoration: none;
            color: black;
        }

        a:hover {
            text-decoration: underline;
        }

        #body {
            padding-bottom: 2em;
            padding-top: 5px;
        }

        #body pre {}

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        #money {
            text-align: right;
            padding-right: 20px;
        }

        /* Footer
-----------------------------------------------------------------------*/
        #footer {
            color: black;
        }

        #copyright {
            padding: 5px;
            font-size: 0.6em;
            background-color: white;
        }

        #footer_spacer_row {
            width: 100%;
        }

        #footer_spacer_row td {
            padding: 0px;
            border-bottom: 1px solid #000033;
            background-color: #F7CF07;
            height: 2px;
            font-size: 2px;
            line-height: 2px;
        }

        #logos {
            padding: 5px;
            float: right;
        }

        /* Content
-----------------------------------------------------------------------*/
        #content {
            padding: 0.2em 1% 0.2em 1%;
            min-height: 15em;
        }

        .page_buttons {
            text-align: center;
            margin: 3px;
            font-size: 0.7em;
            white-space: nowrap;
            font-weight: bold;
            width: 74%;
        }

        .link_bar {
            font-size: 0.7em;
            text-align: center;
            margin: auto;
        }

        .link_bar a {
            white-space: nowrap;
            font-weight: bold;
        }

        .page_menu li {
            margin: 5px;
            font-size: 0.8em;
        }

        /* Detail
-----------------------------------------------------------------------*/
        .detail_table {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            padding: 3px;
            margin: 15px;
        }

        .detail_head td {
            background-color: #ddd;
            color: black;
            font-weight: bold;
            padding: 3px;
            font-size: 0.75em;
            text-align: center;
        }

        .detail_label {
            padding: 3px;
            font-size: 0.75em;
            width: 16%;
            border-top: 1px solid #fff;
            border-bottom: 1px solid #fff;
            background-color: #ddd;
        }

        .detail_field {
            width: 33%;
            font-size: 0.8em;
            text-align: center;
            padding: 3px;
        }

        .detail_sub_table {
            font-size: 1em;
        }

        .detail_spacer_row td {
            border-top: 1px solid white;
            border-bottom: 1px solid white;
            background-color: #999;
            font-size: 2px;
            line-height: 2px;
        }

        #narrow {
            width: 50%;
        }

        .operation {
            width: 1%;
        }

        .summary_spacer_row {
            font-size: 0.1em;
        }

        .bar {
            border-top: 1px solid black;
        }

        /* Forms
-----------------------------------------------------------------------*/
        .form {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            margin-top: 10px;
        }

        .form td {
            padding: 3px;
        }

        .form th,
        .form_head td {
            background-color: #ddd;
            border-bottom: 1px solid black;
            color: black;
            padding: 3px;
            text-align: center;
            font-size: 0.65em;
            font-weight: bold;
        }

        .form_head a:link,
        .form_head a:visited {
            color: black;
        }

        .form_head a:hover {}

        .sub_form_head td {
            border: none;
            font-size: 0.9em;
            white-space: nowrap;
        }

        .form input {
            color: black;
            background-color: white;
            border: 1px solid black;
            padding: 1px 2px 1px 2px;
            text-decoration: none;
            font-size: 1em;
        }

        .form textarea {
            color: black;
            background-color: white;
            border: 1px solid black;
            font-size: 1em;
        }

        .form select {
            color: black;
            background-color: white;
            font-size: 1em;
        }

        .button,
        a.button {
            color: black;
            background-color: white;
            border: 1px solid black;
            font-weight: normal;
            white-space: nowrap;
            text-decoration: none;
        }

        a.button {
            display: inline-block;
            text-align: center;
            padding: 2px;
        }

        a.button:hover {
            text-decoration: none;
            color: black;
        }

        .form_field {
            color: black;
            background-color: white;
            font-size: 0.7em;
        }

        .form_label {
            color: black;
            background-color: #ddd;
            font-size: 0.7em;
            padding: 3px;
        }

        .form_foot td {
            background-color: #ddd;
            border-bottom: 1px solid black;
            color: black;
            padding: 3px;
            text-align: center;
            font-size: 0.65em;
            font-weight: bold;
        }

        .form_foot a:link,
        .form_foot a:visited {
            color: black;
        }

        .form_foot a:hover {
            color: black;
        }

        .no_border_input input {
            border: none;
        }

        .no_wrap {
            white-space: nowrap;
        }

        tr.row_form td {
            white-space: nowrap;
        }

        /* Wizards
-----------------------------------------------------------------------*/
        .wizard {
            font-size: 0.8em;
            border-top: 1px solid black;
        }

        #no_border {
            border: none;
        }

        .wizard p {
            text-indent: 2%;
        }

        .wizard td {
            padding: 3px;
        }

        .wizard input {
            color: black;
            background-color: white;
            border: 1px solid black;
            padding: 1px 2px 1px 2px;
            text-decoration: none;
        }

        .wizard textarea {
            color: black;
            background-color: white;
            border: 1px solid black;
        }

        .wizard select {
            color: black;
            background-color: white;
            border: 1px solid black;
        }

        .wizard_head {
            color: black;
            font-weight: bold;
        }

        .wizard_buttons {
            border-top: 1px solid black;
            padding-top: 3px;
        }

        .wizard_buttons a {
            background-color: white;
            border: 1px solid black;
            padding: 2px 3px 2px 3px;
        }

        /* List
-----------------------------------------------------------------------*/
        .list_table,
        .notif_list_table {
            color: black;
            padding-bottom: 4px;
            background-color: white;
        }

        .list_table td,
        .notif_list_table td {
            padding: 3px 5px 3px 5px;
        }

        .list_table input {
            color: black;
            background-color: white;
            border: 1px solid black;
            padding: 1px 2px 1px 2px;
            text-decoration: none;
        }

        .list_head,
        .notif_list_head {
            font-weight: bold;
            background-color: #ddd;
            font-size: 0.65em;
        }

        .list_head td,
        .notif_list_head td {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            color: black;
            text-align: center;
            white-space: nowrap;
        }

        .list_head a:link,
        .list_head a:visited,
        .notif_list_head a:link,
        .notif_list_head a:visited {
            color: black;
        }

        .list_head a:hover,
        .notif_list_head a:hover {}

        .list_foot {
            font-weight: bold;
            background-color: #ddd;
            font-size: 0.65em;
        }

        .list_foot td {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            color: black;
            text-align: right;
            white-space: nowrap;
        }

        .sub_list_head td {
            border: none;
            font-size: 0.7em;
        }

        .odd_row td {
            background-color: transparent;
            border-bottom: 0.9px solid #ddd;
        }

        .even_row td {
            background-color: #f6f6f6;
            border-bottom: 0.9px solid #ddd;
        }

        .spacer_row td {
            line-height: 2px;
            font-size: 2px;
        }

        .phone_table td {
            border: none;
            font-size: 0.8em;
        }

        div.notif_list_text {
            margin-bottom: 1px;
            font-size: 1.1em;
        }

        .notif_list_row td.notif_list_job {
            text-align: center;
            font-weight: bold;
            font-size: 0.65em;
        }

        .notif_list_row td.notif_list_dismiss table td {
            text-align: center;
            font-size: 1em;
            border: none;
            padding: 0px 2px 0px 2px;
        }

        .notif_list_row td {
            padding: 5px 5px 7px 5px;
            border-bottom: 1px dotted #ddd;
            background-color: white;
            font-size: 0.6em;
        }

        .notif_list_row:hover td {
            background-color: #ddd;
        }

        /* Page
-----------------------------------------------------------------------*/
        .page {
            border: none;
            padding: 0in;
            margin-right: 0.1in;
            margin-left: 0.1in;
            background-color: transparent;
        }

        .page table.header h1 {
            font-size: 12pt;
        }

        .page>h2,
        .page>p {
            margin-top: 2pt;
            margin-bottom: 2pt;
        }

        .page h2 {
            page-break-after: avoid;
        }

        .money_table {
            border-collapse: collapse;
            font-size: 6pt;
        }

        /* Tree
-----------------------------------------------------------------------*/
        .tree_div {
            display: none;
            background-color: #ddd;
            border: 1px solid #333;
        }

        .tree_div .tree_step_bottom_border {
            border-bottom: 1px dashed #8B9DBE;
        }

        .tree_div .button,
        .tree_row_table .button,
        .tree_div .no_button {
            width: 110px;
            font-size: 0.7em;
            padding: 3px;
            text-align: center;
        }

        .tree_row_desc {
            font-weight: bold;
            font-size: 0.7em;
            text-indent: -10px;
        }

        .tree_row_info {
            font-size: 0.7em;
            width: 200px;
        }

        .tree_div_head a,
        .tree_row_desc a {
            color: #000033;
            text-decoration: none;
        }

        .tree_div_head {
            font-weight: bold;
            font-size: 0.7em;
        }

        /* Summaries
-----------------------------------------------------------------------*/
        .summary {
            border: 1px solid black;
            background-color: white;
            padding: 1%;
            font-size: 0.8em;
        }

        .summary h1 {
            color: black;
            font-style: normal;
        }

        /* Sales-agreement specific
-----------------------------------------------------------------------*/
        table.sa_signature_box {
            margin: 2em auto 2em auto;
        }

        table.sa_signature_box tr td {
            padding-top: 1.25em;
            vertical-align: top;
            white-space: nowrap;
        }

        .special_conditions {
            font-style: italic;
            margin-left: 2em;
            white-space: pre;
        }

        .sa_head * {
            font-size: 7pt;
        }

        /* Change order specific
-----------------------------------------------------------------------*/
        table.change_order_items {
            font-size: 8pt;
            width: 100%;
            border-collapse: collapse;
        }

        table.change_order_items>tbody {
            border: 1px solid black;
        }

        table.change_order_items>tbody>tr>th {
            border-bottom: 1px solid black;
        }

        table.change_order_items>tbody>tr>td {
            border-right: 1px solid black;
        }

        td.change_order_total_col {
            padding-right: 4pt;
            text-align: right;
        }

        td.change_order_unit_col {
            padding-left: 2pt;
            text-align: left;
        }

    </style>
</head>

<body>
    <div id="body">
        <div id="content">
            <div class="page" style="font-size: 7pt">
                @php
                $path = public_path() . '/media/logo.png';
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $image = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($image);
                @endphp
                <img src="{{ $base64 }}" alt="" />
                <table style="width: 100%; position: absolute; top: 30px;" class="header">
                    <tr>
                        <td>
                            <h1>SLIP PEMBAYARAN CASHBACK TIRAMART</h1>
                        </td>
                    </tr>
                </table>
                <div style="border-top: 1px solid black; width: 100%; display: block; height: 1em;"></div>
                @php
                setlocale(LC_ALL, 'IND');
                @endphp
                @foreach($data as $v)
                @php
                $year = substr($v->rp_period, 0, 4);
                $month = substr($v->rp_period, 4, 2);
                @endphp
                <table class="" style="width: 100%; font-size: 8pt;">
                    <tr>
                        <td><span style="width: 150px; display: inline-block; font-size: 8pt;">Bulan </span>: <strong>{{ strftime('%B', strtotime(date('F',strtotime($year.'-'.$month.'-01')))) }}</strong></td>
                        <td><span style="width: 150px; display: inline-block; font-size: 8pt;">No. Rekening </span>: <strong>{{ $v->rm_acc_number }}</strong></td>
                    </tr>
                    <tr>
                        <td><span style="width: 150px; display: inline-block; font-size: 8pt;">Periode</span>: <strong>{{ strftime('%B %Y', strtotime(date('F Y',strtotime($year.'-'.$month.'-01')))) }}</strong></td>
                        <td><span style="width: 150px; display: inline-block; font-size: 8pt;">Branch </span>: <strong>{{ $v->rp_branch_id }}</strong></td>
                    </tr>
                    <tr>
                        <td><span style="width: 150px; display: inline-block; font-size: 8pt;">Kode / Nama Member </span>: <strong>{{ $v->rp_rep_id }} / {{ $v->rp_name }}</strong></td>
                        <td><span style="width: 150px; display: inline-block; font-size: 8pt;">Halaman </span>: <strong>1</strong><strong></strong></td>
                    </tr>
                    <tr>
                        {{-- <td><span style="width: 150px; display: inline-block; font-size: 8pt;">Level </span>: <strong>{{ $v->rp_position }} </strong></td> --}}
                        <td><span style="width: 150px; display: inline-block; font-size: 8pt;"></td>
                        <td><span style="width: 150px; display: inline-block; font-size: 8pt;">Tanggal </span>: <strong>{{ strftime('%d %B %Y', strtotime(date('d M Y'))) }}</strong></td>
                    </tr>
                </table>
                @break
                @endforeach
                <div style="border-top: 1px solid black; width: 100%; display: block; height: 1em;"></div>
                <table class="change_order_items" style="width: 100%; margin-top: 0px;">
                    {{-- <tr><td colspan="11"><h2>Achievement Per Month:</h2></td></tr> --}}
                    <tbody>
                        <tr>
                            <th style="">#</th>
                            <th style="">No.</th>
                            <th>No. KP</th>
                            {{-- <th>No. Invoice</th> --}}
                            <th>No. MP</th>
                            <th>MP</th>
                            <th>Nama Customer</th>
                            <th>Point</th>
                            <th style="width: 8%">Cash Value</th>
                            <th>Ket.</th>
                            <th style="width: 8%">Cashback</th>
                            <th style="width: 8%">CWH</th>
                            <th style="width: 8%"">Pajak</th>
                            <th style="border-right: 1px solid;width: 8%">Net Cashback</th>
                        </tr>
                        @php
                        $no = 0;
                        $slip = '';
                        $tot = ['commision' => 0, 'cwh' => 0, 'tax' => 0, 'net' => 0]
                        @endphp
                        @foreach ($data as $v)
                        @php
                        $tot['commision'] += $v->rp_gross;
                        $tot['cwh'] += $v->rp_cwh;
                        $tot['tax'] += $v->rp_tax;
                        $tot['net'] += $v->rp_net;
                        @endphp
                        @if ($slip != $v->rp_slip)
                        @php($slip = $v->rp_slip)
                        <tr>
                            <td style="font-weight: bold;"><span style="margin-left: 3px;">{{ $v->rp_slip }}</span><br><span style="margin-left: 3px;">({{ strftime('%d %B %Y', strtotime(date('d M Y',strtotime($v->rp_date_paid)))) }})</span></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            {{-- <td></td> --}}
                            <td style="border-right: 1px solid;"></td>
                        </tr>
                        @endif
                        @php($no++)
                        <tr>
                            <td style="font-weight: bold;"></td>
                            <td style="text-align: center">{{ $no }}</td>
                            <td><span style="margin-left: 3px;">{{ $v->sih_so_kp_number }}</span></td>
                            {{-- <td><span style="margin-left: 3px;">{{ $v->rp_no_invoice }}</span></td> --}}
                            <td><span style="margin-left: 3px;">{{ $v->mp_number }}</span></td>
                            <td><span style="margin-left: 3px;">{{ $v->mp }}</span></td>
                            <td><span style="margin-left: 3px;">{{ trim($v->rp_nama_cust) }}</span></td>
                            <td style="text-align: center"><span>{{ $v->rp_su }}</span></td>
                            <td><span style="margin-left: 3px;">Rp.</span><span style="float: right; margin-right: 3px;">@number($v->rp_cashvalue)</span></td>
                            <td style="text-align: center">{{ $v->rp_remarks }} </td>
                            <td><span style="margin-left: 3px;">Rp.</span><span style="float: right; margin-right: 3px;">@number($v->rp_gross)</span></td>
                            <td><span style="margin-left: 3px;">Rp.</span><span style="float: right; margin-right: 3px;">@number($v->rp_cwh)</span></td>
                            <td><span style="margin-left: 3px;">Rp.</span><span style="float: right; margin-right: 3px;">@number($v->rp_tax)</span></td>
                            <td style="border-right: 1px solid;"><span style="margin-left: 3px;">Rp.</span><span style="float: right; margin-right: 3px;">@number($v->rp_net)</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tr>
                        <td colspan="9" style="text-align: right; background:#EEE; font-weight: bold; height: 30px;">Total Cashback :</td>
                        <td style="background:#EEE; font-weight: bold;"><span style="margin-left: 3px;">Rp.</span><span style="float: right; margin-right: 3px;">@number($tot['commision'])</span></td>
                        <td style="background:#EEE; font-weight: bold;"><span style="margin-left: 3px;">Rp.</span><span style="float: right; margin-right: 3px;">@number($tot['cwh'])</span></td>
                        <td style="background:#EEE; font-weight: bold;"><span style="margin-left: 3px;">Rp.</span><span style="float: right; margin-right: 3px;">@number($tot['tax'])</span></td>
                        <td style="background:#EEE; font-weight: bold; border-right: 1px solid;"><span style="margin-left: 3px;">Rp.</span><span style="float: right; margin-right: 3px;">@number($tot['net'])</span></td>
                    </tr>
                </table>
                <div style="border-top: 1px solid black; width: 100%; display: block; height: 1em;"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // javascript: window.print();

    </script>
</body>
</html>

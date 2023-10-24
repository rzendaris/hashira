<!DOCTYPE html>
<html>
<head>
    <title>Invoice - Hashira</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;   
    }
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:200px;
        height:60px;        
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Invoice</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Invoice Id - <span class="gray-color">#{{ $payment->transaction->id }}.{{ $payment->id }}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Invoice Period - <span class="gray-color">{{ date('Y/m/d', strtotime($payment->start_date)) }} - {{ date('Y/m/d', strtotime($payment->end_date)) }}</span></p>
    </div>
    <div class="w-50 float-left logo mt-10">
        <!-- <img src="https://techsolutionstuff.com/frontTheme/assets/img/logo_200_60_dark.png" alt="Logo"> -->
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">From</th>
            <th class="w-50">To</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p>{{ $payment->transaction->student->name }},</p>
                    <p>{{ $payment->transaction->student->address }},</p>
                    <p>Indonesia</p>                    
                    <p>Contact: {{ $payment->transaction->student->phone_number }}</p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p> Hashira,</p>
                    <p>{{ $payment->transaction->student->batch->name }},</p>
                    <p>Indonesia</p>                    
                    <p>Contact: xxx-xxx-xxx</p>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Student Name</th>
            <th class="w-50">Installment</th>
            <th class="w-50">Price</th>
            <th class="w-50">Tax Amount</th>
            <th class="w-50">Grand Total</th>
        </tr>
        <tr align="center">
            <td>{{ $payment->transaction->student->name }}</td>
            <td>{{ $payment->installment }}/{{ $payment->transaction->installment }}</td>
            <td>Rp. {{ number_format($payment->nominal) }}</td>
            <td>0</td>
            <td>Rp. {{ number_format($payment->nominal) }}</td>
        </tr>
        <tr>
            <td colspan="4" align="right"><p>Sub Total</p></td>
            <td align="right"><p>Rp. {{ number_format($payment->nominal) }}</p></td>
        </tr>
        <tr>
            <td colspan="4" align="right"><p>Tax (0%)</p></td>
            <td align="right"><p>0</p></td>
        </tr>
        <tr>
            <td colspan="4" align="right"><p>Total Payable</p></td>
            <td align="right"><p>Rp. {{ number_format($payment->nominal) }}</p></td>
        </tr>
    </table>
</div>
</html>
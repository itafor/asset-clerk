<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt | Asset Clerk</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        .notification_header{
            font-size: 10px;
        }

    .item td{
        font-size: 14px;
    }
    .item b{
        font-size: 14px;
    }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                    @if(getUserPlan()['details']->name == 'Free')
                            <a href="http://assetclerk.com/">
                        <img src="{{ asset('img/logo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="50" height="40" >
                            </a> 
                            @else
                              @include('new.layouts.email_logo')
                            @endif
                            
                            <td style="text-align:right">
                                Created: {{date('F d, Y')}}<br>
                                Payment Date: {{$payment->payment_date->format('F d, Y')}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <b>Address:</b><br>
                               {{$payment->unitt->getTenant()->address}}
                            </td>
                            
                            <td style="text-align:right">
                                {{$payment->unitt->getTenant()->name()}} <br>
                                {{$payment->unitt->getTenant()->email}}
                            </td>
                        </tr>

                               <h5 class="notification_header"><u>Asset Clerk Electronic Notification Service</u></h5>
                          <tr>
                            <td colspan="2">
                                <p>
Dear {{$payment->unitt->getTenant()->email}},<br/>

 <em>  
    This is to notify you that the sum of  &#8358; {{number_format($payment->amount_paid, 2)}} has been recorded successfully for the payment of ({{$payment->startDate}}  <strong>to</strong>  {{$payment->due_date}}) rent
    .<br/>
   Please find below rental information.
 </em>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="item">
                <td>
                   <b> Property :</b>
                </td>
                
                <td>
                   {{$payment->unitt->getProperty()->description}}
                </td>
            </tr>
         <tr class="item">
                <td>
                   <b> Payment Method :</b>
                </td>
                
                <td>
                    {{$payment->paymentMode->name}}
                </td>
         </tr>
            
            <tr class="item">
                <td>
                   <b> Payment Item :</b>
                </td>
                
                <td>
                     {{$payment->unitt->category->name}} Bedroom
                </td>
         </tr>

         <tr class="item">
                <td>
                   <b> Price :</b>
                </td>
                
                <td>
                     &#8358; {{number_format($payment->actual_amount, 2)}}
                </td>
         </tr>
         <tr class="item">
                <td>
                   <b> Amount Paid:</b>
                </td>
                
                <td>
                    &#8358; {{number_format($payment->amount_paid, 2)}}
                </td>
         </tr>

         <tr class="item">
                <td>
                   <b> Balance:</b>
                </td>
                
                <td>
                   &#8358; {{number_format($payment->balance, 2)}}
                </td>
         </tr>

          <tr class="item">
                <td>
                   <b>  Rent Duration:</b>
                </td>
                
                <td>
            {{$payment->startDate}}  <strong>to</strong>  {{$payment->due_date}}
                </td>
         </tr>
            <tr class="item">
                <td>
                    <b> Payment Date : </b>
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y')}}
                </td>
            </tr>

          <tr class="item">
                <td>
                <b> Date recorded:</b>
                </td>
                
                <td>
                    {{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y')}}
                </td>
            </tr>
            
    <tr class="item">
                <td colspan="2">
        <b>Description:</b> {{$payment->payment_description}}
                </td>
        </tr>
            
    <tr class="total">
    <td></td>
                
     <td>
        Total: &#8358; {{number_format($payment->amount_paid, 2)}}
        </td>
    </tr>
    <br><br>
    <tr>
         <td>
                     @include('new.layouts.poweredby')
         </td>
    </tr>
        </table>
    </div>
</body>
</html>
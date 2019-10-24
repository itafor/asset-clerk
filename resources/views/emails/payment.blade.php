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
                            <td class="title">
                                <img src="{{$message->embed('img/logo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="118" height="71.66" >
                            </td>
                            
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
                               {{$payment->unit->getTenant()->address}}
                            </td>
                            
                            <td style="text-align:right">
                                {{$payment->unit->getTenant()->name()}} <br>
                                {{$payment->unit->getTenant()->email}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Property
                </td>
                
                <td>
                  
                </td>
            </tr>
            
            <tr class="details">
                <td colspan="2">
                    {{$payment->unit->getProperty()->description}}
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Payment Method
                </td>
                
                <td>
                  
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    {{$payment->paymentMode->name}}
                </td>
                
                <td>
                  
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                  Payment Item
                </td>
                
                <td>
                    Price
                </td>
            </tr>
            
            <tr class="item">
               
                
                <td>
                    &#8358; {{number_format($payment->amount_paid, 2)}}
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
        </table>
    </div>
</body>
</html>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Rental | Asset Clerk</title>
    
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
                            @if($companyDetail)
                             <td class="title">
                    <img src="{{asset('uploads/'.$companyDetail->logo)}}" alt="Logo" title="Company logo" width="40" height="30">
                            </td>
                            @else
                             <td class="title">
                                <img src="{{ asset('img/companydefaultlogo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="50" height="50" >
                            </td>

                            @endif
                            <td style="text-align:right">
                                
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                           <p>Dear <span>{{$walletHistory->tenantWallet->firstname}} ,</span><br/>
                            Your wallet have been {{$walletHistory->transaction_type =='Deposit' ? 'funded' : 'Debited'}}, Please find below wallet information.
                           </p>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Amount
                </td>
                
                <td>
                  
                </td>
            </tr>
            
            <tr class="details">
                <td colspan="2">
          &#8358; {{number_format($walletHistory->amount,2)}}
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Balance
                </td>
                
                <td>
                  
                </td>
            </tr>
            
            <tr class="details">
                <td colspan="2">
                    
                     &#8358; {{number_format($walletHistory->new_balance,2)}}
                </td>
            </tr>
            
           
            
            <tr class="heading">
                <td>
                    Date
                </td>
                
                <td>
                 
                </td>
            </tr>
            
            <tr class="details">
                <td colspan="2">
                    {{ \Carbon\Carbon::parse($walletHistory->created_at)->format('d M Y')}}
                </td>
            </tr>
            @if($walletHistory->transaction_type =='Withdrawal')
               <tr class="heading">
                <td>
                    Reason
                </td>
                
                <td>
                 
                </td>
            </tr>
            
            <tr class="details">
                <td colspan="2">
                    We have emailed you 'Service Charge Payment Receipt' for more information regarding this transaction, kindly check it out.
                </td>
            </tr>
            @endif
              <tr>
                 <td class="title">
                     Powered by  <a href="http://assetclerk.com/">
                        <img src="{{ asset('img/logo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="40" height="30" >
                     </a>         
                 </td>
            </tr>
        </table>
    </div>
</body>
</html>
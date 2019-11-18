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
        .notification_header{
            font-size: 10px;
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
                                <img src="{{ asset('img/logo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="118" height="71.66" >
                            </td>
                            
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
                            <td>
                                <b>Address:</b><br>
                               {{$rental->unit->getTenant()->address}}
                            </td>
                            
                            <td style="text-align:right">
                              <strong> Name:</strong> {{$rental->unit->getTenant()->name()}} <br>
                              <strong> Email:</strong> {{$rental->unit->getTenant()->email}}
                            </td>
                        </tr>
                        <h5 class="notification_header"><u>Asset Clerk Electronic Notification Service</u></h5>
                          <tr>
                            <td colspan="2">
                                <p>
Dear {{$rental->unit->getTenant()->firstname}},<br/>

 <em>  We wish to notify you that your rent will be due on {{getNextRentPayment($rental)['due_date']}}, and it will be renewed automatically by one year duration. Details of new rent's price and durations will be sent to you in few days.

In case you don't want your rent to be renewed once it expired, 
Please kindly contact your landload or Agent to disable auto renewal of your rents.<br/> Please find below rental information.</em>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td>
                    PROPERTY:
                </td>
                
                <td>
                   {{$rental->unit->getProperty()->description}} - {{$rental->unit->category->name}} Bedroom
                </td>
            </tr>
            <tr>
                <td>
                    PRICE:
                </td>
                
                <td>
                    &#8358; {{number_format($rental->amount,2)}}
                </td>
            </tr>
           
           <tr>
                <td>
                    RENT DURATION:
                </td>
                
                <td>
                     {{$rental->duration}}
                </td>
            </tr>

             <tr>
                <td>
                   START DATE:
                </td>
                
                <td>
                     {{ \Carbon\Carbon::parse($rental->startDate)->format('d M Y')}}
                </td>
            </tr>
        
          <tr>
                <td>
                   DUE DATE:
                </td>
                
                <td>
                    {{getNextRentPayment($rental)['due_date']}}
                </td>
            </tr>

             <tr >
                <td>
                    <h4>LANDLORD DETAILS</h4>
                </td>
            </tr>

             <tr>
                <td>
                    NAME: {{$rental->unit->getProperty()->landlord->name()}}
                </td>
            </tr>
            <tr>
                <td>
                  PHONE: {{$rental->unit->getProperty()->landlord->phone}}
                </td>

            </tr>
             <tr>
                <td>
                   EMAIL: {{$rental->unit->getProperty()->landlord->email}}
                </td>
            </tr>

            <tr>
                <td>
                    <h4>AGENT DETAILS</h4>
                </td>
            </tr>

             <tr>
                <td>
                   NAME: {{$rental->unit->getProperty()->landlord->tenant_agent->firstname}} 

                   {{$rental->unit->getProperty()->landlord->tenant_agent->lastname}}
                    
                </td>
            </tr>
            <tr>
                <td>
                   PHONE: {{$rental->unit->getProperty()->landlord->tenant_agent->phone}}
                 
                </td>

            </tr>
             <tr>
                <td>
                   EMAIL: {{$rental->unit->getProperty()->landlord->tenant_agent->email}}
                </td>
            </tr>

               <tr>
                
                <td>
                    Thank you for choosing <a href="http://assetclerk.com/">AssetClerk</a> Limited
                </td>
            </tr>

            
        </table>
    </div>
</body>
</html>
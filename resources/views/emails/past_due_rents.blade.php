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

#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  font-size: 12px;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #808080;
  color: white;
  font-size: 14px;
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
        <table cellpadding="0" cellspacing="0" style="margin-bottom: -50px">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                            <a href="http://assetclerk.com/">
                        <img src="{{ asset('img/companydefaultlogo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="50" height="40" >
                            </a> 
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
                        <h5 class="notification_header"><u>Asset Clerk Electronic Notification Service</u></h5>
                          <tr>
                            <td colspan="2">
                                <p>
Dear {{$userDetail->firstname}} {{$userDetail->lastname}},<br/>

 <em> Below is a list of your past due rents</em>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

         <h2>Past Due Rents</h2>
          <h5>Total Unpaid Rents: <span style="color: red;">&#8358; {{number_format($totalRentsNotPaid,2)}}</span></h5>
                    <table class="table table-bordered" id="customers">
                        <thead>
                            <tr>
                                <th scope="">S/N</th>
                                <th scope="">Tenant</th>
                                <th scope="col">Property</th>
                                <th scope="col">Property Type</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($past_due_rents2 as $rental)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$rental->tenant ? $rental->tenant->name() : ''}}</td>
                                    <td>{{$rental->asset ? $rental->asset->description : ''}}</td>
                                    <td>
                         @if($rental->unit)
                         @if($rental->unit->propertyType)
                         {{$rental->unit->propertyType->name}}
                         @endif
                         @else
                         <span>N/A</span>
                         @endif
                                    </td>
                                    <td>{{$rental ? $rental->flat_number : 'N/A'}}</td>
                                    <td>&#8358;{{number_format($rental->price,2)}}</td>
                                    <td>&#8358;{{number_format($rental->balance,2)}}</td>
                                    <td>{{getNextRentPayment($rental)['due_date']}}</td>

                            <td>
                           @if ($rental->status == 'Partly paid' )
                           <span style="color: #D2691E;">{{$rental->status}}</span>

                           @elseif($rental->status == 'Paid')
                           <span style="color: #008000;">{{$rental->status}}</span> 

                            @else
                           <span style="color: #FF0000;">{{$rental->status}}</span>
                           @endif

                          </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
    </div>

</body>
</html>
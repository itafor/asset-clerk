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
        #rental_table {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  font-size: 12px;
}

#rental_table td{
  border: 1px solid #ddd;
  padding: 8px;
}
#rental_table .rent_title{
  width: 150px;
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
                            @if(getUserPlan($rental->user_id)['details']->name == 'Free')
                            <a href="http://assetclerk.com/">
                        <img src="{{ asset('img/companydefaultlogo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="50" height="40" >
                            </a> 
                            @else
                              @include('new.layouts.email_logo')
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
                            
                             <td style="text-align:right">
                              <strong> Name:</strong> {{$rental->tenant->firstname}} {{$rental->tenant->lastname}} <br>
                              <strong> Email:</strong> {{$rental->tenant->email}}
                            </td>
                        </tr>
                       
                          <tr>
                            <td colspan="2">

                                <p>
                                
Dear {{$rental->tenant->firstname}},<br/>
<em>
 @if($defaultRemainingDuration == 0)
   We wish to notify you that your current rent is due. Renew you rent as soon as possible.
@else
  We wish to notify you that your rent will be due on {{getNextRentPayment($rental)['due_date']}}
@endif
<br/> Please find below rental details.</em>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

<h4>CURRENT RENT DETAILS </h4> 
        <table class="table table-bordered" id="rental_table">
           
                    <tbody>

                   <tr>
                     <td class="rent_title">PROPERTY</td>
                     <td> {{$rental->asset->description}}</td>
                   </tr>

                     <tr>
                     <td class="rent_title">PRICE</td>
                     <td>&#8358; {{number_format($rental->amount,2)}}</td>
                   </tr>

                    <tr>
                     <td class="rent_title">RENT DURATION</td>
                <td>{{$rental->duration}}</td>           
              </tr>

                 <tr>
                     <td class="rent_title">START DATE</td>
                     <td>{{ \Carbon\Carbon::parse($rental->startDate)->format('d M Y')}}</td>
                </tr>

                 <tr>
                     <td class="rent_title">DUE DATE</td>
                     <td>
                      
                     {{getNextRentPayment($rental)['due_date']}}
                    
                    </td>
                </tr>

                 <tr>
                     <td class="rent_title">DATE CREATED</td>
                      <td>
     {{ \Carbon\Carbon::parse($rental->created_at)->format('d M Y')}}
                        </td>
                </tr>
                 <tr>
                     <td class="rent_title">PAYMENT STATUS</td>
                      <td>
                           @if ($rental->status == 'Partly paid' )
                           <span style="color: brown">{{$rental->status}}</span>

                           @elseif($rental->status == 'Paid')
                           <span style="color: green">{{$rental->status}}</span> 

                            @else
                           <span style="color: red">{{$rental->status}}</span>
                           @endif
                          </td>

                </tr>
                <tr>
                     <td class="rent_title">RENEWABLE STATUS</td>
                     
                           @if($rental->renewable == 'yes')
                            <td style="color: green"> Renewable</td>
                           @else
                            <td style="color: red">Not Renewable</td>
                           @endif

                </tr>
               
       </tbody>
                  </table>

        


<br><br>
                    @include('new.layouts.poweredby')
    </div>
</body>
</html>
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
                          <td>
                            <a href="http://assetclerk.com/">
                        <img src="{{ asset('img/logo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="50" height="40" >
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
                          <tr>
                            <td colspan="2">

                                <p>
                                
Dear {{$user->firstname}} {{$user->lastname}},<br/>

Please fine below your account summary

<br/> </em>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
  <h4>ACCOUNT SUMMARY</h4>
        <table class="table table-bordered" id="rental_table">
           
                    <tbody>
                      <tr>
                     <td class="rent_title">Plan</td>
                     <td>
                    
        {{getSubscriptionByUUid($subs->plan_id)->name}}
                   
                     </td>
                   </tr>

                   <tr>
                     <td class="rent_title">Total Slot</td>
                     <td>
                     @if (getSlots($user->id)['totalSlots'] == 'Unlimited')
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{getSlots()['totalSlots']}}</h2>
                    @else
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getSlots($user->id)['totalSlots'])}}</h2>
                    @endif
                     </td>
                   </tr>

                     <tr>
                     <td class="rent_title">Slot used</td>
                     <td> 
                      <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getTotalAssets($user->id))}}</h2>
                     </td>
                   </tr>


                    <tr>
                     <td class="rent_title">Available Slot</td>
                <td>
                   @if (getSlots($user->id)['availableSlots'] == 'Unlimited')
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{getSlots($user->id)['availableSlots']}}</h2>
                    @else
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getSlots($user->id)['availableSlots'])}}</h2>
                    @endif
                </td>           
              </tr>
              <tr>
                <td>Number of Landlords</td>
                <td>{{$landlord}}</td>
              </tr>
              <tr>
                <td>Number of Tenants</td>
                <td>{{$tenant}}</td>
              </tr>
              
             
       </tbody>
                  </table>
      <table class="table table-bordered" id="rental_table">
                        <thead>
                            <tr>
                                <th scope="">S/N</th>
                                <th scope="">Asset</th>
                                <th scope="">Number of Units</th>
                                <th scope="">Number of rents</th>
                            </tr>
                        </thead>
                        <tbody>
                 @foreach($assets as $asset)
                                    <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$asset->description}}</td>
                  <td>{{$asset->units->count()}}</td>
                  <td>
                    @foreach($asset->units as $unit)
                    reference({{$unit->uuid}}) : {{$unit->quantity}},
              @endforeach

                  </td>
                   </tr>
              @endforeach
                        </tbody>
                    </table>



<br><br>
                   
    </div>
</body>
</html>
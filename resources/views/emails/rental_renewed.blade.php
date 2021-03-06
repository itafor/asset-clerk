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
                       
                            <a href="http://assetclerk.com/">
                        <img src="{{ asset('img/companydefaultlogo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="50" height="40" >
                            </a> 
                            
                            
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
                                Dear {{$theUser->firstname}} {{$theUser->lastname}},<br>
                                <em>
                                  We wish to inform you that <strong>{{$rental->unit ? $rental->unit->getTenant()->name() : ''}}</strong> 's rent have been renewed successfully.
                                 <br/>
                                  Please find below rental information.
                                </em>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

<h4>CURRENT RENT DETAILS</h4>
        <table class="table table-bordered" id="rental_table">
           
                    <tbody>

                   <tr>
                     <td class="rent_title">PROPERTY</td>
                     <td> {{$currentRental->asset ? $currentRental->asset->description : ''}}
                     - {{$currentRental->unit ? $currentRental->unit->unitname:'N/A'}}</td>
                   </tr>

                   <tr>
                     <td class="rent_title">PROPERTY TYPE</td>
                     <td> 
                     {{$currentRental->unit ? $currentRental->unit->propertyType->name:'N/A'}}</td>
                   </tr>

                    <tr>
                     <td class="rent_title">UNIT</td>
                     <td> 
                     {{$currentRental ? $currentRental->flat_number :'N/A'}}</td>
                   </tr>

                     <tr>
                     <td class="rent_title">PRICE</td>
                     <td>&#8358; {{number_format($currentRental->amount,2)}}</td>
                   </tr>

                    <tr>
                     <td class="rent_title">RENT DURATION</td>
                <td>{{$currentRental->duration}}</td>           
              </tr>

                 <tr>
                     <td class="rent_title">START DATE</td>
                     <td>{{ \Carbon\Carbon::parse($currentRental->startDate)->format('d M Y')}}</td>
                </tr>

                 <tr>
                     <td class="rent_title">DUE DATE</td>
                     <td>
                      
                     {{getNextRentPayment($currentRental)['due_date']}}
                    
                    </td>
                </tr>

                 <tr>
                     <td class="rent_title">DATE CREATED</td>
                      <td>
     {{ \Carbon\Carbon::parse($currentRental->created_at)->format('d M Y')}}
                        </td>
                </tr>
                <tr>
                     <td class="rent_title">PAYMENT STATUS</td>
                      <td>
                           @if ($currentRental->status == 'Partly paid' )
                           <span style="color: brown">{{$currentRental->status}}</span>

                           @elseif($currentRental->status == 'Paid')
                           <span style="color: green">{{$currentRental->status}}</span> 

                            @else
                           <span style="color: red">{{$currentRental->status}}</span>
                           @endif
                          </td>

                </tr>
                <tr>
                     <td class="rent_title">RENEWABLE STATUS</td>
                     
                           @if($currentRental->renewable == 'yes')
                            <td style="color: green"> Renewable</td>
                           @else
                            <td style="color: red">Not Renewable</td>
                           @endif

                </tr>
       </tbody>
                  </table>



<h4>RENEWED RENT DETAILS <a href="{{ route('rental.edit', ['uuid'=>$rental->uuid]) }}" class="dropdown-item">View and edit</a></h4> 
        <table class="table table-bordered" id="rental_table">
           
                    <tbody>

                   <tr>
                     <td class="rent_title">PROPERTY</td>
                     <td> {{$rental->unit ? $rental->unit->getProperty()->description:''}} - {{$rental->unit ? $rental->unit->unitname:''}} </td>
                   </tr>

                    <tr>
                     <td class="rent_title">PROPERTY TYPE</td>
                     <td> {{$rental->unit ? $rental->unit->propertyType->name:''}} </td>
                   </tr>

                    <tr>
                     <td class="rent_title">UNIT</td>
                     <td> {{$rental ? $rental->flat_number:''}} </td>
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

                <h4>TENANT DETAILS</h4>
        <table class="table table-bordered" id="rental_table">
           
                    <tbody>

                   <tr>
                     <td class="rent_title">NAME</td>
                     <td> {{$rental->unit ? $rental->unit->getTenant()->name():''}} </td>
                   </tr>

                     <tr>
                     <td class="rent_title">PHONE</td>
                     <td>  {{$rental->unit ? $rental->unit->getTenant()->phone :''}}</td>
                   </tr>

                    <tr>
                     <td class="rent_title">EMAIL</td>
                <td> {{$rental->unit ? $rental->unit->getTenant()->email : ''}}</td>           
              </tr>
                 <tr>
                     <td class="rent_title">ADDRESS</td>
                <td> {{$rental->unit ? $rental->unit->getTenant()->address : ''}}</td>           
              </tr>

       </tbody>
                  </table>

        

    </div>
</body>
</html>
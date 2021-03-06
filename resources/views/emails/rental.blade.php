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
                            <!-- <td>
                                <b>Address:</b><br>
                               {{$rental->tenant->address}}
                            </td> -->
                            
                            <td style="text-align:right">
                                 {{$rental->tenant->firstname}}
                                {{$rental->tenant->lastname}} <br>
                                {{$rental->tenant->email}}
                            </td>
                        </tr>

                         <tr>
                            <td colspan="2">
                                Dear  {{$rental->tenant->firstname}}
                                {{$rental->tenant->lastname}} ,<br>
                                <em>
                               This is to notify you that, You have just been assigned to {{$rental->asset->description}}
                                 <br/>
                                  Please find below rental information.
                                </em>
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
                   {{$rental->asset->description}}
                </td>
            </tr>

              <tr class="heading">
                <td>
                    Property Type
                </td>
                
                <td>
                  
                </td>
            </tr>
            
            <tr class="details">
                <td colspan="2">
               @if($rental->unit)
                         @if($rental->unit->propertyType)
                         {{$rental->unit->propertyType->name}}
                         @endif
                         @else
                         <span>N/A</span>
                         @endif
                </td>
            </tr>

             <tr class="heading">
                <td>
                   UNIT
                </td>
                
                <td>
                  
                </td>
            </tr>
               <tr class="details">
                <td colspan="2">
{{$rental->flat_number ? $rental->flat_number : 'N/A'}}
                </td>
            </tr>
              
            <tr class="heading">
                <td>
                  Rent Details
                </td>
                <td></td>
            </tr>
            
            <tr class="item">
                <td>
                    <b>Price:</b>
                </td>
                
                <td>
                    &#8358; {{number_format($rental->amount,2)}}
                </td>
            </tr>

            <tr class="item">
                <td>
                    <b>Rent Duration:</b>
                </td>
                
                <td>
                    {{$rental->duration}}
                </td>
            </tr>

            <tr class="item">
                <td>
                    <b>Rent Start Date:</b>
                </td>
                
                <td>
                   {{ \Carbon\Carbon::parse($rental->startDate)->format('d M Y')}}
                </td>
            </tr>

            <tr class="item">
                <td>
                    <b>Rent Due Date:</b>
                </td>
                
                <td>
                    {{getNextRentPayment($rental)['due_date']}}
                </td>
            </tr>
            <br><br>
              <tr>
                <td> @include('new.layouts.poweredby')</td>
            </tr>
        </table>
    </div>
</body>
</html>
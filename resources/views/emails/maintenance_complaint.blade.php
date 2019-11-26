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
                                @include('new.layouts.email_logo')
                            
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
                               {{$maintenanceComplaint->tenant->address}}
                            </td>
                            
                            <td style="text-align:right">
                              <strong> Name:</strong> 
                              {{$maintenanceComplaint->tenant->designation}} 
                               {{$maintenanceComplaint->tenant->firstname}}
                               {{$maintenanceComplaint->tenant->lastname}}
                              <br>
                              <strong> Email:</strong>{{$maintenanceComplaint->tenant->email}}
                            </td>
                        </tr>
                        <h5 class="notification_header"><u>Asset Clerk Electronic Notification Service</u></h5>
                          <tr>
                            <td colspan="2">
                                Dear {{$maintenanceComplaint->tenant->firstname}},
                                <em>
                                 This is to notify you that your compaint has been 

                                 
                                 @if($status === '')
                                  logged
                                  @elseif($status === 'Unfixed')
                                    Fixed
                                 @else
                                 reset to <b>Unfixed</b>
                                 @endif

                                 successfully. 
                                
                            @if($status === 'Unfixed')

                                 @else

                                  You will receive a notification as soon as it's fixed

                            @endif
                                 <br/>
                                  Please find below complaint's details.
                                </em>
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
                  {{$maintenanceComplaint->asset_maintenance($maintenanceComplaint->asset_description_uuid)['descriptn']}}
                </td>
            </tr>

             <tr>
                <td>
                    PROPERTY LOCATION:
                </td>
                
                <td>
                  {{$maintenanceComplaint->asset ? $maintenanceComplaint->asset->address : ''}}
                </td>
            </tr>

                <tr>
                <td>
                    COMPLAINT DESCRIPTION:
                </td>
                
                <td>
                    <p>
                  {{$maintenanceComplaint->description}}
                    </p>
                </td>
            </tr>
           
           <tr>
                <td>
                    Reported Date:
                </td>
                
                <td>
                 {{formatDate($maintenanceComplaint->reported_date, 'Y-m-d', 'd/m/Y') }}
            </tr>

                @if($status === '')
           <tr>
                <td>
                    Date Logged:
                </td>
                
                <td>
                  {{Carbon\Carbon::parse($maintenanceComplaint->created_at)->format('d/m/Y')}}
                </td>
            </tr>

            @else

            <tr>
                <td>
                   Date Updated :
                </td>
                
                <td>
                  {{Carbon\Carbon::parse($maintenanceComplaint->updated_at)->format('d/m/Y')}}
                </td>
            </tr>
            @endif


             <tr>
                <td>
                    Status:
                </td>
                
                @if($maintenanceComplaint->status === 'Fixed')
                              <td class="btn btn-success" style="color: green;">{{$maintenanceComplaint->status}}</td>
                              @else
                              <td class="btn btn-danger" style="color: red;">{{$maintenanceComplaint->status}}</td>
                @endif
                          
            </tr>
                <br>
            <tr>
                <td class="title">
                                @include('new.layouts.poweredby')
                 </td>
            </tr>
        </table>
    </div>
</body>
</html>
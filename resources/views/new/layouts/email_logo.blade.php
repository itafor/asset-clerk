@if($companyDetail)
                 <td class="title">
        <img src="{{asset('uploads/'.$companyDetail->logo)}}" alt="Logo" title="Company logo" width="50" height="50">
        <div style="font-size: 14px; font-family: roboto;">{{$companyDetail->name}}</div>
                </td>
                @else
                 <td class="title">
                    <img src="{{ asset('img/companydefaultlogo.png')}}" alt="Asset Clerk" title="Asset Clerk" width="50" height="50" >
                </td>

 @endif
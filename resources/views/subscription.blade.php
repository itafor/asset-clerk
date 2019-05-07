@php
    $plan = getUserPlan();
@endphp
<div class="alert alert-info"
     style="border-radius:0; margin-bottom:0;text-align:center; position:fixed;top:0; width:100%">
    <span class="alert-inner--icon"><i class="icon icon-notification"></i></span>
    <span class="alert-inner--text"></span>
</div>

<div class="editor-indent" style="margin-left: 20px; padding: 0 0 0 40px; margin-right: 50px">
    <table style="background-color: #F2F9FF; border-radius: 10px; margin-bottom: 20px">
        <tbody>
        <tr>
            <td style="font-size: 48px; opacity: 0.25; padding: 20px; padding-top: 15px; padding-right: 0px; vertical-align: top">
                <i class="fa fa-info-circle"></i></td>
            <td style="padding: 20px">
                <strong>Info!</strong> You are on the {{ $plan['details']->name }} plan. You can only
                manage {{ $plan['details']->properties }} properties and {{ $plan['details']->sub_accounts }} Sub Accounts. Your subscription ends
                on {{ date("M jS, Y", strtotime($plan['plan']->end)) }}. Click <a href="{{route('verification')}}"><kbd>HERE</kbd></a>
                to upgrade.

                </p>
            </td>
        </tr>
        </tbody>
    </table>
</div>

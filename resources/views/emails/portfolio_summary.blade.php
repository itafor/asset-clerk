<!DOCTYPE html>
<html>
<head>
	<title>Portfolio</title>
</head>
<body>
       <div class="media">

                    <i class="icon icon-company icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    @if (getSlots($user->id)['totalSlots'] == 'Unlimited')
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{getSlots()['totalSlots']}}</h2>
                    @else
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getSlots($user->id)['totalSlots'])}}</h2>
                    @endif
                    <p class="mb-0">Total Assets</p>
                    </div>
                    <!-- /media body -->
                </div>

                   <div class="media">

                    <i class="icon icon-company icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getTotalAssets($user->id))}}</h2>
                    <p class="mb-0">Slot used</p>
                    </div>
                    <!-- /media body -->

                </div>

                        <div class="media">

                    <i class="icon icon-company icon-4x mr-2 align-self-center"></i>

                    <!-- Media Body -->
                    <div class="media-body">
                    @if (getSlots($user->id)['availableSlots'] == 'Unlimited')
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{getSlots($user->id)['availableSlots']}}</h2>
                    @else
                        <h2 class="mb-1 h1 font-weight-semibold text-white">{{number_format(getSlots($user->id)['availableSlots'])}}</h2>
                    @endif
                    <p class="mb-0">Available Assets</p>
                    </div>
                    <!-- /media body -->

                </div>
</body>
</html>
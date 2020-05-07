<div class="row">
    <!-- multistep form -->

 <form id="msform">
    <!-- progressbar -->
    <ul id="progressbar">
           
             @if(isset($next_step_landlord))
             <li class="activ text-white">
        Landlords
        </li>
     @else 
      <li>
        Landlords
        </li>
      @endif
       
 @if(isset($next_step_asset))
       <li class="activ text-white">
           Assets
       </li>
      @else 
           <li>
           Assets
       </li>
@endif

@if(isset($next_step_tenant))
    
           <li class="activ text-white">
           Tenants
       </li>
@else 
       <li> 
           Tenants
       </li>
@endif

@if(isset($next_step_rental))
           <li class="activ text-white">
           Rentals
       </li>
@else 
       <li> 
           Rentals
       </li>
@endif

@if(isset($next_step_rental_payment))
           <li class="activ text-white">
           Payment
       </li>
@else 
       <li> 
           Payment
       </li>
@endif

@if(isset($next_step_rental_summary))
           <li class="activ text-white">
           Summary
       </li>
@else 
       <li> 
           Summary
       </li>
@endif
    </ul>

</form>

</div>
    
  @if(isset($next_step_landlord))
        @include('new.admin.multiStepForm.landlord')
    @endif

    @if(isset($next_step_asset))
        @include('new.admin.multiStepForm.asset')
    @endif

     @if(isset($next_step_tenant))
        @include('new.admin.multiStepForm.tenant')
    @endif

    @if(isset($next_step_rental))
        @include('new.admin.multiStepForm.rental')
    @endif

    @if(isset($next_step_rental_payment))
         @include('new.admin.multiStepForm.payRent')
    @endif

     @if(isset($next_step_rental_summary))
         @include('new.admin.multiStepForm.summary')
    @endif 
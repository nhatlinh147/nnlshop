 <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">My
     Account</button>
 <div class="dropdown-menu dropdown-menu-right">
     <button class="dropdown-item" type="button"
         onclick="window.location.href = '{{ route('frontend.sign_in_customer') }}'">
         Sign In
     </button>
     <button class="dropdown-item" type="button"
         onclick="window.location.href = '{{ route('frontend.sign_up_customer') }}'">
         Sign Up
     </button>
 </div>

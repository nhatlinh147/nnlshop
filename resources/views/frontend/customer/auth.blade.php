 <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown"
     data-user="{{ $username }}">{{ $username }}</button>

 <style>
     div.dropdown-menu div.card {
         max-width: 300px;
         border: none;
     }

     div.dropdown-menu div.card p {
         font-size: 14px;
     }
 </style>

 <div class="dropdown-menu dropdown-menu-right" id="Personal_Info">
     <div class="card">
         <div class="card-body text-center">
             @php
                 $image = empty($image) ? 'default.jpg' : $image;
             @endphp
             <img src="{{ asset('public/upload/avatar/' . $image) }}" alt="avatar" class="rounded-circle img-fluid"
                 style="width: 150px;">
             <h5 class="mb-2">{{ $username }}</h5>
             <p class="text-muted mb-1">{{ $email }}</p>
             <p class="text-muted mb-4">{{ $address }} </p>
             <div class="d-flex justify-content-center mb-2">
                 <a href="{{ route('frontend.logout_by_auth') }}">
                     <button type="button" class="btn btn-outline-primary ms-1">Log out</button>
                 </a>
             </div>
         </div>

     </div>
 </div>

<style>
    <style>
    .choices[data-type*="select-one"] {
        cursor: pointer;
        width: 112%;
        }
</style>
</style>
                    
                        <header id="page-topbar">
                            <div class="layout-width">
                                <div class="navbar-header">
                                    <div class="d-flex">
                                       <?php 
                                        $first_name1 =session()->get('first_name1');
                                        $category_id =session()->get('categoryid');                                  
                                        ?>
                                        <div class="navbar-brand-box horizontal-logo">
                                            <a href="{{ route('home') }}" class="logo logo-dark">
                                                <span class="logo-lg">
                                                    <img src="{{ asset('assets/images/logo.png') }}" alt="" height="80">
                                                </span>
                                            </a>
                                        </div>
                                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                                        id="topnav-hamburger-icon">
                                        <span class="hamburger-icon">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </span>
                                    </button>
                                    </div>
                                   <?php $session1 = auth()->user(); ?>         
                                        @if(!is_null($session1) && $session1->role_id == 2)
                                        <div class="col-md-6 mb-2 d-flex d-sd-none">
                                            <form id="form" class="d-flex" method="post" action="{{route('Membersearch.index')}}">
                                            @csrf
                                            <div class="input-group mx-2 w-100">
                                                <input type="text" class="form-control" name="first_name" placeholder="Search" id="first_name" value="<?= isset($first_name1) ? $first_name1 : '' ?>">
                                            </div>
                                            <!-- <div class="input-group mx-2 w-100">
                                            <select class="form-select" id="category_id" name="category_id">
                                            <option value="">Select Category</option>
                                            @php
                                                $search = \App\Models\Categories::select('categories.id', 'categories.name')
                                                ->where(['iStatus' => 1, 'isDelete' => 0])
                                                ->orderBy('categories.name', 'asc')
                                                ->get(); 
                                            @endphp
                                            @foreach ($search as $categori)
                                     
                                            <option value="{{ $categori->id }}" {{isset($category_id) && $categori->id == $category_id ? 'selected' : '' }}>
                                                {{ $categori->name }}
                                            </option>
                                            @endforeach
                                           </select>
                                            </div> -->
                                            <!-- new 22-10-2024 -->
                                            <div class="input-group mx-2 w-100">
                                                <select class="form-select select2" id="category_id" name="category_id" data-choices name="name">
                                                    <option value="">SelectCategory</option>
                                                    @php
                                                        $search = \App\Models\Categories::select('categories.id', 'categories.name')
                                                            ->where(['iStatus' => 1, 'isDelete' => 0])
                                                            ->orderBy('categories.name', 'asc')
                                                            ->get(); 
                                                    @endphp
                                                    @foreach ($search as $categori)
                                                        <option value="{{ $categori->id }}" {{ isset($category_id) && $categori->id == $category_id ? 'selected' : '' }}>
                                                            {{ $categori->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- new 22-10-2024 -->

                                           
                                            <div class="input-group w-10">
                                                <input type="submit" id="search" class="btn btn-success" name="search" title="Search" value="Search">
                                                <button type="button" id="cancel_search" style="margin-left: 7px " class="btn btn-success">Cancel</button>
                                            </div>
                                            </form>
                                        </div>
                       
                                  @endif  
                                                             
                                    <div class="d-flex align-items-center">
                                        <div class="dropdown ms-sm-3 header-item topbar-user">
                                            <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="d-flex align-items-center">
                                                @if(!is_null($session1) && $session1->role_id == 2)
                                                  <?php  
                                                     $session = auth()->user()->id;
                                                     $member = App\Models\members::select('id','profile_photo')->where('user_id',$session)->first();
                                                  ?>
                                                    @if(isset($member->profile_photo))  
                                                        <img class="rounded-circle header-profile-user"
                                                            src="{{ asset('profile_photo') . '/' . $member->profile_photo }}" alt="Header Avatar">
                                                        <span class="text-start ms-xl-2">
                                                    @else 
                                                        <img class="rounded-circle header-profile-user"
                                                            src="{{ asset('assets/images/users/undraw_profile.webp') }}" alt="Header Avatar">
                                                        <span class="text-start ms-xl-2">
                                                    @endif       
                                                @else                                             
                                                    <img class="rounded-circle header-profile-user"
                                                        src="{{ asset('assets/images/users/undraw_profile.webp') }}" alt="Header Avatar">
                                                    <span class="text-start ms-xl-2">
                                                @endif        
     
                                                        @if(auth()->check())
                                                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                                                {{ auth()->user()->full_name }}
                                                            </span>
                                                        @else
                                                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                                                Guest User
                                                            </span>
                                                        @endif
                                                         @if(auth()->check())
                                                        <?php
                                                        $session = auth()->user()->id;
                                                        
                                                        $role = App\Models\User::select('users.id','users.role_id', 'roles.name')
                                                        ->where('users.id', $session)
                                                        ->join('roles', 'users.role_id', '=', 'roles.id')
                                                        ->first();
                                                        ?>
                                                    
                                                        <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                                            {{ $role->name }}
                                                        </span>
                                                        @else
                                                         <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                                            Guest User
                                                        </span>
  @endif
                                                    </span>
                                                </span>
                                            </button>
                                    <!-- member profile_status -->
                                    @if(!is_null($session1) && $session1->role_id == 2)
                                                <?php 
                                                    $Member_detail = App\Models\members::select('id','user_id','profile_photo','Company_logo','profile_photo','facebook_link','instagram_link','linkedin_link','youtube_link','google_link')->where('user_id',$session)->first();
                                                
                                                    $defaultCount = 20;
                                                    // Increment the count based on the existence of properties
                                                    if ((isset($Member_detail->profile_photo) && $Member_detail->profile_photo != '') || 
                                                        (isset($Member_detail->Company_logo) && $Member_detail->Company_logo != '')) {
                                                        $defaultCount += 20;
                                                    }
                                                    if ((isset($Member_detail->facebook_link) && $Member_detail->facebook_link != '') || 
                                                        (isset($Member_detail->instagram_link) && $Member_detail->instagram_link != '')) {
                                                        $defaultCount += 20;
                                                    }
                                                    if ((isset($Member_detail->linkedin_link) && $Member_detail->linkedin_link != '') || 
                                                        (isset($Member_detail->youtube_link) && $Member_detail->youtube_link != '')) {
                                                        $defaultCount += 20;
                                                    }
                                                    if (isset($Member_detail->google_link) && $Member_detail->google_link != '') {
                                                        $defaultCount += 20;
                                                    }                                                 
                                                ?>
                                              <!-- Display the image based on the count -->
                                                @if($defaultCount == 20)
                                                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/profile_status.png') }}" alt="20%">
                                                @elseif($defaultCount == 40)
                                                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/Forty.png') }}" alt="40%">
                                                @elseif($defaultCount == 60)
                                                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/60.png') }}" alt="60%">
                                                @elseif($defaultCount == 80)
                                                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/80.png') }}" alt="80%">
                                                @elseif($defaultCount == 100)
                                                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/profile.jpg') }}" alt="100%">
                                                @endif

                                                <!-- <img class="rounded-circle header-profile-user"
                                                    src="{{ asset('assets/images/users/profile_status.png') }}" alt="Header Avatar"> -->
                                            @endif
                                            <span class="text-start ms-xl-2">
                                                @if(auth()->check())
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <h6 class="dropdown-header">Welcome {{ auth()->user()->full_name }}</h6>
                                                <a class="dropdown-item" href="{{ route('profile.detail') }}"><i
                                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                                        class="align-middle">Profile</span></a>
                                                        <!-- NEW ADD -->
                                                        @if($role->role_id == 2) 
                                                        <a class="dropdown-item" href="{{ route('Membersub.index') }}"><i
                                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                                        class="align-middle">My Subscription</span></a>
                                                        @endif
                                                        <!-- NEW ADD -->
                                                @if($role->role_id == 1 || $role->role_id == 3 ) 
                                                
                                                <a class="dropdown-item" href="{{ route('logout') }}"><i
                                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                                        class="align-middle" data-key="t-logout">Logout</span></a>
                                                @else  
                                                
                                                <a class="dropdown-item" href="{{ route('frontlogout') }}"><i
                                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                                        class="align-middle" data-key="t-logout">Logout</span></a>    
                                                @endif        
                                            </div>
                                            @else
                                              <h6 class="dropdown-header">Welcome,</h6>
                                               <a class="dropdown-item" href="{{ route('frontlogout') }}"><i
                                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                                        class="align-middle" data-key="t-logout">Logout</span></a>    
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>
                    <!-- This is destroy session in other page  -->
                      <?php 
                      $first_name1 = session()->forget('first_name1');
                      $categoryid = session()->forget('categoryid'); 
                      ?>
                                        
 @section('scripts')             
                      
<script>
    $(document).ready(function(){
        // Add click event listener to the cancel button
        $('#cancel_search').click(function(){
            // Reset the value of the category_id select element to empty
            $('#category_id').val('');
            // Submit the form to fetch all data
            $('#first_name').val('');
            
            $('#form').submit();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });
    });
</script>


@endsection                 
                      
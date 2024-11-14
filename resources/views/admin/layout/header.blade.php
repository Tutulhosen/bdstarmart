<nav
  class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
  id="layout-navbar">
  
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
    <a class="nav-item nav-link" href="javascript:void(0)" style="padding: 30px; display: block; padding-left:0px; padding-top:10px; padding-bottom:20px">
      <i class="bx bx-menu bx-md"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse" >
    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- User Dropdown -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            @if (Auth::user()->image)
            <img src="{{asset('admin/assets/img/profile/'. Auth::user()->image)}}" alt class="w-px-40 h-auto rounded-circle" />
            @else
            <img src="{{asset('admin/assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
            @endif
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <!-- Profile -->
          <li>
            <a class="dropdown-item" href="{{route('admin.profile.page')}}">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    @if (Auth::user()->image)
                    <img src="{{asset('admin/assets/img/profile/'. Auth::user()->image)}}" alt class="w-px-40 h-auto rounded-circle" />
                    @else
                    <img src="{{asset('admin/assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                    @endif
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-0">{{Auth::user()->name}}</h6>
                  <small class="text-muted">Admin</small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider my-1"></div>
          </li>
          <li>
            <a class="dropdown-item" href="{{route('admin.profile.page')}}">
              <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider my-1"></div>
          </li>
          <li>
            <a class="dropdown-item" href="{{route('admin.logout')}}">
              <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

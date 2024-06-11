<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('images/logo.png') }}" height="auto" width="200px" alt="">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2"></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->

        <li class="menu-item active">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        {{-- Merchant start--}}
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa fa-light fa-person-military-pointing menu-icon"></i>
                <div data-i18n="Account Settings">Merchant Panel</div>
            </a>
            <ul class="menu-sub">

                <!-- @if(Auth::guard('admin')->user()->can('view-pay-advertisement')) -->
                <li class="menu-item background">
                    <a href="{{route('merchant.advertisement')}}" class="menu-link background-menu-link">
                        <div data-i18n="Account">Pay Advertisement</div>

                    </a>
                </li>
                <!-- @else
                @endif -->

                @if(Auth::guard('admin')->user()->can('View-qrcode-list'))
                <li class="menu-item background">
                    <a href="{{route('showApprove')}}" class="menu-link background-menu-link">
                        <div data-i18n="Account">All QrCode List</div>
                    </a>
                </li>
                @endif



                @if(Auth::guard('admin')->user()->can('view-phy-ically-approve'))

                <li class="menu-item background">
                    <a href="{{route('showPhysicallyApprove')}}" class="menu-link background-menu-link">
                        <div data-i18n="Account">Physically Approve</div>
                    </a>
                </li>
                @endif



                @if(Auth::guard('admin')->user()->can('view merchant offer'))

                <li class="menu-item">
                    <a href="{{route('merchant.offer')}}" class="menu-link">
                        <div data-i18n="Account">Offer Create</div>
                    </a>
                </li>
                @endif

                @if(Auth::guard('admin')->user()->can('view online commi-ion merchant'))

                <li class="menu-item">
                    <a href="{{route('showMerchantCommissionStore')}}" class="menu-link">
                        <div data-i18n="Basic">Online Commission (Merchant)</div>
                    </a>
                </li>
                @endif

                @if(Auth::guard('admin')->user()->can('approve online commi-ion category'))

                <li class="menu-item">
                    <a href="{{route('showCommission')}}" class="menu-link">
                        <div data-i18n="Basic">Online Commission (Category)</div>
                    </a>
                </li>
                @endif

            </ul>
        </li>
        <!-- customer -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa fa-light fa-person-military-pointing menu-icon"></i>
                <div data-i18n="Account Settings">Manage Customer</div>
            </a>
            <ul class="menu-sub">
                @if(Auth::guard('admin')->user()->can('view-customer'))
                <li class="menu-item background">
                    <a href="{{route('customer')}}" class="menu-link background-menu-link">
                        <div data-i18n="Account">All Customer</div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        {{-- End Customer--}}
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Manage Offer</div>
            </a>


            <ul class="menu-sub">
                @if(Auth::guard('admin')->user()->can('view-category'))
                <li class="menu-item">
                    <a href="{{route('category')}}" class="menu-link">
                        <div data-i18n="Account">Category</div>
                    </a>
                </li>
                @endif
            </ul>
            <ul class="menu-sub">
                @if(Auth::guard('admin')->user()->can('view-category'))
                <li class="menu-item">
                    <a href="{{route('subCategory')}}" class="menu-link">
                        <div data-i18n="Account">Sub Category</div>
                    </a>
                </li>
                @endif
            </ul>
            {{-- <!-- <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{route('childCategory')}}" class="menu-link">
            <div data-i18n="Account">Child Category</div>
            </a>
        </li>
    </ul> --> --}}
    <ul class="menu-sub">
        @if(Auth::guard('admin')->user()->can('view-offer'))
        <li class="menu-item">
            <a href="{{route('offer')}}" class="menu-link">
                <div data-i18n="Account">Offer</div>
            </a>
        </li>
        @endif
    </ul>
    <ul class="menu-sub">
        @if(Auth::guard('admin')->user()->can('view approve offer'))
        <li class="menu-item">
            <a href="{{route('approve.offer')}}" class="menu-link">
                <div data-i18n="Account">Approve Offer</div>
            </a>
        </li>
        @endif
    </ul>
    </li>
    <!-- end Manage Offer-->
    @if(Auth::guard('admin')->user()->can('view-order'))
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="fa fa-cart-shopping menu-icon"></i>
            <div data-i18n="Account Settings">Manage Order</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{route('order')}}" class="menu-link">
                    <div data-i18n="Account">Order Details</div>
                </a>
            </li>
        </ul>
    </li>
    @else
    <li class="menu-item d-none">
    </li>
    @endif
    <!--end Manage Order-->
    <!--start Manage Inventory-->
    @if(Auth::guard('admin')->user()->can('view-inventory'))
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="fa fa-warehouse menu-icon"></i>
            <div data-i18n="Authentications">Manage Inventory </div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{route('inventory')}}" class="menu-link">
                    <div data-i18n="Basic">Inventory </div>
                </a>
            </li>
        </ul>
    </li>
    @else
    <li class="menu-item d-none">
    </li>
    @endif
    <!--end Manage Inventory-->
    <!--start Admin Panel-->

    @if(Auth::guard('admin')->user()->can('view admin panel'))
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="fa fa-circle-user menu-icon"></i>
            <div data-i18n="Authentications">Admin Panel </div>
        </a>
        <ul class="menu-sub">
            @if(Auth::guard('admin')->user()->can('view-merchant'))
            <li class="menu-item background">
                <a href="{{route('merchant')}}" class="menu-link background-menu-link">
                    <div data-i18n="Account">Merchant Create</div>
                </a>
            </li>
            @endif
        </ul>
        <ul class="menu-sub">
            @if(Auth::guard('admin')->user()->can('view-merchant-area'))
            <li class="menu-item background">
                <a href="{{route('merchant-area')}}" class="menu-link background-menu-link">
                    <div data-i18n="Account">Merchant Area</div>
                </a>
            </li>
            @endif
        </ul>
        <ul class="menu-sub">
            @if(Auth::guard('admin')->user()->can('view-admin'))
            <li class="menu-item">
                <a href="{{route('adminList')}}" class="menu-link">
                    <div data-i18n="Basic">Admin</div>
                </a>
            </li>
            @endif
        </ul>
        <ul class="menu-sub">
            @if(Auth::guard('admin')->user()->can('view-module'))
            <li class="menu-item">
                <a href="{{route('module')}}" class="menu-link">
                    <div data-i18n="Basic">Module </div>
                </a>
            </li>
            @endif
        </ul>
        <ul class="menu-sub">
            @if(Auth::guard('admin')->user()->can('view-sub-module'))
            <li class="menu-item">
                <a href="{{route('subModule')}}" class="menu-link">
                    <div data-i18n="Basic">Sub Module </div>
                </a>
            </li>
            @endif
        </ul>
        <ul class="menu-sub">
            @if(Auth::guard('admin')->user()->can('view-permission'))
            <li class="menu-item">
                <a href="{{route('permission')}}" class="menu-link">
                    <div data-i18n="Basic">Permission</div>
                </a>
            </li>
            @endif
        </ul>
        <ul class="menu-sub">
            @if(Auth::guard('admin')->user()->can('view-access-control'))
            <li class="menu-item">
                <a href="{{route('access-control')}}" class="menu-link">
                    <div data-i18n="Basic">Access Control</div>
                </a>
            </li>
            @endif
        </ul>
        
    <ul class="menu-sub">
        @if(Auth::guard('admin')->user()->can('view-payout'))
        <li class="menu-item">
            <a href="{{route('showPayoutDashboard')}}" class="menu-link">
                <div data-i18n="Basic">Approve Payout</div>
            </a>
        </li>
        @endif
    </ul>
    <ul class="menu-sub">
        <!-- @if(Auth::guard('admin')->user()->can('view-user-commission')) -->
        <li class="menu-item">
            <a href="{{route('show.list.commission')}}" class="menu-link">
                <div data-i18n="Basic">User's Commissions</div>
            </a>
        </li>
        <!-- @else
                    @endif -->
    </ul>

    <ul class="menu-sub">
        @if(Auth::guard('admin')->user()->can('view-role'))
        <li class="menu-item">
            <a href="{{route('role')}}" class="menu-link">
                <div data-i18n="Basic">Role </div>
            </a>
        </li>
        @endif
    </ul>

    <ul class="menu-sub">
        {{-- @if(Auth::guard('admin')->user()->can('view-role')) --}}
        {{-- <li class="menu-item">
                        <a href="{{route('pay.withdraw')}}" class="menu-link">
        <div data-i18n="Basic">Pay withdraw </div>
        </a>
        </li> --}}
        {{-- @endif --}}
    </ul>
    </li>
    @endif
    <!--end Admin Panel-->
    <!--start Currency Panel-->
    @if(Auth::guard('admin')->user()->can('view adverti-e apnel'))
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="fa fa-circle-user menu-icon"></i>
            <div data-i18n="Authentications">Advertise Panel </div>
        </a>
        <ul class="menu-sub">
            {{-- @if(Auth::guard('admin')->user()->can('view-approve_List')) --}}
            {{-- <li class="menu-item background">
                    <a href="{{route('pay.advertisement')}}" class="menu-link background-menu-link">
            <div data-i18n="Account">Pay Advertisement</div>
            </a>
    </li> --}}
    {{-- @else
                @endif --}}
    @if(Auth::guard('admin')->user()->can('view-slider'))
    <li class="menu-item">
        <a href="{{route('slider')}}" class="menu-link">
            <div data-i18n="Under Maintenance">Slider</div>
        </a>
    </li>
    @else
    @endif
    @if(Auth::guard('admin')->user()->can('view-banner'))
    <li class="menu-item">
        <a href="{{route('banner')}}" class="menu-link">
            <div data-i18n="Under Maintenance">Banner</div>
        </a>
    </li>
    @else
    @endif
    {{-- @if(Auth::guard('admin')->user()->can('view-approve_List')) --}}
    {{-- <li class="menu-item background">
                    <a href="{{route('showAdvertiseBanner')}}" class="menu-link background-menu-link">
    <div data-i18n="Account">Advertisement Banner</div>
    </a>
    </li> --}}

    {{-- @else
                         <ul class="menu-sub">
                {{-- @if(Auth::guard('admin')->user()->can('view-category')) --}}
    <li class="menu-item">
        <a href="{{route('rate.ogg.place')}}" class="menu-link">
            <div data-i18n="Account">Pay Advertisement</div>
        </a>
    </li>
    {{-- @else
            @endif --}}
    {{-- </ul> --}}
    {{-- @endif --}}
    {{-- @if(Auth::guard('admin')->user()->can('view-approve_List'))
                   <li class="menu-item background">
                    <a href="{{route('advertisement.list')}}" class="menu-link background-menu-link">
    <div data-i18n="Account">List</div>
    </a>
    </li>
    @else
    @endif --}}
    </ul>
    </li>
    @endif
    @if(Auth::guard('admin')->user()->can('view -ite configuration'))
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="fa-solid fa-gear menu-icon"></i>
            <div data-i18n="Misc">Site Configuration</div>
        </a>
        <ul class="menu-sub">
            @if(Auth::guard('admin')->user()->can('view-siteInfo'))
            <li class="menu-item">
                <a href="{{route('site.info')}}" class="menu-link">
                    <div data-i18n="Error">Site Info</div>
                </a>
            </li>
            @else
            @endif


            @if(Auth::guard('admin')->user()->can('view-banner'))
            <li class="menu-item">
                <a href="{{route('privacy_policy')}}" class="menu-link">
                    <div data-i18n="Under Maintenance">Privacy Policy</div>
                </a>
            </li>
            @else
            @endif
            @if(Auth::guard('admin')->user()->can('view-banner'))
            <li class="menu-item">
                <a href="{{route('terms_conditions')}}" class="menu-link">
                    <div data-i18n="Under Maintenance">Terms & Conditions</div>
                </a>
            </li>
            @else
            @endif

            @if(Auth::guard('admin')->user()->can('view-all-currencies'))
            <li class="menu-item">
                <a href="{{route('currency')}}" class="menu-link">
                    <div data-i18n="Basic">All Currencies</div>
                </a>
            </li>
            @else
            <li class="menu-item d-none"></li>
            @endif
            @if(Auth::guard('admin')->user()->can('view-all-currencies'))
            <li class="menu-item">
                <a href="{{route('showSocialLinks')}}" class="menu-link">
                    <div data-i18n="Basic">socialLinks</div>
                </a>
            </li>
            @else
            <li class="menu-item d-none"></li>
            @endif
            @if(Auth::guard('admin')->user()->can('view-all-currencies'))
            <li class="menu-item">
                <a href="{{route('about')}}" class="menu-link">
                    <div data-i18n="Basic">About</div>
                </a>
            </li>
            @else
            <li class="menu-item d-none"></li>
            @endif


            @if(Auth::guard('admin')->user()->can('view-all-currencies'))
            <li class="menu-item">
                <a href="{{route('footer.menu')}}" class="menu-link">
                    <div data-i18n="Basic">Footer Menu</div>
                </a>
            </li>
            @else
            <li class="menu-item d-none"></li>
            @endif
            @if(Auth::guard('admin')->user()->can('view-all-currencies'))
            <li class="menu-item">
                <a href="{{route('footer.details')}}" class="menu-link">
                    <div data-i18n="Basic">Footer Details</div>
                </a>
            </li>
            @else
            <li class="menu-item d-none"></li>
            @endif


        </ul>
    </li>
    @endif
    </ul>
</aside

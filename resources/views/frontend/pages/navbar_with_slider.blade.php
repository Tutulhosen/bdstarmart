<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" id="category-toggle" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <!-- Apply 'collapse' class for mobile and 'show' class for large screens -->
            <nav class="collapse navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    @foreach($categories as $category)
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">{{ $category->name }} <i class="fa fa-angle-down float-right mt-1"></i></a>
                            @php
                                $catSubcategories = $subcategories->where('category_id', $category->id);
                            @endphp
                            @if($catSubcategories->isNotEmpty())
                                <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                                    @foreach($catSubcategories as $subcategory)
                                        <a href="#" class="dropdown-item">{{ $subcategory->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </nav>
        </div>

        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="index.html" class="nav-item nav-link active">Home</a>
                        <a href="shop.html" class="nav-item nav-link">Shop</a>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0">
                        <a href="" class="nav-item nav-link">Login</a>
                        <a href="" class="nav-item nav-link">Register</a>
                    </div>
                </div>
            </nav>

            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @if (!empty($sliders))
                        @foreach ($sliders as $index => $item)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" style="height: 410px;">
                            <img class="img-fluid" src="{{asset('images/slider/' . $item->image_name)}}" alt="Image">
                        </div>
                        @endforeach
                    @else
                        <div class="carousel-item active" style="height: 410px;">
                            <img class="img-fluid" src="bdstarmart/img/carousel-2.jpg" alt="Image">
                        </div>
                    @endif
                </div>

                <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n2"></span>
                    </div>
                </a>

                <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n2"></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to check window width and toggle category collapse
    function toggleCategoryMenu() {
        const categoryNav = document.getElementById('navbar-vertical');
        const windowWidth = window.innerWidth;

        // If screen width is larger than or equal to 992px (desktop)
        if (windowWidth >= 992) {
            categoryNav.classList.add('show');  // Open category menu
        } else {
            categoryNav.classList.remove('show');  // Collapse category menu on mobile
        }
    }

    // Run on page load
    toggleCategoryMenu();

    // Run on window resize
    window.addEventListener('resize', toggleCategoryMenu);
</script>

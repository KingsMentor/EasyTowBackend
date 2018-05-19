<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EasyTow</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/images/logo.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/images/logo.png') }}">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ url('/admin/css/neat.min.css?v=1.0') }}">
    <link rel="stylesheet" href="{{ url('/admin/form.css') }}">

  </head>
<body>
<div class="o-page">
    <header class="c-navbar u-mb-large">
        <a class="c-navbar__brand" href="{{ url('/') }}">
            <img src="{{ url('/images/bdd.png') }}" style="height:50px;" alt="Neat" title="EasyTow">
        </a>

        <!-- Navigation items that will be collaped and toggled in small viewports -->
        <nav class="c-navbar__nav collapse" id="main-nav">
            <ul class="c-navbar__nav-list">
                <li class="c-navbar__nav-item">
                    <a class="c-navbar__nav-link" href="{{ url('/') }}">Home</a>
                </li>
                <li class="c-navbar__nav-item">
                    <a class="c-navbar__nav-link" href="{{ url('/home') }}">Dashboard</a>
                </li>
            </ul>
        </nav>
        <!-- // Navigation items  -->


            @guest

                @else
                 <!-- // Navigation items  -->

                <div class="c-dropdown dropdown u-mr-small u-ml-auto">


                </div>



                <div class="c-dropdown dropdown">
                    <div class="c-avatar c-avatar--xsmall dropdown-toggle" id="dropdownMenuAvatar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                        <img class="c-avatar__img"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" src="http://simpleicon.com/wp-content/uploads/lock-10.png" alt="Adam Sandler">
                    </div>

                    <div class="c-dropdown__menu has-arrow dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuAvatar">
                        <a class="c-dropdown__item dropdown-item" href="#">Edit Profile</a>
                        <a class="c-dropdown__item dropdown-item" href="#">View Activity</a>
                        <a class="c-dropdown__item dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

                    @endguest


        <button class="c-navbar__nav-toggle" type="button" data-toggle="collapse" data-target="#main-nav">
            <i class="feather icon-menu"></i>
        </button><!-- // .c-nav-toggle -->
    </header>

            @yield('content')
    <div class="row">
        <div class="col-12">
            <footer class="c-footer">
                <p>© {{ date('Y') }} EasyTow, Inc</p>
                <span class="c-footer__divider">|</span>
                <nav>
                    <a class="c-footer__link" href="#">Terms</a>
                    <a class="c-footer__link" href="#">Privacy</a>
                    <a class="c-footer__link" href="#">FAQ</a>
                    <a class="c-footer__link" href="#">Help</a>
                </nav>
            </footer>
        </div>
    </div>
</div>
<!-- // .o-page -->

<!-- Main JavaScript -->
<script src="{{ url('/js/jquery-3.2.1.min.js') }}"></script>


<script src="{{ url('admin/js/neat.js') }}"></script>
<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the crurrent tab

    function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // and set the current valid status to false
                valid = false;
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
    }
    function registration_type(){
        var val_form = $('#select_reg').val();

        if(val_form == "0"){
            $('#company').hide('slow');
            $('#individual').show('slow');
            $('#company_form').hide('slow');

        }else if(val_form > 1){
            $('#individual').hide('slow');
            $('#company').show('slow');
            $('#company_form').show('slow');
        }else{
            $('#company').hide('slow');
            $('#individual').hide('slow');
            $('#company_form').hide('slow');

        }
    }
</script>
</body>
</html>


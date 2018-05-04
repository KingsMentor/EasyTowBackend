<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EasyTow</title>
    <meta name="description" content="easytow">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/images/logo.png') }}">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ url('/admin/css/neat.css') }}">
</head>
<body>

<div class="o-page">
    <div class="o-page__sidebar js-page-sidebar">
        <aside class="c-sidebar">
            <div class="c-sidebar__brand">
                <a href="#"><img src="{{ url('images/bdd.png') }}"  alt="Neat"></a>
            </div>

            <!-- Scrollable -->
            <div class="c-sidebar__body">
                <span class="c-sidebar__title">Dashboards</span>
                <ul class="c-sidebar__list">
                    <li>
                        <a class="c-sidebar__link" href="{{ url('/home') }}">
                            <i class="c-sidebar__icon feather icon-home"></i>Dashboard
                        </a>
                    </li>
                    @if(auth()->user()->type == "1")
                    <li>
                        <a class="c-sidebar__link " href="{{ url('/truck') }}">
                            <i class="c-sidebar__icon feather icon-anchor"></i>Truck(s)
                        </a>
                    </li>
                    @else
                        <li>
                            <a class="c-sidebar__link " href="@if(auth()->user()->trucks->count() > 0)
                            {{ url('/truck/'.encrypt_decrypt('encrypt',auth()->user()->trucks[0]->id)) }}
                                    @else
                            {{ url('/add/truck') }}
                                    @endif
                                    ">
                                <i class="c-sidebar__icon feather icon-anchor"></i>My Truck
                            </a>
                        </li>
                        @endif
                    @if(auth()->user()->type == "1")
                        <li>
                            <a class="c-sidebar__link" href="{{ url('/driver') }}">
                                <i class="c-sidebar__icon feather icon-users"></i>Driver(s)
                            </a>
                        </li>
                    @else
                        <li>
                            <a class="c-sidebar__link " href="@if(auth()->user()->drivers->count() > 0)
                            {{ url('/driver/'.encrypt_decrypt('encrypt',auth()->user()->drivers[0]->id)) }}
                            @else
                            {{ url('/add/driver') }}
                            @endif
                                    ">
                                <i class="c-sidebar__icon feather icon-user"></i>My Driver
                            </a>
                        </li>
                    @endif


                    <li>
                        <a class="c-sidebar__link" href="{{ url('/account/settings') }}">
                            <i class="c-sidebar__icon feather icon-settings"></i>Account Settings
                        </a>
                    </li>

                </ul>


            </div>


            <a class="c-sidebar__footer" href="{{ url('/logout') }}">
                Logout <i class="c-sidebar__footer-icon feather icon-power"></i>
            </a>
        </aside>
    </div>
    <main class="o-page__content">
        <header class="c-navbar u-mb-medium">
            <button class="c-sidebar-toggle js-sidebar-toggle">
                <i class="feather icon-align-left"></i>
            </button>

            <h2 class="c-navbar__title">Account Type: @if(auth()->user()->type == "1")
                Company({{ auth()->user()->company_name }})
            @else
Individual
                @endif
            </h2>

            <div class="c-dropdown dropdown">
                <div class="c-avatar c-avatar--xsmall dropdown-toggle" id="dropdownMenuAvatar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                    <img class="c-avatar__img" src="http://via.placeholder.com/72" alt="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}">
                </div>

                <div class="c-dropdown__menu has-arrow dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuAvatar">
                    <a class="c-dropdown__item dropdown-item" href="{{ url('/account/settings') }}">Edit Profile</a>
                    <a class="c-dropdown__item dropdown-item" href="{{ url('/logout') }}">Log out</a>
                </div>
            </div>
        </header>
        <div class="container">
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
</div>

<div class="c-modal modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true" style="display: none;">
    <div class="c-modal__dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="c-card u-p-medium u-mh-auto" style="max-width:500px;">
                <h3>Add a Truck</h3>
                <p class="u-text-mute u-mb-small">We noticed you haven't created a truck, click the button below to do that</p>
                <a href="{{ url('add/truck') }}" class="c-btn c-btn--info" >
                    Add Truck
                </a>
            </div>
        </div>
    </div>
</div>
<script src="{{ url('admin/js/neat.js') }}"></script>
<script>

    @if(Request::path() != "add/truck")
            @if(auth()->user()->trucks()->count() == "0")
                $('#modal1').modal();
             @endif
    @endif
    registration_type();
    function registration_type(){
        var val_form = $('#select_reg').val();

        if(val_form == "0"){
            $('#company').hide('slow');
            $('#individual').show('slow');
            $('#company_form').hide('slow');

        }else if(val_form == "1"){
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

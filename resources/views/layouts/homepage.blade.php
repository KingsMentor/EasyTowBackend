
<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0" name="viewport">

    <!-- Open Graph -->
    <meta property="og:title" content="EasyTow" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ url('/images/logo.png') }}" />
    <meta property="og:description" content="Easy Tow is a GPS-based mobile application which helps people to find the
closest Tow Vehicle based on the user’s current position and vehicle to be towed" />

    <!-- Twitter Theme -->
    <meta name="twitter:widgets:theme" content="light">

    <!-- Title &amp; Favicon -->
    <title>EasyTow</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/images/logo.png') }}">

    <!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600%7CLato:300,400,700' rel='stylesheet' type='text/css'>


    <!-- Css -->
    <link rel="stylesheet" href="{{ url('/css/core.min.css') }}" />
    <link rel="stylesheet" href="{{ url('/css/skin.css') }}" />


    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<style>
    .bkg-grey-light{
        background: #c4ac18;color: #fff;
    }
    .bkg-grey-light h3{
        color: #fff;
    }
</style>
</head>
<body class="shop home-page">

<!-- Side Navigation Menu -->
<aside class="side-navigation-wrapper enter-right" data-no-scrollbar data-animation="slide-in">
    <div class="side-navigation-scroll-pane">
        <div class="side-navigation-inner">
            <div class="side-navigation-header">
                <div class="navigation-hide side-nav-hide">
                    <a href="#">
                        <span class="icon-cancel medium"></span>
                    </a>
                </div>
            </div>
            <nav class="side-navigation nav-block">
                <ul>
                    <li class="current">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="{{ url('/partner') }}">Partners</a>

                    </li>
                    <li>
                        <a href="{{ url('/driver') }}">Driver</a>
                    </li>
                    <li>
                        <a href="#">Industry Solutions</a>
                    </li>
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}">Contact Us</a>
                    </li>
                </ul>
            </nav>
            <div class="side-navigation-footer">
                <p class="copyright no-margin-bottom">&copy; {{ date("Y") }} EasyTow.</p>
            </div>
        </div>
    </div>
</aside>
<!-- Side Navigation Menu End -->

<div class="wrapper reveal-side-navigation">
    <div class="wrapper-inner">

        <!-- Header -->
        <header class="header header-absolute header-fixed-on-mobile header-transparent" data-bkg-threshold="100" data-sticky-threshold="40">
            <div class="header-inner-top">
                <div class="nav-bar">
                    <div class="row flex">
                        <div class="column width-8 nav-bar-inner v-align-middle left">
                            <div>
                                <p>Don't get stranded,
                                    Easytow just made it easy.</p>
                            </div>
                        </div>
                        <div class="column width-4 nav-bar-inner v-align-middle right">
                            <div>
                                <ul class="social-list list-horizontal">
                                    <li><a href="#"><span class="icon-facebook small"></span></a></li>
                                    <li><a href="#"><span class="icon-twitter small"></span></a></li>
                                    <li><a href="#"><span class="icon-instagram small"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-inner">

                <div class="row nav-bar">
                    <div class="column width-12 nav-bar-inner">
                        <div class="logo">
                            <div class="logo-inner">
                                <a href="{{ url('/') }}"><img src="/images/logo.png"  style="width: 80%; margin-top: -10px;"  alt=" Logo" /></a>
                                <a href="{{ url('/') }}"><img src="/images/logo.png" style="width: 80%;" alt=" Logo" /></a>
                            </div>
                        </div>
                        <nav class="navigation nav-block secondary-navigation nav-right">
                            <ul>

                                <li class="aux-navigation hide">
                                    <!-- Aux Navigation -->
                                    <a href="#" class="navigation-show side-nav-show nav-icon">
                                        <span class="icon-menu"></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                        <nav class="navigation nav-block primary-navigation nav-right">
                            <ul>
                                <li>
                                    <a href="{{ url('/') }}">Home</a>
                                </li>
                                <li>
                                    <a href="#">Services</a>
                                </li>
                                <li>
                                    <a href="{{ url('/partner') }}">Tow Partners</a>
                                </li>
                                <li>
                                    <a href="{{ url('/driver') }}">Driver</a>
                                </li>
                                <li>
                                    <a href="#">Industry Solutions</a>
                                </li>
                                <li >
                                    <a href="#">About</a>
                                </li>
                                <li>
                                    <a href="{{ url('/contact') }}">Contact Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->

        <!-- Content -->
        @yield('content')


        <!-- Content End -->

        <!-- Footer -->
        <footer class="footer footer-light with-border" style="background: #262f36; ">
            <div class="footer-top">
                <div class="row">
                    <div class="column width-6 push-6">
                        <div class="widget right left-on-mobile">
                            <div class="footer-logo">
                                <a href="{{ url('/') }}"><img src="/images/logo.png" alt="Faulkner Logo"></a>
                            </div>
                            <ul class="social-list list-horizontal">
                                <li><a href="#"><span class="icon-twitter small"></span></a></li>
                                <li><a href="#"><span class="icon-facebook small"></span></a></li>
                                <li><a href="#"><span class="icon-instagram small"></span></a></li>
                            </ul>
                            <p class="mb-0">© EasyTow. All Rights Reserved.</p>
                        </div>
                    </div>
                    <div class="column width-6 pull-6">
                        <div class="row flex two-columns-on-tablet">
                            <div class="column width-4">
                                <div class="widget">
                                    <h3 class="widget-title mb-30" style="color: #fff">HELP</h3>
                                    <ul id="menu-footer" class="footer-menu"><li id="menu-item-734" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-734"><a href="https://honk.zendesk.com/hc/en-us">Help</a>
                                                <li id="menu-item-736" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-736"><a href="{{ url('/terms') }}">Terms and conditions</a></li>
                                                <li id="menu-item-1422" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1422"><a href="#">Location services terms</a></li>
                                                <li id="menu-item-737" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-737"><a href="{{ url('/privacy') }}">Privacy policy</a></li>
                                                <li id="menu-item-7024" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7024"><a href="#">Code of conduct</a></li>
                                                <li id="menu-item-738" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-738"><a href="#">Contact</a></li>
                                            </ul>
                                </div>
                            </div>
                            <div class="column width-4">
                                <div class="widget">
                                    <h3 class="widget-title mb-30" style="color: #fff">COMPANY</h3>
                                    <ul>
                                        <li id="menu-item-740" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-740"><a href="#">About</a></li>
                                        <li id="menu-item-742" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-742"><a href="#">Careers</a></li>
                                        <li id="menu-item-1124" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1124"><a href="#">Partners</a></li>
                                        <li id="menu-item-7686" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7686"><a href="#">Industry Solutions</a></li>
                                        <li id="menu-item-7335" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7335"><a href="#">Press</a></li>
                                        <li id="menu-item-1256" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1256"><a href="#">Locations</a></li>

                                    </ul>
                                </div>
                            </div>
                            <div class="column width-4">
                                <div class="widget">
                                    <h3 class="widget-title mb-30" style="color: #fff">SERVICES</h3>
                                    <ul>
                                        <li id="menu-item-765" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-765"><a href="#">Towing</a></li>
                                        <li id="menu-item-750" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-750"><a href="#">Flatbed towing</a></li>
                                        <li id="menu-item-749" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-749"><a href="#">Exotic car towing</a></li>
                                        <li id="menu-item-764" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-764"><a href="#">Tire change</a></li>
                                        <li id="menu-item-756" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-756"><a href="#">Jump start</a></li>
                                        <li id="menu-item-757" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-757"><a href="#">Lock out</a></li>
                                        <li id="menu-item-763" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-763"><a href="#">Stuck in ditch</a></li>
                                        <li id="menu-item-762" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-762"><a href="#">Roadside assistance</a></li>
                                        <li id="menu-item-758" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-758"><a href="#">Out of fuel</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>


<script src="{{ url('/js/jquery-3.2.1.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3JCAhNj6tVAO_LSb8M-AzMlidiT-RPAs"></script>
<script src="{{ url('/js/timber.master.min.js') }}"></script>


</body>
</html>
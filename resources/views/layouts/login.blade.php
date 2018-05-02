<!DOCTYPE html>
<html lang="en">
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
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700%7CHind+Madurai:400,500&amp;subset=latin-ext" rel="stylesheet">

    <!-- Css -->
    <link rel="stylesheet" href="{{ url('/css/core.min.css') }}" />
    <link rel="stylesheet" href="{{ url('/css/skin.css') }}" />

    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body class="shop home-page">
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
                        <a href="#">Home</a>
                    </li>
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Faq</a>
                    </li>
                    <li>
                        <a href="#">Login</a>
                    </li>
                    <li>
                        <a href="#" class="contains-sub-menu">Sign up</a>
                    </li>
                </ul>
            </nav>
            <div class="side-navigation-footer">
                <p class="copyright no-margin-bottom">&copy; {{ date('Y') }} EasyTow.</p>
            </div>
        </div>
    </div>
</aside>
<!-- Side Navigation Menu End -->

<div class="wrapper">
    <div class="wrapper-inner">

        <header class="header header-relative header-fixed-on-mobile nav-dark" data-bkg-threshold="100" data-sticky-threshold="0">
            <div class="header-inner">
                <div class="row nav-bar">
                    <div class="column width-12 nav-bar-inner">
                        <div class="logo">
                            <div class="logo-inner">
                                <a href="{{ url('/') }}"><img src="{{ url('/images/bdd.png') }}" alt=" Logo" /></a>
                                <a href="{{ url('/') }}"><img src="{{ url('/images/bdd.png') }}" alt=" Logo" /></a>
                            </div>
                        </div>
                        <nav class="navigation nav-block secondary-navigation nav-right">
                            <ul>
                                <li>
                                    <!-- Button -->
                                    {{--<div class="v-align-middle">--}}
                                        {{--<a href="contact-style-two.html" class="weight-semi-bold color-green">Need Support?</a>--}}
                                    {{--</div>--}}
                                </li>
                                <li class="aux-navigation hide">
                                    <!-- Aux Navigation -->
                                    <a href="#" class="navigation-show side-nav-show nav-icon">
                                        <span class="icon-menu"></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->

        @yield('content')

        <footer class="footer footer-light with-border">
            <div class="footer-top">
                <div class="row">
                    <div class="column width-6 offset-3">
                        <div class="widget center left-on-mobile">
                            <div class="footer-logo">
                                <a href="{{ url('/') }}"><img src="{{ url('images/logo.png') }}" alt="Faulkner Logo" /></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="column width-6 offset-3">
                        <div class="widget center left-on-mobile">
                            <p class="mb-0">&copy; EasyTow. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->

    </div>
</div>
<script src="{{ url('/js/jquery-3.2.1.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3JCAhNj6tVAO_LSb8M-AzMlidiT-RPAs"></script>
<script src="{{ url('/js/timber.master.min.js') }}"></script>


</body>
</html>
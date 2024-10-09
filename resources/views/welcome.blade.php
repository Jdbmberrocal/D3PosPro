{{-- @extends('layouts.auth2')
@section('title', config('app.name', 'ultimatePOS'))
@inject('request', 'Illuminate\Http\Request')
@section('content')
<div class="col-md-12 col-sm-12 col-xs-12 right-col tw-pt-20 tw-pb-10 tw-px-5 tw-flex tw-flex-col tw-items-center tw-justify-center tw-bg-blue-500">
    <div class="tw-text-6xl tw-font-extrabold tw-text-center tw-text-white tw-shadow-lg tw-px-4 tw-py-2 tw-bg-blue-700 tw-rounded-md">
        {{ config('app.name', 'UltimatePOS') }}
    </div>
    
    <p class="tw-text-lg tw-font-medium tw-text-center tw-text-white tw-mt-2 tw-shadow-md tw-bg-blue-600 tw-rounded-md tw-px-3 tw-py-1">
        {{ env('APP_TITLE', '') }}
    </p>
</div>

@endsection
             --}}


<!doctype html>
<html lang="es" dir="ltr">

    <head>
        <meta charset="utf-8">
        <title>D3Pos - Software para ventas he inventario con facturación electrónica DIAN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Premium Bootstrap 5 Landing Page Template">
        <meta name="keywords" content="Saas, Software, multi-uses, HTML, Clean, Modern">
        <meta name="author" content="Jesus David Berrocal Mora">
        <meta name="email" content="jdbmberrocal@gmail.com">
        <meta name="website" content="https://jesusberrocal.site">
        <meta name="Version" content="v3.6">

        <!-- favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        
        <!-- Css -->
        <link href="{{asset('assets/libs/tiny-slider/tiny-slider.css')}}" rel="stylesheet">
        <link href="{{asset('assets/libs/tobii/css/tobii.min.css')}}" rel="stylesheet">
        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" class="theme-opt" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="{{asset('assets/libs/%40mdi/font/css/materialdesignicons.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/libs/%40iconscout/unicons/css/line.css')}}" type="text/css" rel="stylesheet">
        <!-- Style Css-->
        <link href="{{asset('assets/css/style.min.css')}}" id="color-opt" class="theme-opt" rel="stylesheet" type="text/css">
    </head>

    <body>
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div> 
        <!-- Loader -->
        
        @include('landing.include.header')
        
        
        <!-- Hero Start -->
        <section class="bg-half-170 d-table w-100 overflow-hidden" id="home">
            <div class="container">
                <div class="row align-items-center pt-5">
                    <div class="col-lg-7 col-md-6">
                        <div class="title-heading">
                            <h1 class="heading mb-3">Software administrativo <br> en la nube</h1>
                            <p class="para-desc text-muted">La solución administrativa para pequeñas y medianas empresas</p>
                            <div class="mt-4 pt-2">
                                <a href="https://1.envato.market/landrick" target="_blank" class="btn btn-primary">Registrate<span class="badge rounded-pill bg-danger ms-2"> ya!</span></a>
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-5 col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
                        <div class="classic-saas-image position-relative">
                            <div class="bg-saas-shape position-relative">
                                <img src="assets/images/laptop.png" class="mx-auto d-block" alt="">
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container--> 
        </section><!--end section-->
        <!-- Hero End -->

        <!-- Partners start -->
        <section class="pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-2 col-md-2 col-6 text-center">
                        <img src="assets/images/client/amazon.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->

                    <div class="col-lg-2 col-md-2 col-6 text-center">
                        <img src="assets/images/client/google.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->
                    
                    <div class="col-lg-2 col-md-2 col-6 text-center mt-4 mt-sm-0">
                        <img src="assets/images/client/lenovo.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->
                    
                    <div class="col-lg-2 col-md-2 col-6 text-center mt-4 mt-sm-0">
                        <img src="assets/images/client/paypal.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->
                    
                    <div class="col-lg-2 col-md-2 col-6 text-center mt-4 mt-sm-0">
                        <img src="assets/images/client/shopify.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->
                    
                    <div class="col-lg-2 col-md-2 col-6 text-center mt-4 mt-sm-0">
                        <img src="assets/images/client/spotify.svg" class="avatar avatar-ex-sm" alt="">
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Partners End -->

        <!-- Section Start -->
        <section class="section overflow-hidden">
            <div class="container pb-5 mb-md-5">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="features feature-primary text-center">
                            <div class="image position-relative d-inline-block">
                                <i class="uil uil-invoice h2 text-primary"></i>
                            </div>

                            <div class="content mt-4">
                                <h5>Facturación Electrónica</h5>
                                <p class="text-muted mb-0">Crea facturas personalizadas en 10 segundos y activa la facturación electrónica a un clic con toda la normativa exigida por la DIAN. </p>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-4 col-12 mt-5 mt-sm-0">
                        <div class="features feature-primary text-center">
                            <div class="image position-relative d-inline-block">
                                <i class="uil uil-money-withdrawal h2 text-primary"></i>
                            </div>

                            <div class="content mt-4">
                                <h5>Sistema POS</h5>
                                <p class="text-muted mb-0">¡Factura en tiempo récord de forma online cuando lo necesites. Abre y cierra caja en el día o en la noche. Mantén reportes de ventas diarias, cuadre de caja y comprobante diario exigido por la DIAN.</p>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-4 col-12 mt-5 mt-sm-0">
                        <div class="features feature-primary text-center">
                            <div class="image position-relative d-inline-block">
                                <i class="uil uil-pricetag-alt h2 text-primary"></i>
                            </div>

                            <div class="content mt-4">
                                <h5>Inventario</h5>
                                <p class="text-muted mb-0">Olvídate de los conteos manuales. Ahora tu inventario estará actualizado cada vez que compres o vendas mercancía.</p>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <div class="container pb-5 mb-md-5 mt-100 mt-60">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="saas-feature-shape-left position-relative">
                            <img src="assets/images/saas/classic02.png" class="img-fluid mx-auto d-block rounded shadow" alt="">
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-5 mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="section-title ms-lg-4">
                            <h1 class="title mb-3">Build your site for using this app</h1>
                            <p class="para-desc text-muted">Launch your campaign and benefit from our expertise on designing and managing conversion centered bootstrap v5 html page.</p>
                            
                            <div class="tiny-single-item">
                                <div class="tiny-slide">
                                    <div class="client-testi">
                                        <img src="assets/images/client/01.jpg" class="img-fluid avatar avatar-small rounded-circle shadow" alt="">
                                        <p class="text-muted mt-4">" It seems that only fragments of the original text remain in the Lorem Ipsum texts used today. "</p>
                                        <h6 class="text-primary">- Thomas Israel</h6>
                                    </div>
                                </div>
    
                                <div class="tiny-slide">
                                    <div class="client-testi">
                                        <img src="assets/images/client/02.jpg" class="img-fluid avatar avatar-small rounded-circle shadow" alt="">
                                        <p class="text-muted mt-4">" The most well-known dummy text is the 'Lorem Ipsum', which is said to have originated in the 16th century. "</p>
                                        <h6 class="text-primary">- Carl Oliver</h6>
                                    </div>
                                </div>
    
                                <div class="tiny-slide">
                                    <div class="client-testi">
                                        <img src="assets/images/client/03.jpg" class="img-fluid avatar avatar-small rounded-circle shadow" alt="">
                                        <p class="text-muted mt-4">" One disadvantage of Lorum Ipsum is that in Latin certain letters appear more frequently than others. "</p>
                                        <h6 class="text-primary">- Barbara McIntosh</h6>
                                    </div>
                                </div>
    
                                <div class="tiny-slide">
                                    <div class="client-testi">
                                        <img src="assets/images/client/04.jpg" class="img-fluid avatar avatar-small rounded-circle shadow" alt="">
                                        <p class="text-muted mt-4">" Thus, Lorem Ipsum has only limited suitability as a visual filler for German texts. "</p>
                                        <h6 class="text-primary">- Jill Webb</h6>
                                    </div>
                                </div>
    
                                <div class="tiny-slide">
                                    <div class="client-testi">
                                        <img src="assets/images/client/05.jpg" class="img-fluid avatar avatar-small rounded-circle shadow" alt="">
                                        <p class="text-muted mt-4">" There is now an abundance of readable dummy texts. These are usually used when a text is required. "</p>
                                        <h6 class="text-primary">- Dean Tolle</h6>
                                    </div>
                                </div>
    
                                <div class="tiny-slide">
                                    <div class="client-testi">
                                        <img src="assets/images/client/06.jpg" class="img-fluid avatar avatar-small rounded-circle shadow" alt="">
                                        <p class="text-muted mt-4">" According to most sources, Lorum Ipsum can be traced back to a text composed by Cicero. "</p>
                                        <h6 class="text-primary">- Christa Smith</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <div class="container mt-100 mt-60">
                <div class="row align-items-center">
                    <div class="col-lg-5 order-2 order-lg-1 mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="section-title me-lg-4">
                            <h1 class="title mb-3">Why Choose us ?</h1>
                            <p class="para-desc text-muted">Launch your campaign and benefit from our expertise on designing and managing conversion centered bootstrap v5 html page.</p>
                        
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center pt-4">
                                        <h2><i data-feather="shield" class="fea icon-m-md text-primary"></i></h2>
                                        <div class="ms-3">
                                            <h5>Fully Secured</h5>
                                            <p class="text-muted mb-0">Moreover, in Latin only words at the beginning of sentences are capitalized.</p>
                                        </div>
                                    </div>
                                </div><!--end col-->
    
                                <div class="col-12">
                                    <div class="d-flex align-items-center pt-4">
                                        <h2><i data-feather="cpu" class="fea icon-m-md text-primary"></i></h2>
                                        <div class="ms-3">
                                            <h5>Best Performance</h5>
                                            <p class="text-muted mb-0">If the fill text is intended to illustrate the characteristics of sometimes.</p>
                                        </div>
                                    </div>
                                </div><!--end col-->
    
                                <div class="col-12 pt-4">
                                    <a href="javascript:void(0)" class="btn btn-outline-primary">Install Now <i class="uil uil-angle-right-b"></i></a>
                                </div><!--end col-->
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-7 order-1 order-lg-2">
                        <div class="saas-feature-shape-right position-relative">
                            <img src="assets/images/saas/classic02.png" class="img-fluid mx-auto d-block rounded shadow" alt="">
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <div class="container pt-4 mt-100 mt-60">
                <div class="row justify-content-center" id="counter">
                    <div class="col-12 text-center">
                        <div class="section-title">
                            <h4 class="title mb-4">Overall <span class="text-primary"><span class="counter-value" data-target="333">1</span>k+</span> client are using, Get Started</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Build responsive, mobile-first projects on the web with the world's most popular front-end component library.</p>
                        
                            <div class="mt-4">
                                <a href="javascript:void(0)" class="btn btn-primary m-1">Get Started <i class="uil uil-angle-right-b"></i></a>
                                <a href="#!" data-type="youtube" data-id="yba7hPeTSjk" class="btn btn-icon btn-pills btn-primary m-1 lightbox"><i data-feather="video" class="icons"></i></a><span class="fw-bold text-uppercase small align-middle ms-1">Watch Now</span>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <div class="container mt-100 mt-60">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">Nuestros precios</h4>
                            <p class="text-muted para-desc mb-0 mx-auto">Start working with <span class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12 mt-4 pt-2">
                        <div class="card pricing pricing-primary business-rate shadow bg-light border-0 rounded">
                            <div class="card-body">
                                <h6 class="title name fw-bold text-uppercase mb-4">Gratis</h6>
                                <div class="d-flex mb-4">
                                    <span class="h4 mb-0 mt-2">$</span>
                                    <span class="price h1 mb-0">0</span>
                                    <span class="h4 align-self-end mb-1">/mes</span>
                                </div>
                                
                                <ul class="list-unstyled mb-0 ps-0">
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Acceso completo</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>1 empresa</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>1 usuario</li>
                                </ul>
                                <a href="javascript:void(0)" class="btn btn-primary mt-4">Adquirir</a>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-3 col-md-6 col-12 mt-4 pt-2">
                        <div class="card pricing pricing-primary business-rate shadow border-0 rounded">
                            <div class="ribbon ribbon-right ribbon-warning overflow-hidden"><span class="text-center d-block shadow small h6">Best</span></div>
                            <div class="card-body">
                                <h6 class="title name fw-bold text-uppercase mb-4">Starter</h6>
                                <div class="d-flex mb-4">
                                    <span class="h4 mb-0 mt-2">$</span>
                                    <span class="price h1 mb-0">39</span>
                                    <span class="h4 align-self-end mb-1">/mo</span>
                                </div>

                                <ul class="list-unstyled mb-0 ps-0">
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Full Access</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Source Files</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Free Appointments</li>
                                </ul>
                                <a href="javascript:void(0)" class="btn btn-primary mt-4">Get Started</a>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-3 col-md-6 col-12 mt-4 pt-2">
                        <div class="card pricing pricing-primary business-rate shadow bg-light border-0 rounded">
                            <div class="card-body">
                                <h6 class="title name fw-bold text-uppercase mb-4">Professional</h6>
                                <div class="d-flex mb-4">
                                    <span class="h4 mb-0 mt-2">$</span>
                                    <span class="price h1 mb-0">59</span>
                                    <span class="h4 align-self-end mb-1">/mo</span>
                                </div>
                                
                                <ul class="list-unstyled mb-0 ps-0">
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Full Access</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Source Files</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>1 Domain Free</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Enhanced Security</li>
                                </ul>
                                <a href="javascript:void(0)" class="btn btn-primary mt-4">Try It Now</a>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-3 col-md-6 col-12 mt-4 pt-2">
                        <div class="card pricing pricing-primary business-rate shadow bg-light border-0 rounded">
                            <div class="card-body">
                                <h6 class="title name fw-bold text-uppercase mb-4">Ultimate</h6>
                                <div class="d-flex mb-4">
                                    <span class="h4 mb-0 mt-2">$</span>
                                    <span class="price h1 mb-0">79</span>
                                    <span class="h4 align-self-end mb-1">/mo</span>
                                </div>
                                
                                <ul class="list-unstyled mb-0 ps-0">
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Full Access</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Enhanced Security</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Source Files</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>1 Domain Free</li>
                                    <li class="h6 text-muted mb-0"><span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>Free Installment</li>
                                </ul>
                                <a href="javascript:void(0)" class="btn btn-primary mt-4">Started Now</a>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <div class="container mt-100 mt-60">
                <div class="rounded bg-primary bg-gradient p-lg-5 p-4">
                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <div class="section-title text-md-start text-center">
                                <h4 class="title mb-3 text-white title-dark">Start your free 2 week trial today</h4>
                                <p class="text-white-50 mb-0">Start working with Landrick that can provide everything you need to generate awareness, drive traffic, connect.</p>
                            </div>
                        </div><!--end col-->
                        
                        <div class="col-md-4 mt-4 mt-sm-0">
                            <div class="text-md-end text-center">
                                <a href="javascript:void(0)" class="btn btn-light">Get Started</a>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
            </div><!--end container-->
        </section><!--end section-->
        <!-- Section End -->

        
        @include('landing.include.footer')

        
        <!-- Cookies Start -->
        <div class="card cookie-popup shadow rounded py-3 px-4">
            <p class="text-muted mb-0">This website uses cookies to provide you with a great user experience. By using it, you accept our <a href="https://shreethemes.in" target="_blank" class="text-success h6">use of cookies</a></p>
            <div class="cookie-popup-actions text-end">
                <button><i class="uil uil-times text-dark fs-4"></i></button>
            </div>
        </div>
        <!--Note: Cookies Js including in plugins.init.js (path like; js/plugins.init.js) and Cookies css including in _helper.scss (path like; scss/_helper.scss)-->
        <!-- Cookies End -->
        

        <!-- Offcanvas Start -->
        <div class="offcanvas offcanvas-end shadow border-0" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header p-4 border-bottom">
                <h5 id="offcanvasRightLabel" class="mb-0">
                    <img src="assets/images/logo-dark.png" height="24" class="light-version" alt="">
                    <img src="assets/images/logo-light.png" height="24" class="dark-version" alt="">
                </h5>
                <button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas" aria-label="Close"><i class="uil uil-times fs-4"></i></button>
            </div>
            <div class="offcanvas-body p-4">
                <div class="row">
                    <div class="col-12">
                        <img src="assets/images/contact.svg" class="img-fluid d-block mx-auto" alt="">
                        <div class="card border-0 mt-4" style="z-index: 1">
                            <div class="card-body p-0">
                                <h4 class="card-title text-center">Login</h4>  
                                <form class="login-form mt-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Your Email <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="user" class="fea icon-sm icons"></i>
                                                    <input type="email" class="form-control ps-5" placeholder="Email" name="email" required="">
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                                <div class="form-icon position-relative">
                                                    <i data-feather="key" class="fea icon-sm icons"></i>
                                                    <input type="password" class="form-control ps-5" placeholder="Password" required="">
                                                </div>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between">
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                                                    </div>
                                                </div>
                                                <p class="forgot-pass mb-0"><a href="auth-cover-re-password.html" class="text-dark fw-bold">Forgot password ?</a></p>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-lg-12 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary">Sign in</button>
                                            </div>
                                        </div><!--end col-->

                                        <div class="col-12 text-center">
                                            <p class="mb-0 mt-3"><small class="text-dark me-2">Don't have an account ?</small> <a href="auth-cover-signup.html" class="text-dark fw-bold">Sign Up</a></p>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas-footer p-4 border-top text-center">
                <ul class="list-unstyled social-icon social mb-0">
                    <li class="list-inline-item mb-0"><a href="https://1.envato.market/landrick" target="_blank" class="rounded"><i class="uil uil-shopping-cart align-middle" title="Buy Now"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://dribbble.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-dribbble align-middle" title="dribbble"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.behance.net/shreethemes" target="_blank" class="rounded"><i class="uil uil-behance align-middle" title="behance"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.facebook.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.instagram.com/shreethemes/" target="_blank" class="rounded"><i class="uil uil-instagram align-middle" title="instagram"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://x.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-twitter align-middle" title="twitter"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="mailto:support@shreethemes.in" class="rounded"><i class="uil uil-envelope align-middle" title="email"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://shreethemes.in" target="_blank" class="rounded"><i class="uil uil-globe align-middle" title="website"></i></a></li>
                </ul><!--end icon-->
            </div>
        </div>
        <!-- Offcanvas End -->
        <!-- Switcher Start -->
        <a href="javascript:void(0)" class="card switcher-btn shadow-md text-primary z-index-1 d-md-inline-flex d-none" data-bs-toggle="offcanvas" data-bs-target="#switcher-sidebar">
            <i class="mdi mdi-cog mdi-24px mdi-spin align-middle"></i>
        </a>

        <div class="offcanvas offcanvas-start shadow border-0" tabindex="-1" id="switcher-sidebar" aria-labelledby="offcanvasLeftLabel">
            <div class="offcanvas-header p-4 border-bottom">
                <h5 id="offcanvasLeftLabel" class="mb-0">
                    <img src="assets/images/logo-dark.png" height="24" class="light-version" alt="">
                    <img src="assets/images/logo-light.png" height="24" class="dark-version" alt="">
                </h5>
                <button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas" aria-label="Close"><i class="uil uil-times fs-4"></i></button>
            </div>
            <div class="offcanvas-body p-4 pb-0">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h6 class="fw-bold">Select your color</h6>
                            <ul class="pattern mb-0 mt-3">
                                <li>
                                    <a class="color-list rounded color1" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Primary" onclick="setColorPrimary()"></a>
                                </li>
                                <li>
                                    <a class="color-list rounded color2" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Green" onclick="setColor('green')"></a>
                                </li>
                                <li>
                                    <a class="color-list rounded color3" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Yellow" onclick="setColor('yellow')"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="text-center mt-4 pt-4 border-top">
                            <h6 class="fw-bold">Theme Options</h6>

                            <ul class="text-center style-switcher list-unstyled mt-4">
                                <li class="d-grid"><a href="javascript:void(0)" class="rtl-version t-rtl-light" onclick="setTheme('style-rtl')"><img src="assets/images/demos/rtl.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">RTL Version</span></a></li>
                                    <li class="d-grid"><a href="javascript:void(0)" class="ltr-version t-ltr-light" onclick="setTheme('style')"><img src="assets/images/demos/ltr.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">LTR Version</span></a></li>
                                    <li class="d-grid"><a href="javascript:void(0)" class="dark-rtl-version t-rtl-dark" onclick="setTheme('style-dark-rtl')"><img src="assets/images/demos/dark-rtl.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">RTL Version</span></a></li>
                                    <li class="d-grid"><a href="javascript:void(0)" class="dark-ltr-version t-ltr-dark" onclick="setTheme('style-dark')"><img src="assets/images/demos/dark.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">LTR Version</span></a></li>
                                    <li class="d-grid"><a href="javascript:void(0)" class="dark-version t-dark mt-4" onclick="setTheme('style-dark')"><img src="assets/images/demos/dark.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">Dark Version</span></a></li>
                                    <li class="d-grid"><a href="javascript:void(0)" class="light-version t-light mt-4" onclick="setTheme('style')"><img src="assets/images/demos/ltr.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">Light Version</span></a></li>
                                <li class="d-grid"><a href="https://shreethemes.in/landrick/dashboard/index.html" target="_blank" class="mt-4"><img src="assets/images/demos/admin.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">Admin Dashboard</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas-footer p-4 border-top text-center">
                <ul class="list-unstyled social-icon social mb-0">
                    <li class="list-inline-item mb-0"><a href="https://1.envato.market/landrick" target="_blank" class="rounded"><i class="uil uil-shopping-cart align-middle" title="Buy Now"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://dribbble.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-dribbble align-middle" title="dribbble"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.behance.net/shreethemes" target="_blank" class="rounded"><i class="uil uil-behance align-middle" title="behance"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.facebook.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://www.instagram.com/shreethemes/" target="_blank" class="rounded"><i class="uil uil-instagram align-middle" title="instagram"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://x.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-twitter align-middle" title="twitter"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="mailto:support@shreethemes.in" class="rounded"><i class="uil uil-envelope align-middle" title="email"></i></a></li>
                    <li class="list-inline-item mb-0"><a href="https://shreethemes.in" target="_blank" class="rounded"><i class="uil uil-globe align-middle" title="website"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- Switcher End -->

        <!-- Back to top -->
        <a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up" class="fea icon-sm icons align-middle"></i></a>
        <!-- Back to top -->

        <!-- javascript -->
        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- SLIDER -->
        <script src="{{asset('assets/libs/tiny-slider/min/tiny-slider.js')}}"></script>
        <!-- Lightbox -->
        <script src="{{asset('assets/libs/tobii/js/tobii.min.js')}}"></script>
        <!-- Main Js -->
        <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins.init.js')}}"></script><!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
        <script src="{{asset('assets/js/app.js')}}"></script><!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->
    </body>
</html>
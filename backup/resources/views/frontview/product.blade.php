
@extends('layouts.front')
@section('title', 'Home')
@section('content')

  <!-- This section classes require for whole page sliders -->
  <div id="sequence" style="display:none;">
    <ul class="seq-canvas">
    </ul>
</div>

<!-- End Slider -->

<!-- Main banner -->
<div class="inner-page-main-banner services">
    <!-- Bootstrap -->
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                <!-- H2 heading -->
                <h2>What we do</h2>
                <!-- H1 Heading -->
                <h1>Our Services</h1>
                <!-- Bredcum links -->
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        <ul>
                            <li> <a href="index.html">Home » </a> </li>
                            <li>Service 1</li>
                        </ul>
                        <p>
                           Lorem Ipsum is simply dummy text of the printing and typesetting indus orem Ipsum has been the industry's standard dummy.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End bootstrap -->
</div>
<!-- End Main banner -->

<!-- service box -->
<div id="service-image-box" class="service-section inner-page-white-section">

  <section class="section-gap">

      <!-- Bootstrap -->
      <div class="container">
        <div class="sec-title text-center">
            <!-- <span class="title">About Us</span> -->
            <h2 class="mb-5">Our Services </h2>
        </div>
        <div class="row">
           <div class="col-lg-4">
            <div class="site-box">
                            
                <!-- image -->
                <div class="service-image"> <img src="{{asset ('front/images/service1.jpg')}}" alt="image"> </div>

                <div class="content">
                    <!-- H4 heading -->
                    <h4><a href="#">Consultancy</a></h4>

                    <!-- Paragraph -->
                    <!-- <p>Lorem Ipsum is simply dummy of theti
                        ngand typeseing industry Lorem Ipsum
                        been industry Lorem Ipsum.</p> -->

                    <!-- Read more -->
                    <a class="site-permalink" href="#">
                        <span>MORE</span>
                        <i class="icon-service-arrow"></i>
                    </a>

                    <!-- Icon -->
                    <figure><i class="fa fa-briefcase"></i></figure>
                </div>
            </div>
           </div>

           <div class="col-lg-4">
            <div class="site-box">
                            
                <!-- image -->
                <div class="service-image"> <img src="{{ asset ('front/images/service1.jpg')}}" alt="image"> </div>

                <div class="content">
                    <!-- H4 heading -->
                    <h4><a href="#">Consultancy</a></h4>

                    <a class="site-permalink" href="#">
                        <span>MORE</span>
                        <i class="icon-service-arrow"></i>
                    </a>

                    <!-- Icon -->
                    <figure><i class="fa fa-briefcase"></i></figure>
                </div>
            </div>
           </div>

           <div class="col-lg-4">
            <div class="site-box">
                            
                <!-- image -->
                <div class="service-image"> <img src="{{asset ('front/images/service1.jpg')}}" alt="image"> </div>

                <div class="content">
                    <!-- H4 heading -->
                    <h4><a href="#">Consultancy</a></h4>

                    <a class="site-permalink" href="#">
                        <span>MORE</span>
                        <i class="icon-service-arrow"></i>
                    </a>

                    <!-- Icon -->
                    <figure><i class="fa fa-briefcase"></i></figure>
                </div>
            </div>
           </div>




           <div class="col-lg-4">
            <div class="site-box">
                            
                <!-- image -->
                <div class="service-image"> <img src="{{asset ('front/images/service1.jpg')}}" alt="image"> </div>

                <div class="content">
                    <!-- H4 heading -->
                    <h4><a href="#">Consultancy</a></h4>

                    <a class="site-permalink" href="#">
                        <span>MORE</span>
                        <i class="icon-service-arrow"></i>
                    </a>

                    <!-- Icon -->
                    <figure><i class="fa fa-briefcase"></i></figure>
                </div>
            </div>
           </div>



           <div class="col-lg-4">
            <div class="site-box">
                            
                <!-- image -->
                <div class="service-image"> <img src="{{asset ('front/images/service1.jpg')}}" alt="image"> </div>

                <div class="content">
                    <!-- H4 heading -->
                    <h4><a href="#">Consultancy</a></h4>

                    <a class="site-permalink" href="#">
                        <span>MORE</span>
                        <i class="icon-service-arrow"></i>
                    </a>

                    <!-- Icon -->
                    <figure><i class="fa fa-briefcase"></i></figure>
                </div>
            </div>
           </div>


           <div class="col-lg-4">
            <div class="site-box">
                            
                <!-- image -->
                <div class="service-image"> <img src="{{asset ('front/images/service1.jpg')}}" alt="image"> </div>

                <div class="content">
                    <!-- H4 heading -->
                    <h4><a href="#">Consultancy</a></h4>

                    <a class="site-permalink" href="#">
                        <span>MORE</span>
                        <i class="icon-service-arrow"></i>
                    </a>

                    <!-- Icon -->
                    <figure><i class="fa fa-briefcase"></i></figure>
                </div>
            </div>
           </div>
        </div>
    </div>
    <!-- End Bootstrap -->
  </section>

</div>
<!-- End service box -->


<!-- Site Contact -->
<div id="contact" class="site-contact site-white-section">

    <!-- Bootstrap -->
    <!-- Map and location container -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padding">
                <div class="left">
                    <!-- Contact information -->
                    <div class="site-contact-info bg-white">
                        
                        <!-- H1 heading -->
                        <h1>Have new project ?</h1>

                        <!-- H2 heading -->
                        <h2>Contact us</h2>
                            <!-- Box -->
                            <div class="site-box shadow-none">
                                <!-- Icon -->
                                <figure><i class="fa fa-map-marker"></i></figure>
                                <!-- Location -->
                                <h4> Visit our office @ </h4>
                                <a target="_blank" href="#">
                                   125 Business, Evenue, Huston, USA
                                </a>
                            </div>
                            <!-- End box -->
                            
                            <!-- Box -->
                            <div class="site-box shadow-none">
                                <!-- Icon -->
                                <figure><i class="fa fa-phone"></i></figure>
                                <!-- Number -->
                                <h4> Call us on </h4>
                                <a href="tel:19876543213">+1 987 654 3213</a>
                            </div>
                            <!-- End box -->
                            
                            <!-- Box -->
                            <div class="site-box odd shadow-none">
                                <!-- Icon -->
                                <figure><i class="fa fa-envelope"></i></figure>
                                <!-- Mail -->
                                <h4> Message us on </h4>
                                <a href="mailto:support@gmail.com">support@gmail.com</a>
                            </div>
                            <!-- End box -->
                            
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padding">
                <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52949733.91626272!2d-161.79055418360187!3d35.903029213681684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sin!4v1710327349065!5m2!1sen!2sin"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    

    <!-- End map and location container -->
    
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                

            </div>
        </div>
    </div>
    <!-- End bootstrap -->

</div>
<!-- End quick support -->


@endsection
@extends('layouts.front')
@section('opTag')
@section('title', $seo->metaTitle)

<meta name="description" content="{{ $seo->metaDescription }}" />
<meta name="keywords" content="{{ $seo->metaKeyword }}" />
{!! $seo->head !!}
{!! $seo->body !!}


@endsection

@section('content')
    <!-- This section classes require for whole page sliders -->
    <div id="sequence" style="display:none;">
        <ul class="seq-canvas">
        </ul>
    </div>

    <!-- End Slider -->
    
                 
    <!-- Main banner -->
    <div class="inner-page-main-banner contact-us">
		<!-- Bootstrap -->
		<div class="container">
            <div class="row">
                <div class="col-xs-12">
               
               
                    <!-- H2 heading -->
                    <h2>Contact us</h2>
                    <!-- H1 Heading -->
                    <h1 class="pb-70">Get in touch</h1>
                    <!-- Bredcum links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        	<ul>
                            	<li> <a href="{{route('FrontIndex')}}">Home » </a> </li>
                                <li>Contact us</li>
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
    
    <!-- Dont remove this section, it's classes is nececery for swiper slider used in other sections-->
    <div id="team" class="site-team site-white-section" style="display:none;">

        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
                
                <div class="col-xs-12 col-md-10 col-md-push-2">

                    <!-- Swiper slider -->
                    <div class="swiper-container team-section-slider" id="team-section-slider">

                        <!-- Content -->
                        <div class="swiper-wrapper">
                        </div>

                    </div>
                    <!-- End slider -->

                </div>
                <div class="col-xs-12 col-md-2 col-md-pull-10">

                    <!-- Thumbnail -->
                    <div class="swiper-container thumbnail" id="team-thumbnails">
                        <ul class="swiper-wrapper">
                           
                        </ul>
                    </div>
                    <!-- End thumbnail -->

                </div>
            </div>
        </div>
        <!-- End Bootstrap -->

    </div>
    <!-- End team -->

    <!-- contact box -->
    <div id="contact-us" class="contact-section inner-page-grey-section">

        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                	
                    <!-- Site box -->
					<div class="site-box">
                    	<!-- H3 Heading -->
	                    <h3>Ahmedabad Office</h3>
                        <!-- 3 colom -->
						<div class="inner">
                        
                        	<!-- adress -->
                        	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            	<div class="ttl">
	                            	<!-- Icon -->
    	                            <figure><i class="fa fa-map-marker"></i></figure>
        	                        <!-- Location -->
            	                    <h4> Location </h4>
								</div>
                                <a class="adress fs-18" target="_blank" href="#">
                                    307, Titanium One, Pakvan Cross Roads,SG Highway,Ahmedabad-380054
                                </a>
                            </div>
                            
                            <!-- phone -->
                        	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            	<div class="ttl">
                                    <!-- Icon -->
                                    <figure><i class="fa fa-phone"></i></figure>
                                    <!-- Location -->
                                    <h4> Call us </h4>
                                </div>
                                <div class="clearfix"> </div>
                                <a class="call"  href="tel:+919974897311">+91 99748 97311</a>
                                <div class="clearfix"> </div>
                               
                            </div>
                            
                            <!-- email -->
                        	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            	<div class="ttl mail">
	                            	<!-- Icon -->
    	                            <figure><i class="fa fa-envelope"></i></figure>
        	                        <!-- Location -->
            	                    <h4> Email us </h4>
								</div>
                                <div class="clearfix"> </div>
                                <a class="email" href="mailto:info@getdemo.in">info@getdemo.in</a>
                                <div class="clearfix"> </div>
                               
                            </div>
                            
                    	</div>
                        
                        <!-- Form -->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 no-right-padding">
		                    <div class="inner">
    	                		<div class="form-box">
                                <!-- H3 Heading -->
                                <h4>Drop a message to us</h4>
                                @include('common.alert')
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <li class="mb-5" style="color:red">{{ $error }}</li>
                                    @endforeach
                                @endif
                                <!-- Contact form -->
                                <form action="{{route('contact_us')}}" method="post" id="contactForm" class="site-contact-form">
                                @csrf  
                                <!-- Name -->
                                    <!--<div class="form-ttl">Name </div>-->
                                    <label><input type="text" name="contact_name" placeholder="Enter Your Name" required="required"></label>
                                    <!-- Email -->
                                    <!--<div class="form-ttl">Email </div>-->
                                    <label><input type="email" name="contact_email" placeholder="Enter Your Email" required="required"></label>
                                    <!-- Phone -->
                                    <!--<div class="form-ttl">Phone </div>-->
                                    <label><input type="text" name="contact_phone" placeholder="Enter Your Phone"  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onKeyPress="if(this.value.length==10) return false;" maxlength="10" minlength="10" required="required"></label>
                                    <!-- Message -->
                                    <!--<div class="form-ttl">Message </div>-->
                                    <label><textarea name="contact_message" placeholder="Enter Your Message" maxlength="170" required></textarea></label>
                                    <!-- capcha -->
                                    
                                    
                                    <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">

                                    <div class="form-group mt-4 mb-4">
                                        <div class="captcha">
                                            <span>{!! captcha_img() !!}</span>
                                            <button type="button" class="btn btn-success" class="reload" id="reload">
                                                &#x21bb;
                                            </button>
                                        </div>
                                    </div>
                                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                        name="captcha" required>
                                    @if ($errors->has('captcha'))
                                        <span class="help-block">
                                            <strong class="text-white">{{ $errors->first('captcha') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                    <button type="submit">Send request <i class="fa fa-spin fa-spinner"></i></button>
                                </form>
								</div>
        	            	</div>
						</div>
                        
                        <!-- Google map show using API -->
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 no-left-padding">
		                    <div class="inner maps">
		                    	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3126.6273666701513!2d72.50579397300338!3d23.037140633112987!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e9b48c144381d%3A0x9520ac5bb947ddfc!2sTitanium%20One%2C%20Bodakdev%2C%20Ahmedabad%2C%20Gujarat%20380054!5e1!3m2!1sen!2sin!4v1711619659655!5m2!1sen!2sin" width="100%" height="100vh" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
						</div>
                    </div>
                   
                  

                </div>
            </div>
        </div>
        <!-- End Bootstrap -->

    </div>
    <!-- End contact box -->


@endsection

@section('scripts')
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script type="text/javascript">
        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'refresh_captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
    

@endsection


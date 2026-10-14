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
    <div class="inner-page-main-banner about-us">
		<!-- Bootstrap -->
		<div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <!-- H2 heading -->
                    <h2>About us</h2>
                    <!-- H1 Heading -->
                    <h1>We are Evolv</h1>
                    <!-- Bredcum links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        	<ul>
                            	<li> <a href="{{route('FrontIndex')}}">Home » </a> </li>
                                <li>About us</li>
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

	<!-- Vision mission -->
    <div id="vision-mission" class="page-vision-mission site-white-section">

        <!-- Bootstrap -->
        <div class="container">
        	<!-- upper section -->
        	<div class="upper-section">
	            <div class="row">
                <div class="col-xs-12">

                    <!-- Clearfix -->
                    <div class="clearfix"></div>

                        <!-- Bootstrap nested columns -->
                        <div class="row align-items-center">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<div class="left-box">
	                                <!-- Figure -->
    	                            <figure>
        	                            <img src="{{ asset ('front/images/about-md.jpg')}}" alt="image">
            	                    </figure>
								</div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<div class="inner-column">
                                    <div class="sec-title sm-mt-15">
                                       <!-- <span class="title">About Us</span> -->
                                       <h2 class="text-start">Together, let's grow. </h2>
                                    </div>
                                    <div class="text-black mb-3 text-start">Welcome to "Evolv - An Oath to Grow", the premier networking platform for fostering meaningful connections and catalyzing professional growth. </div>
                                   <ul class="line text-start">
                                    <li>Meaningful number of meetings. </li>
                                    <li>Strong synergy amongst fellow members.</li>
                                    <li>Class apart business conference room.</li>
                                    <li>Reserved Business Category for you.</li>
                                    <li>Business Talk Show to take your ideology to the world.</li>
                                    <li>Selective membership with only to 49 members in a chapter</li>
                                   </ul>
                                 </div>

                            </div>
                        </div>

                </div>
            </div>
            </div>
        </div>
        <!-- End Bootstrap -->

    </div>
    <!-- End Site Features  -->
    
 
    
    <!-- Core Values Section -->
    <section class="section section-gap">
        <div class="container">
           <div class="sec-title text-center">
              <span class="title">
                 <h2>Core Values</h2>
              </span>
           </div>
           <div class="container">
              <div class="row">
                 <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="serviceBox blue">
                       <div class="service-content">
                          <div class="service-icon">
                             <img  src="{{ asset ('front/images/img/icons/balance.png')}}">
                          </div>
                          <h3 class="title">Equality</h3>
                       </div>
                    </div>
                 </div>
                 <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="serviceBox blue">
                       <div class="service-content">
                          <div class="service-icon">
                             <img  src="{{ asset ('front/images/img/icons/growth.png')}}">
                          </div>
                          <h3 class="title">Growth through Quality</h3>
                       </div>
                    </div>
                 </div>
                 <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="serviceBox blue">
                       <div class="service-content">
                          <div class="service-icon">
                             <img  src="{{ asset ('front/images/img/icons/sync-circular-arrows.png')}}">
                          </div>
                          <h3 class="title">Consistency</h3>
                       </div>
                    </div>
                 </div>
                 <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="serviceBox blue">
                       <div class="service-content">
                          <div class="service-icon">
                             <img  src="{{ asset ('front/images/img/icons/investigation.png')}}">
                          </div>
                          <h3 class="title">Transparency</h3>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
        
        </div>
     </section>
     <!-- End Core Values Section -->
    
    <!-- Two colom full width -->
    <div id="video" class="video-feature-section inner-page-dark-section">

        <!-- Bootstrap -->
        <div class="container-fluid">
            <div class="row">
            
            	<!-- Right colom -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-md-push-6">
					<div class="right-colom">
                        <!-- H1 Heading -->
                        <h1>Video presentation</h1>
    
                        <!-- H2 heading -->
                        <h2>Exclusivity in Evolv
                        </h2>
    					
                        <!-- advantage list -->
                        <div class="advantage">
							<ul>
                             
                                <li>
                                   
                                    <div class="advantage-icon"> <img src="{{ asset ('front/images/advantage-icon1.png')}}" alt="advantage1"> </div>
                                    
                                    <!-- content -->
                                    <div class="advantage-content"> <h4>Business Talk Show to take your ideology to the world.
                                    </h4>
                                    
                                   
                                    </div>
                                
                                </li>
                                
                                <!-- advantage list 2 -->
                                <li>
                                    <!-- icon -->
                                    <div class="advantage-icon"> <img src="{{ asset ('front/images/advantage-icon2.png')}}" alt="advantage1"> </div>
                                    
                                    <!-- content -->
                                    <div class="advantage-content"> <h4>Focus purely through cluster meets.
                                    </h4>
                                    
                                 
                                    </div>
                                
                                </li>
                                
                                <!-- advantage list 3 -->
                                <li>
                                    <!-- icon -->
                                    <div class="advantage-icon"> <img src="{{ asset ('front/images/advantage-icon3.png')}}" alt="advantage1"> </div>
                                    
                                    <!-- content -->
                                    <div class="advantage-content"> <h4>Only group to provide meetings in multiple time slots.
                                    </h4>
                                    
                                   
                                    </div>
                                
                                </li>

                                <li>
                                    <!-- icon -->
                                    <div class="advantage-icon"> <img src="{{ asset ('front/images/advantage-icon3.png')}}" alt="advantage1"> </div>
                                    
                                    <!-- content -->
                                    <div class="advantage-content"> <h4>Reserved Business Category for you.
                                    </h4>
                                    
                                   
                                    </div>
                                
                                </li>

                                                           <li>
                                    <!-- icon -->
                                    <div class="advantage-icon"> <img src="{{ asset ('front/images/advantage-icon3.png')}}" alt="advantage1"> </div>
                                    
                                    <!-- content -->
                                    <div class="advantage-content"> <h4>Selective membership with only to 49 members in a chapter.


                                    </h4>
                                    
                                   
                                    </div>
                                
                                </li>

                              
                                    
							</ul>
						
                        </div>
                    </div>
                </div>
                
            	<!-- left colom -->
            	<div class="col-xs-12 col-sm-12 col-md-6 col-md-pull-6 no-padding ">
                	
                	<!-- image -->
                    <div class="">
                    	<!-- <div class="video-box circle-ripple"> 
                            <a class="bla-1 " href="https://www.youtube.com/embed/EI0R7WE-NUY?si=p3pZFPTX2CEqn1O_"> <i class="fa fa-play video-play-btn "></i>  
                            </a>
                    		<a class="bla-1" href="#" style="display:none;">Vimeo video </a>
					    </div> -->

                        <figure class="image-1 mb-0"><iframe width="100%" height="800"
                                src="https://www.youtube.com/embed/EI0R7WE-NUY?si=p3pZFPTX2CEqn1O_"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </figure>

                    </div>
                </div>
                
            </div>
        </div>
        <!-- End Bootstrap -->

    </div>
    <!-- End Two colom full width  -->

    <div id="video" class="video-feature-section inner-page-dark-section">

     

    </div>
    

    
    <!-- Tabs -->
    <div id="why-us" class="site-tabs site-white-section">

        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
            	<!-- H1 Heading -->
                    

                    <!-- H2 heading -->
                    <h2>Our Group Ideology</h2>
                        
                <div class="col-xs-12">
                    <!-- Tabs wrapper -->
                    <div class="site-tabs-wrapper" id="site-tabs-1">

                       
                        <!-- Tabs content -->   <!-- Tab 1 -->
                        <div class="site-tabs-content" id="tab-1">
                        	<div class="col-xs-12 col-md-6">
                         
                                <ul class="pb-50">
                                    <li>Its all about Networking.</li>
                                    <li>To be the trusted business networking partner by providing a networking platform for a thriving group of entrepreneurs that can help them build meaningful business connections and boost their business growth.</li>
                                    
                                </ul>
                            </div>
                            
                            <div class="col-xs-12 col-md-6">
                            <div class="site-tab-bg tab-bg-1 active" style="background-image: url(front/images/img/bg-img/the-company-banner.jpg)"></div>
                            </div>
                            
                        </div>

                        <!-- Tab 2 -->
                        <div class="site-tabs-content" id="tab-2">
                        	<div class="col-xs-12 col-md-6">
                            <!-- Paragraph -->
                      
                            <!-- order List -->
                                <ul>
                                	<li>To provide curated business coffee meets to business owners to help them make meaningful connections.</li>
                                      <li>To provide them digital platform to present their business ideology to the world by the way of Business Talk Show.</li>
                                      <li>To grow with connections in cross city and progressively cross countries. </li>
                                      <li>To expand the horizon to Beyond Business Connections and also create a networking group with a specific agenda in the future plans.</li>
                                      <li>To grow the brand value via Business Talk Show and continuous evolution.</li>
                                      <li>To launch an app by understanding the gap between demand and supply and create a massive brand value. </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-md-6">
	                            <div class="site-tab-bg tab-bg-2" style="background-image: url(front/images/img/bg-img/the-company-banner.jpg)"></div>
                            </div>
                        </div>

                        <!-- Tab 3 -->
                        <div class="site-tabs-content" id="tab-3">
                        	<div class="col-xs-12 col-md-6">
                            <!-- Paragraph -->
                            <h3>Text of the printing and Lorem Ipsum is typesetting industry Lorem. </h3>
                            <p> Text of the printing and typesetting industry Lorem Ipsum has been the galley of type and scrambled it to make a type specimen book It has industrys standardindustrys standard dummy text ever since the when an unknown printer took. </p>
                            <!-- order List -->
                                <ul>
                                    <li>Lorem Ipsum is simply dummy text of the printing </li>
                                    <li>When an unknown printer took a galley of type </li>
                                    <li>And typesetting industry Lorem Ipsum has been the industrys</li>
                                    <li>Standard dummy text ever since the</li>
                                    <li>Lorem Ipsum is simply dummy text of the</li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-md-6">
	                            <div class="site-tab-bg tab-bg-3" style="background-image: url(front/images/tabs-bg-3.png)"></div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- End Tabs -->

                </div>
                
            </div>
        </div>
        <!-- End Bootstrap -->

    </div>
    <!-- End Tabs -->
    
    <div class="site-call-to-action">

        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <!-- Box -->
                    <div class="">

                        <!-- H1 heading -->
                        <h1>Like to boost your business?<br>
                            Get in touch with us now!!</h1>
                        <!-- Bootstrap inner columns -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-offset-2">
                            </div>
                            <div class="col-xs-12">
                                <!-- Button -->
                                <a href="register" class="theme-btn"> 
                                <!-- Icon -->
                               Register Now</a>
                            </div>
                        </div>

                    </div>
                    <!-- End box -->

                </div>
            </div>
        </div>
        <!-- End Bootstrap -->

    </div>


    
      <!-- Team -->
    <div id="team" class="site-team site-white-section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <div class="sec-title text-center">
                        <!-- <span class="title">About Us</span> -->
                        <h2 class="mb-5">Our Team </h2>
                    </div>

                </div>
                <div class="col-xs-12 col-md-10 col-md-push-2">

                    <!-- Swiper slider -->
                    <div class="swiper-container team-section-slider" id="team-section-slider">

                        <!-- Content -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            @foreach($Ourteem as $member) 
                            <div class="swiper-slide">

                                <!-- Bootstrap inner columns -->
                               
                                <div class="row">
                                    <div class="col-xs-12 col-sm-5">
                                        <!-- Image -->
                                        <figure><img src="{{ asset('overteem/' . $member->Overteem_photo) }}" alt="User"></figure>
                                    </div>
                                    <div class="col-xs-12 col-sm-7">
                                        <div class="team-description">
                                            <!-- Title -->
                                            <h4>{{$member->Overteem_name}}</h4>
                                            <!-- Description -->
                                            <h5>{{$member->designation}}</h5>
                                            <!-- Paragraph -->
                                            <p>{{$member->description}}</p>


                                            <!-- Progress -->
                                            <div class="site-team-progress">
                                                <span>Education - 98%</span>
                                                <label>
                                                    <span style="width: 98%"></span>
                                                </label>
                                            </div>
                                            <!-- Progress -->
                                            <div class="site-team-progress">
                                                <span>Experience - 75%</span>
                                                <label>
                                                    <span style="width: 75%"></span>
                                                </label>
                                            </div>
                                            <!-- Progress -->
                                            <div class="site-team-progress">
                                                <span>Intelligence - 98%</span>
                                                <label>
                                                    <span style="width: 98%"></span>
                                                </label>
                                            </div>

                                            <!-- Social icons -->
                                           
                                        </div>

                                    </div>
                                </div>
                              
                            </div>
                            @endforeach 
                        </div>

                    </div>
                    <!-- End slider -->

                </div>
                <div class="col-xs-12 col-md-2 col-md-pull-10">

                    <!-- Thumbnail -->
                    <div class="swiper-container thumbnail" id="team-thumbnails">
                        <ul class="swiper-wrapper">
                        @foreach($Ourteem as $member) 
                            <li class="swiper-slide" style="background-image:url('{{ asset('overteem/' .$member->Overteem_photo) }}')"></li>
                            @endforeach 
                        </ul>
                    </div>
                    <!-- End thumbnail -->

                </div>
                <div class="col-xs-12">
                    <!-- Navigation -->
                    <div class="team-section-arrow">
                        <div id="team-button-next" class="swiper-button-next"></div>
                        <div id="team-button-prev" class="swiper-button-prev"></div>
                    </div>
                    <!-- End navigation -->
                </div>

            </div>
        </div>


    </div>
    <!-- End team -->
    

    
    <!-- Tweets -->
    <div class="site-tweets">

        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1">

                    <!-- Icon -->
                    <i class="fa fa-twitter"></i>

                    <!-- Swiper container -->
                    <div class="swiper-container" id="tweet-slider">

                        <!-- Swiper wrapper -->
                        <ul class="swiper-wrapper tweet-carousel"></ul>

                    </div>

                    <!-- If we need pagination -->
                    <div id="tweet-pagination" class="swiper-pagination"></div>

                </div>
            </div>

            <!-- Navigation hide by default (if you want to show the navigation remove the (hide) class) -->
            <div id="tweet-button-next" class="swiper-button-next hide"></div>
            <div id="tweet-button-prev" class="swiper-button-prev hide"></div>
        </div>
        <!-- End bootstrap -->

    </div>
    <!-- End tweets -->


    <!-- Tweets -->
    <div class="site-tweets">

        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1">

                    <!-- Icon -->
                    <i class="fa fa-twitter"></i>

                    <!-- Swiper container -->
                    <div class="swiper-container" id="tweet-slider">

                        <!-- Swiper wrapper -->
                        <ul class="swiper-wrapper tweet-carousel"></ul>

                    </div>

                    <!-- If we need pagination -->
                    <div id="tweet-pagination" class="swiper-pagination"></div>

                </div>
            </div>

            <!-- Navigation hide by default (if you want to show the navigation remove the (hide) class) -->
            <div id="tweet-button-next" class="swiper-button-next hide"></div>
            <div id="tweet-button-prev" class="swiper-button-prev hide"></div>
        </div>
        <!-- End bootstrap -->

    </div>
    <!-- End tweets -->

    <!-- Site Contact -->
   <!-- Site Contact -->
 
  <!-- End quick support -->
    <!-- End quick support -->


    <!-- js code  -->

    <script type="text/javascript" src="js/YouTubePopUp.jquery.js"></script> 						<!-- Youtube Video Popup js -->
	<script type="text/javascript">
		jQuery(function(){
			jQuery("a.bla-1").YouTubePopUp();
			jQuery("a.bla-2").YouTubePopUp( { autoplay: 0 } ); // Disable autoplay
		});
	</script>
    
    <script>
	$(document).ready(function(){
		
	// Video popup ==============================================
	
	$(".various").fancybox({
        type: "iframe", //<--added
        maxWidth: 800,
        maxHeight: 600,
        fitToView: false,
        width: '70%',
        height: '70%',
        autoSize: false,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none'
    });
});

</script>

@endsection

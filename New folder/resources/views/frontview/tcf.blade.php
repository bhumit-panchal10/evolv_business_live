@extends('layouts.front')
@section('opTag')
@section('title', $seo->metaTitle)

<meta name="description" content="{{ $seo->metaDescription }}" />
<meta name="keywords" content="{{ $seo->metaKeyword }}" />
{!! $seo->head !!}
{!! $seo->body !!}
@endsection

@section('content')

<style>
    .gold-text{
        color:#ac8830!important;
    }
</style>

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
                    <h2>Evolv Presents</h2>
                    <!-- H1 Heading -->
                    <h1>The Cluster Fest 3.0</h1>
                    <!-- Bredcum links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        	<ul>
                            	<li> <a href="{{route('FrontIndex')}}">Home » </a> </li>
                                <li>The Cluster Fest 3.0</li>
                            </ul>
                           
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
        	<div class="upper-section mb-4"  style="border:1px solid #78c046">
	            <div class="row">
                <div class="col-xs-12">

                    <!-- Clearfix -->
                    <div class="clearfix"></div>

                        <!-- Bootstrap nested columns -->
                        <div class="row align-items-center">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 p-0">
								<div class="left-box p-5">
	                                <!-- Figure -->
    	                            <figure class="mb-0">
        	                            <img src="{{ asset ('front/images/tcf.jpeg')}}" alt="image">
            	                    </figure>
								</div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 h-100 p-0">
								<div class="inner-column p-5">
                                    <div class="sec-title sm-mt-15">
                                       <!-- <span class="title">About Us</span> -->
                                       <h2 class="text-start">Together, let's grow. </h2>
                                    </div>
                                    <div class="text-black mb-3 text-start">
                                        <p>
                                            Evolv has organised an open networking event for Business Enthusiasts of Ahmedabad , called The Cluster Fest. It is the 3rd edition.
 </p><p>
The event is to involve everyone in networking in the new way - The Cluster way. Yes , Evolv is well known for its Cluster Meet format.
 </p><p>
And we are taking it large to involve all business enthusiasts of the city to network in our style.
 </p>
 
 
                                        
                                    </div>
                                    <h5 class="text-black mt-3 text-start">
Scroll down to join the celebration.
                                        </h5>

                            </div>
                        </div>

                </div>
            </div>
            </div>
        </div>
        <!-- End Bootstrap -->

    </div>
    <!-- End Site Features  -->
    
    </div>
    <!-- Two colom full width -->
    <div id="video" class="video-feature-section inner-page-dark-section" style="background:#000; color:goldenrod">

        <!-- Bootstrap -->
        <div class="container-fluid">
            <div class="row">
            
            	<!-- Right colom -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-md-push-6">
					<div class="right-colom ">
                        <!-- H1 Heading -->
                        <h1></h1>
    
                        <!-- H2 heading -->
                        <h2 class="gold-text">Highlights of The Cluster Fest 3.0
                        </h2>
    					
                        <!-- advantage list -->
                        <div class="advantage">
							<ul>
                             
                                <li>
                                   
                                    <div class="advantage-icon"> <img src="{{ asset ('front/images/advantage-icon1.png')}}" alt="advantage1"> </div>
                                    
                                    <!-- content -->
                                    <div class="advantage-content"> <h4  class="gold-text">7 Hours of Networking
                                    </h4>
                                    
                                   
                                    </div>
                                
                                </li>
                                
                                <!-- advantage list 2 -->
                                <li>
                                    <!-- icon -->
                                    <div class="advantage-icon"> <img src="{{ asset ('front/images/advantage-icon5.png')}}" alt="advantage1"> </div>
                                    
                                    <!-- content -->
                                    <div class="advantage-content gold-text"> <h4 class="gold-text">75+ Participants.
                                    </h4>
                                    
                                 
                                    </div>
                                
                                </li>
                                
                                <!-- advantage list 3 -->
                                <li>
                                    <!-- icon -->
                                    <div class="advantage-icon"> <img src="{{ asset ('front/images/advantage-icon3.png')}}" alt="advantage1"> </div>
                                    
                                    <!-- content -->
                                    <div class="advantage-content gold-text"> <h4 class="gold-text">3 Cluster Meets.
                                    </h4>
                                    
                                   
                                    </div>
                                
                                </li>

                                <li>
                                    <!-- icon -->
                                    <div class="advantage-icon"> <img src="{{ asset ('front/images/advantage-icon4.png')}}" alt="advantage1"> </div>
                                    
                                    <!-- content -->
                                    <div class="advantage-content gold-text"> <h4 class="gold-text">Interaction with esteemed guests.
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
                                src="https://www.youtube.com/embed/YqCTzjeNfns?si=2yIUJRGPXtDZdpRb&rel=0&playsinline=1"
              
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

       <!-- Tabs -->
    <div id="why-us" class="site-tabs site-white-section">

        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
            	<!-- H1 Heading -->
                    

                    <!-- H2 heading -->
                    <!--<h2>5 Wh to Participate The Cluster Fest </h2>-->
                    <h2>The Cluster Fest – 3.0 ( 3rd Edition )</h2>
                        
                <div class="col-xs-12">
                    <!-- Tabs wrapper -->
                    <div class="site-tabs-wrapper" id="site-tabs-1">

                       
                        <!-- Tabs content -->   <!-- Tab 1 -->
                        <div class="site-tabs-content" id="tab-1">
                        	<div class="col-xs-12 col-md-8">
                        	    
                        	    <p class="mb-0">The Cluster Fest 3.0 is an open networking event curated for 75+ business enthusiast to grow their business connections via elite networking event.
 </p><p class="mb-2">
Saturday, 20th September 2025. 9 am to 4 pm.
 </p><p class="mb-2">
At Ahmedabad, Double Tree by Hilton
 </p>
 <p class="mb-2">
Evolv Network ideated a networking concept called <span class="text-black mt-3">The Cluster Meet</span>. This format hosts <span class="text-black mt-3">only 5 to 7 entrepreneurs</span> meeting with quality time and complete focus for business networking.  We got tremendous response from <span class="text-black mt-3">Premier Business Enthusiasts of Ahmedabad</span> and they <span class="text-black mt-3">joined as member</span> of Evolv community to network in Cluster Meet format.
 </p><p class="mb-2">
To endorse the same success, Evolv has organised <span class="text-black mt-3">the third edition</span> of The Cluster Fest , called <span class="text-black mt-3">TCF 3.0</span> and invites <span class="text-black mt-3">ONLY 80 focused</span> business entrepreneur to network in same way, the Cluster Way.</p>
                        	    
                         
                                <!--<ul class="pb-50">-->
                                <!--    <li>What – The Cluster Fest is an open networking event curated for 75+ business enthusiast to grow their business connections via elite networking event. </li>-->
                                <!--    <li>When – Saturday, 20th September 2025. 9 am to 4 pm. </li>-->
                                <!--    <li>Where - At Ahmedabad, Double Tree by Hilton</li>-->
                                <!--    <li>Why – Cluster meetings (Only fewer members meetings) is the essence of Evolv Network and Ahmedabad entrepreneurs welcomed this networking ideology. We got huge success and appreciation from our members.  </li>-->
                                <!--    <li>Who – Every business enthusiast that carry a vision with strong reason to connect with other business enthusiast and analyse the possible business benefits should join this. </li>-->
                                    
                                <!--</ul>-->
                            </div>
                            
                            <div class="col-xs-12 col-md-4">
                            <div class="site-tab-bg tab-bg-1 active" style="padding:0 50px">
                                <img src="front/images/Informal-Bond.jpg"/>
                            </div>
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
    
    <div class="site-call-to-action " style="background:#000">

        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <!-- Box -->
                    <div class="">

                        <!-- H1 heading -->
                        
                        <h2 class="gold-text mb-4"><b>Opportunities are like sunrises — if you wait too long, you miss them</b></h2>
                        <p class="gold-text mb-3">So if you are a business enthusiast that carry a vision and a reason to connect with other business enthusiast, <b>join us</b> .</p>
                        <p class="gold-text">
The EARLY BIRD OFFER (INR 1299 ) is only for first 40 seats. Actual price INR 2499.</p>
                        <!-- Bootstrap inner columns -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-offset-2">
                            </div>
                            <div class="col-xs-12 mt-5">
                                <!-- Button -->
                                <a href="Clusterfest" class="theme-btn" style="border:1px solid #fff; font-size:20px;"> 
                                <!-- Icon -->
                               Participate Now</a>
                            </div>
                        </div>

                    </div>
                    <!-- End box -->

                </div>
            </div>
        </div>
        <!-- End Bootstrap -->

    </div>


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

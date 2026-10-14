
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
    <div class="inner-page-main-banner services">
		<!-- Bootstrap -->
		<div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <!-- H2 heading -->
                  
                    <!-- H1 Heading -->
                    <h1>Our Services
                    </h1>
                    <!-- Bredcum links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        	<ul>
                            	<li> <a href="{{route('FrontIndex')}}">Home » </a> </li>
                                <li>Our Services
                                </li>
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


 
 
    <!-- Section Start  -->
    <section id="about" class="about-section mtmb-60">
        <div class="container">
           <div class="row align-items-center">
              <div class="image-column col-lg-6 col-md-12 col-sm-12">
                 <div class="inner-column wow fadeInLeft sm-mt-43">
                    <figure class="image-1"><a href="#" class="lightbox-image" data-fancybox="images"><img src="{{asset('front/images/img/bg-img/Exclusivity-in-Evolv.jpg')}}" alt="" class="img-fluid"></a></figure>
                 </div>
              </div>
              <div class="col-lg-6">
                 <div class="sm-mt-43">
                    <div class="sec-title">
                       <!-- <span class="title">About Us</span> -->
                       <h2>Exclusivity in Evolv</h2>
                    </div>
                    <ul class="line">
                       <li>Chapters comprising of 49 members each. </li>
                       <li>Monthly cluster format meetings.</li>
                       <li>Chapters of multiple time slots. </li>
                       <li>Annual membership plan.</li>                       
                       <li>No business category clash. </li>
                    </ul>
                 </div>
              </div>
           </div>
        </div>
     </section>

        <section class="section-gap2">
           <div class="container">
              <div class="row">
                 <div class="sec-title mb-0 text-center mb-5 cl-gap">
                    <!-- <span class="title">About Us</span> -->
                    <h2>Membership Includes</h2>
                 </div>

                 <div class="col-lg-6">
                    <div class="bx">
                    <div class="bx-img">
                       <img class="img-fluid" src="{{asset ('front/images/img/bg-img/Cluster-Meets.jpg')}}" alt="">
                    </div>
                    </div>
                 </div>

                 <div class="col-lg-6">
                    <div class="bx-content">
                       <div class="d-flex justify-content-between align-items-center">
                          <div class="head-txt">Cluster Meets</div>
                          <div class="bg-num">01</div>
                           </div>
                           <div class="bx-txt">
                            <ul class="line">
                               <li>A typical cluster meet will be conducted amongst 7 registered members </li>
                               <li>Each member will get 8 curated business cluster meets by which he/she can create 48 new business connections. </li>
                               <li>Monthly one cluster meet.</li>
                            </ul>
                           </div>
                     </div>
                 </div>

               

              </div>
           </div>
        </section>


        <section class="section-gap2">
           <div class="container">
              <div class="row flex-d-reverse">
                 <div class="col-lg-6">
                    <div class="bx-content">
                       <div class="d-flex justify-content-between align-items-center">
                          <div class="head-txt">Mega Meets</div>
                          <div class="bg-num">02</div>
                           </div>
                           <div class="bx-txt">
                            <ul class="line">
                               <li>Meet of all Chapter Members</li>
                               <li>1 Meeting in a tenure</li>
                               <li>Quick business introduction</li>
                               <li>Booked Business presentation</li>
                               <li>Focus on Making Right Impression</li>
                            </ul>
                           </div>
                     </div>
                 </div>


                 <div class="col-lg-6">
                    <div class="bx">
                    <div class="bx-img">
                       <img class="img-fluid" src="{{asset ('front/images/img/bg-img/Mega-Meets.jpg')}}" alt="">
                    </div>
                   
                    </div>
                 </div>



              </div>
           </div>
        </section>


        <section class="section-gap2">
           <div class="container">
              <div class="row">
                 <div class="col-lg-6">
                    <div class="bx">
                    <div class="bx-img">
                       <img class="img-fluid" src="{{asset ('front/images/img/bg-img/Pro-Panel.jpg')}}" alt="">
                    </div>
                    
                    </div>
                 </div>

                 <div class="col-lg-6">
                    <div class="bx-content">
                       <div class="d-flex justify-content-between align-items-center">
                          <div class="head-txt">Pro Panel</div>
                          <div class="bg-num">03</div>
                           </div>
                           <div class="bx-txt">
                            <ul class="line">
                             <li>All chapter members meet</li>
                             <li>1 Meeting in tenure</li>
                             <li>Selected Members as Panelist</li>
                             <li>Meeting with twist</li>
                             <li>Proper Networking time</li>
                            </ul>
                           </div>
                     </div>
                 </div>

               


              </div>
           </div>
        </section>


        <section class="section-gap2">
           <div class="container">
              <div class="row flex-d-reverse">
                 <div class="col-lg-6">
                    <div class="bx-content">
                       <div class="d-flex justify-content-between align-items-center">
                          <div class="head-txt">Informal Bond Meet</div>
                          <div class="bg-num">04</div>
                           </div>
                           <div class="bx-txt">
                            <ul class="line">
                               <li>A social with your entire chapter</li>
                               <li>1 meeting in the tenure</li>
                               <li>Fun activities</li>
                               <li>Informal way to interact</li>
                               <li>Focus on informal bonding</li>
                            </ul>
                           </div>
                     </div>
                 </div>

                 <div class="col-lg-6">
                    <div class="bx">
                    <div class="bx-img">
                       <img class="img-fluid" src="{{asset ('front/images/img/bg-img/Informal-Bond-Meet.jpg')}}" alt="">
                    </div>
                     
                    </div>
                 </div>

              </div>
           </div>
        </section>


        <section class="section-gap2">
           <div class="container">
              <div class="row">
                 <div class="col-lg-6">
                    <div class="bx">
                    <div class="bx-img">
                       <img class="img-fluid" src="{{asset ('front/images/img/bg-img/Pod-Talkshow.jpg')}}" alt="">
                    </div>
                    
                    </div>
                 </div>

                 <div class="col-lg-6">
                    <div class="bx-content">
                       <div class="d-flex justify-content-between align-items-center">
                          <div class="head-txt">Business Talk Show – Pod Talkshow</div>
                          <div class="bg-num">05</div>
                           </div>
                           <div class="bx-txt">
                            <ul class="line">
                               <li>Each community member to a Business talk show via Pod Talk show. This will help them to reach to a wider audience on social media. A professional team will do photo shoot and videography of thier workplace will be added in thier business talk show.</li>
                            </ul>
                           </div>
                     </div>
                 </div>
              </div>
           </div>
        </section>

    <!-- Section End  -->
 
@endsection

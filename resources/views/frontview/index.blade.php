@extends('layouts.front')
@section('opTag')
@section('title', $seo->metaTitle)

<meta name="description" content="{{ $seo->metaDescription }}" />
<meta name="keywords" content="{{ $seo->metaKeyword }}" />
{!! $seo->head !!}
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-W1BL0GS4ZH"></script> <script>   window.dataLayer = window.dataLayer || [];   function gtag(){dataLayer.push(arguments);}   gtag('js', new Date());   gtag('config', 'G-W1BL0GS4ZH'); </script>
{!! $seo->body !!}
@endsection

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.min.js"></script>


<style>


.counter {
  font-size: 60px;
    margin-top: 10px;
    text-align: center;
    color: white;
    font-weight: 600;
}

.counter-container {
  margin: 0 auto;
  text-align: center;
  color: white;
  position: relative;
  z-index: 2;
}

.counter i {
  font-size: 60px;
  color: white;
  position: relative;
  z-index: 2;
  font-weight: 600;
}

.fun-img {
  position: relative;
  background-image: url("../images/funimg.png");
  background-repeat: no-repeat;
  background-size: 100% 100%;
  width: 100%; / Adjust the width as needed /
  height: 100%; / Adjust the height as needed /
  overflow: hidden; / Ensure the pseudo-element doesn't overflow /
}

.fun-img::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5); / Black shadow with 50% opacity /
  z-index: 1; / Ensure the pseudo-element is above the background image /
}




    
    .p-date{
            /* text-align: center; */
    padding-top: 15px;
    padding-left: 22px;
    font-size: 17px;
    color:black;
    font-weight:600;

    }
    
/*    .content {*/
/*    padding: 20px;*/
/*    background: white;*/
/*}*/
.content {
    padding: 10px 20px;
    background: white;
    height: 85px;
}
/*.owl-carousel .owl-item img {*/
/*    display: block;*/
/*    width: 100%;*/
/*    height: 140px;*/
/*    object-fit: cover;*/
/*}*/
.owl-carousel .owl-item img {
    display: block;
    width: 100%;
    height: 225px;
    /* object-fit: cover; */
}
.content h4 {
     margin-top: 0px; 
}
.text-white.fs-30 {
  font-size: 30px;
}
.service-image {
    background: #fff;
    padding-top: 5px;
}

.owl-carousel .owl-stage {
  position: relative;
  -ms-touch-action: pan-Y;
  touch-action: manipulation;
  -moz-backface-visibility: hidden;
  margin: 0px 0px;
}
.site-box {
    box-shadow: 0px 10px 15px -3px rgba(0,0,0,0.1);
    /* box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px; */
    height: 100%;
}

</style>
    <!-- Link Swiper's CSS -->
       <!-- Main Slider -->
       <div class="site-main-slider slider-version-1">
        <!-- Sequence slider -->
        <div id="sequence">
    <ul class="seq-canvas">       
    @foreach($Image as $item)
    <li class="sequence-slide">
        <!-- Background Image -->
        <div class="sequence-bg" style="background-image:url('{{ asset('Adminfrontimage/' . $item->photo) }}')"></div>
        <!-- Caption -->
        <div class="sequence-caption">
            <!-- Bootstrap -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- H2 heading -->
                        <h2>Welcome to GrOath</h2>
                        <!-- H1 Heading -->
                        <h1 class="mb-4">{{ $item->Title }}</h1>
                        <!-- Paragraph -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                                <!-- You can add paragraph content here -->
                            </div>
                        </div>
                        <!-- Button -->
                        <a href="https://groath.in/{{ $item->button_link }}" class="theme-btn color-btn">Contact us</a>
                    </div>
                </div>
            </div>
            <!-- End bootstrap -->
        </div>
        <!-- End caption -->
    </li>
    @endforeach
</ul>
</div>      
        <!-- Pagination -->
        <ul class="seq-pagination">
            <li>Step 1</li>
            <li>Step 2</li>
            <li>Step 3</li>
        </ul>
        <!-- Navigation -->
        <button type="button" class="seq-prev"><span class="icon-slider-arrow-left"></span></button>
        <button type="button" class="seq-next"><span class="icon-slider-arrow-right"></span></button>
    </div>
    <!-- End Slider -->
    <section id="about" class="about-section mt-60">
        <div class="container">
            <div class="row align-items-center">
                <!-- Image Column -->
                <div class="image-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner-column wow fadeInLeft">
                        <figure class="image-1" style="border-radius: 12px"><iframe width="100%"  height="315" src="https://www.youtube.com/embed/EI0R7WE-NUY?si=p3pZFPTX2CEqn1O_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></figure>
                    </div>
                </div>
                <div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
                    <div class="inner-column sm-mt-43">

                        <div class="sec-title">
                            <span class="title">About Us</span>
                            <h2>Together, let's grow. </h2>
                        </div>
                        <div class="text">Welcome to "GrOath", the premier platform for fostering meaningful
                            connections and
                            catalyzing professional growth. At GrOath, we believe that success thrives in the
                            fertile ground of
                            collaboration, networking, and shared expertise. we're a community dedicated to
                            fostering genuine
                            relationships and facilitating meaningful exchanges.

                        </div>                       
                            <a  class="button" href=""{{ route('FrontAbout') }}">
                                <span class="button__icon-wrapper">
                                    <svg width="10" class="button__icon-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 15">
                                        <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                    </svg>
                                    
                                    <svg class="button__icon-svg  button__icon-svg--copy" xmlns="http://www.w3.org/2000/svg" width="10" fill="none" viewBox="0 0 14 15">
                                        <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                    </svg>
                                </span>
                                Explore us
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
 
    
    
          <!-- Tabs -->
        <div id="why-us" class="site-tabs site-white-section bg-main">

            <!-- Bootstrap -->
            <div class="container">
                <div class="row">


                    <!-- H2 heading -->
                    

                    <div class="col-lg-6">
                        <h2 class="text-white fs-30">Members Activity</h2>
                        <div class="owl-carousel owl-theme owl-carousel2 mt-0">
                             @foreach($active as $item) 
                            <div class="item">
                                <div class="site-box">

                                    <!-- image -->
                                    <div class="service-image"> <img loading="lazy" src="{{ asset('Activity/' . $item->photo) }}" alt="image"> </div>
                                    <div class="content">
                                        <!-- H4 heading -->
                                        <h4><a href="#">{!! substr(strip_tags($item->description), 0, 30)."..."; !!}</a></h4>
                                        <!-- Read more -->
                                        <!-- <a class="site-permalink d-flex justify-content-between text-black" href="#">
                                            <span>READ MORE</span>
                                            <i class="icon-service-arrow"></i>
                                        </a> -->
                                        <!-- Icon -->
                                    </div>
                                </div>
                            </div>
                            @endforeach


                        </div>
                    </div>
                    @foreach($videos as $vid)
                    <?php 
                                $ytarray=explode("/", $vid->vidoeurl);
                                $ytendstring=end($ytarray);
                                $ytendarray=explode("?v=", $ytendstring);
                                $ytendstring=end($ytendarray);
                                $ytendarray=explode("&", $ytendstring);
                                $ytcode=$ytendarray[0];
                            ?>
                    <div class="image-column col-lg-6 col-md-12 col-sm-12">
                         <h2 class="text-white fs-30">Our Latest PodTalk</h2>
                        <div class="inner-column wow fadeInLeft">                          
                            <figure class="image-1" style="border-radius: 12px"><iframe width="100%" height="315"
                                   src="https://www.youtube.com/embed/<?= $ytcode ?>"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                            </figure>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            <!-- End Bootstrap -->

        </div>
        <!-- End Tabs -->


    <section class="section-gap">
       <div class="container">
        <div class="sec-title text-center">
            <!-- <span class="title">About Us</span> -->
            <h2 class="mb-5">Explore Our Member's Business</h2>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-carousel owl-theme owl-carousel3">
         
                    @foreach($service as $item)
                        <div class="item">
                            <div class="site-box">
                                <div class="service-image">
                                    <a href="{{route('Search', $item->category_slug)}}">
                                        <img loading="lazy" src="{{ asset('category/' . $item->photo) }}" alt="image">
                                    </a>
                                </div>
                                <div class="content">                            
                                    <h4><a href="{{route('Search', $item->category_slug)}}">{!! substr(strip_tags($item->name), 0, 20)."..."; !!}</a></h4>
                                    <a class="site-permalink d-flex justify-content-between text-black" href="#">
                                        <span>READ MORE</span>
                                        <i class="icon-service-arrow"></i>
                                    </a>        
                                    <!-- Icon -->                                
                                </div>
                            </div>
                        </div>
                    @endforeach               
                </div>
            </div>
        </div>
       </div>
    </section>
    <section class="section-gap bg-sec">
        <div class="container">
            <div class="sec-title2 text-center">
                <!-- <span class="title">About Us</span> -->
                <h2 class="text-white">Membership Includes</h2>
            </div>
            <!-- <span>The trusted source for why choose us</span> -->
            <div class="row align-items-center">
                <div class="col-sm-6 col-lg-4 mb-2-9 mb-sm-0">
                    <div class="pr-md-3">
                        <div class="text-center text-sm-right mb-2-9">
                            <div class="mb-4 img-8">
                                <img class="img-fluid" src="{{ asset('front/images/img/4.jpg')}}" loading="lazy" alt="...">
                            </div>
                            <h4 class="sub-info">Cluster Meets</h4>                            
                        </div>
                        <div class="text-center text-sm-right">
                            <div class="mb-4 img-8">
                                <img class="img-fluid" src="{{asset ('front/images/img/bg-img/MEGA MEETS.jpg')}}" loading="lazy" alt="...">
                            </div>
                            <h4 class="sub-info">Mega Meets</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="why-choose-center-image">
                        <img class="img-fluid bg-white" src="{{asset ('front/images/img/PodTalk.png')}}" loading="lazy" alt="...">
                    </div>
                    <h4 class="sub-info text-center mt-4">Business Pod Cast</h4>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="pl-md-3">
                        <div class="text-center text-sm-left mb-2-9">
                            <div class="mb-4 img-8">
                                <img class="img-fluid" src="{{ asset('front/images/img/5.jpg')}}" loading="lazy" alt="...">
                            </div>
                            <h4 class="sub-info">Informal Meet</h4>
                        </div>
                        <div class="text-center text-sm-left">
                            <div class="mb-4 img-8">
                                <img class="img-fluid" src="{{ asset('front/images/img/6.jpg')}}" loading="lazy" alt="...">
                            </div>
                            <h4 class="sub-info">Community Group Access</h4>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team -->
    <!-- <div id="team" class="site-team site-white-section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <div class="sec-title text-center">
                      
                        <h2 class="mb-5">Our Team </h2>
                    </div>
                </div>
                <div class="col-xs-12 col-md-10 col-md-push-2">
                  
                    <div class="swiper-container team-section-slider" id="team-section-slider">
                       
                        <div class="swiper-wrapper">
                           
                            @foreach($Ourteem as $member) 
                            <div class="swiper-slide">
                                                           
                                <div class="row">
                                    <div class="col-xs-12 col-sm-5">
                                   
                                        <figure><img src="{{ asset('overteem/' . $member->Overteem_photo) }}" alt="User"></figure>
                                    </div>
                                    <div class="col-xs-12 col-sm-7">
                                        <div class="team-description">
                                        
                                            <h4>{{$member->Overteem_name}}</h4>
                                          
                                            <h5>{{$member->designation}}</h5>
                                            
                                            <p>{{$member->description}}</p>
                                           
                                            <div class="site-team-progress">
                                                <span>Education - 98%</span>
                                                <label>
                                                    <span style="width: 98%"></span>
                                                </label>
                                            </div>
                                       
                                            <div class="site-team-progress">
                                                <span>Experience - 75%</span>
                                                <label>
                                                    <span style="width: 75%"></span>
                                                </label>
                                            </div>
                                           
                                            <div class="site-team-progress">
                                                <span>Intelligence - 98%</span>
                                                <label>
                                                    <span style="width: 98%"></span>
                                                </label>
                                            </div>
                                                                                 
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                            @endforeach 
                        </div>
                    </div>
               
                </div>
                <div class="col-xs-12 col-md-2 col-md-pull-10">
                 
                    <div class="swiper-container thumbnail" id="team-thumbnails">
                        <ul class="swiper-wrapper">
                        @foreach($Ourteem as $member) 
                            <li class="swiper-slide" style="background-image:url('{{ asset('overteem/' .$member->Overteem_photo) }}')"></li>
                            @endforeach 
                        </ul>
                    </div>
                   

                </div>
                <div class="col-xs-12">
                   
                    <div class="team-section-arrow">
                        <div id="team-button-next" class="swiper-button-next"></div>
                        <div id="team-button-prev" class="swiper-button-prev"></div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div> -->
    <!-- End team -->
    <!-- counter display section start -->
    <section class="section-gap fun-img">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-3">
                        <div class="counter-container">
                            <!--<i class="fab fa-twitter fax-3x"></i>-->
                            <div class="counter">{{ $active_member_count }}</div>
                            <span>Total Active Member</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="counter-container">
                            <!--<i class="fab fa-youtube fax-3x"></i>-->
                            <div class="counter">{{ $group_count }}</div>
                            <span>Total Group</span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="counter-container">
                            <!--<i class="fab fa-facebook fax-3x"></i>-->
                             <div class="counter" id="business-counter">{{ $total_business_amount }}</div>
                            <span>Total Business</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- counter display section end -->
    <div class="site-call-to-action mb-5">
        <!-- Bootstrap -->
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Box -->
                    <div class="">
                        <!-- H1 heading -->
                        <h1>Interested to boost your business?<br>
                        Inquire with us!!</h1>
                        <!-- Bootstrap inner columns -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-offset-2">
                            </div>
                            <div class="col-xs-12">
                                <!-- Button -->
                                <a href="https://groath.in/news-detail/experience-meeting" class="theme-btn"> 
                                <!-- Icon -->  
                                Inquiry Now </a>
                            </div>
                        </div>
                    </div>
                    <!-- End box -->
                </div>
            </div>
        </div>
        <!-- End Bootstrap -->
    </div>
                <!-- Blog -->
                <div id="blog" class="site-blog site-grey-section">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2>Some of our latest Article And Events</h2>
                                <div class="row">
                                    <!-- 30-03-2024 event display code start-->
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <h1>Article</h1>
                                    <div class="site-box">
                                        <div class="blog-image"> 
                                            <img src="{{ asset('Blog/' . $Blog->blogImage) }}" alt="image"> <!-- Assuming 'blogImage' holds the path to the image -->
                                            <div class="date">{{ date('d', strtotime($Blog->blogDate)) }} <span class="month">{{ date('M', strtotime($Blog->blogDate)) }}</span></div>
                                        </div>
                                        <div class="content">
                                            <h3><a href="{{ route('Frontblog-detail', $Blog->blog_slug) }}">{{ $Blog->blogTitle }}</a></h3> 
                                           
                                             <p>{!! substr(strip_tags($Blog->blogDescription), 0, 150)."..."; !!}</p>
            
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    @foreach($Blogs as $blog)
                                    <div class="site-box-horizontle">
                                        <div class="content">
                                            <div class="date">{{ date('d', strtotime($blog->blogDate)) }} <span class="month">{{ date('M', strtotime($blog->blogDate)) }}</span></div>
                                            <h3><a href="#">{{ $blog->blogTitle }}</a></h3>
                                            <div class="authore-time"> By: Admin | {{ \Carbon\Carbon::parse($blog->blogDate)->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                  @endforeach       
                                </div> -->
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <h1>Events</h1>
                                    <div class="site-box">
                                        <div class="Event-image"> 
                                            <img class="w-100" src="{{ asset('event/' . $latestEvent->photo) }}" alt="image" style="height: 364px;"> 
                                            <!-- <div class="date">{{ date('d', strtotime($Blog->blogDate)) }} <span class="month">{{ date('M', strtotime($Blog->blogDate)) }}</span></div> -->
                                            <div class="p-date">  <i class="fa fa-calendar mx-2"></i>  Event Date: {{ \Carbon\Carbon::parse($latestEvent->eventstart_date)->format('F j, Y') }} To {{ \Carbon\Carbon::parse($latestEvent->eventend_date)->format('F j, Y') }}</div>
                                        </div>
                                        <div class="content" style="padding: 20px;">
                                            <h3><a href="{{ route('Frontnews-detail', $latestEvent->event_slug) }}">{{ $latestEvent->name }}</a></h3> 
                                            <p> {!! substr(strip_tags($latestEvent->description), 0, 150)."..."; !!} </p>     
                                                  
                                        </div>
                                    </div>
                                </div>
                    <!-- 30-03-2024 event display code End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog -->



        <script src="https://cdnjs.cloudflare.
    com/ajax/libs/OwlCarousel2/2.3.4/owl.carou
    sel.min.js" integrity="sha512-bPs7Ae6pVvhOSi
    IcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIUR
    q7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            $('.owl-carousel2').owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                autoplay: true,
                autoplayTimeout: 2000,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 2
                    }
                }
            });

            $('.owl-carousel3').owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                autoplay: true,
                autoplayTimeout: 2000,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            });
        });
    </script>
    
    <!-- <script>-->
    <!--    const counters = document.querySelectorAll(".counter");-->

    <!--    counters.forEach((counter) => {-->
    <!--        counter.innerText = "0";-->

    <!--        const updateCounter = () => {-->
    <!--            const target = +counter.getAttribute("data-target");-->
    <!--            const c = +counter.innerText;-->

    <!--            const increment = target / 2500;-->
    <!--            console.log(increment);-->

    <!--            if (c < target) {-->
    <!--                counter.innerText = `${Math.ceil(c + increment)}`;-->
    <!--                setTimeout(updateCounter, 1);-->
    <!--            } else {-->
    <!--                counter.innerText = target;-->
    <!--            }-->
    <!--        };-->

    <!--        updateCounter();-->
    <!--    });-->

    <!--</script>-->
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
            var counterElement = document.getElementById('business-counter');
            var totalCount = parseInt(counterElement.textContent);

            function updateCounter() {
                var currentCount = parseInt(counterElement.textContent);
                var increment = Math.ceil(totalCount / 100); // Adjust the speed of increment here

                if (currentCount < totalCount) {
                    counterElement.textContent = currentCount + increment;
                    setTimeout(updateCounter, 10); // Adjust interval for smoother animation
                } else {
                    counterElement.textContent = totalCount; // Ensure final count matches total
                }
            }

            updateCounter();
        });
</script>

    
   


@endsection

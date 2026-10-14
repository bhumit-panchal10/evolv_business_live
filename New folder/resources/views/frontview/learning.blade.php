
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
    .bx .bx-img img {
    background-color: rgb(255, 255, 255);
    
    /*width: 80%;*/
    max-height:500px;
    margin: 0px auto;
    border: 10px solid rgb(255, 255, 255);
    border-radius: 150px;
    background-image: linear-gradient(to right bottom, rgb(120, 192, 70), rgb(38, 169, 205));
    z-index: -1;
    box-shadow: rgba(0, 0, 0, 0.2) -2px 2px 10px inset, rgba(0, 0, 0, 0.35) -2px 2px 12px;
    display: flex;
     align-items: center; 
    justify-content: center;
    flex-direction: column;
    overflow:hidden;
    object-fit:cover
}

</style>
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
                    <h1>Learning & Development
                    </h1>
                    <!-- Bredcum links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        	<ul>
                            	<li> <a href="{{route('FrontIndex')}}">Home » </a> </li>
                                <li>Learning & Development
                                </li>
                            </ul>
                          
                        </div>
                    </div>
                </div>
            </div>
		</div>
        <!-- End bootstrap -->
    </div>
    <!-- End Main banner -->


 
 
    <!-- Section Start  -->
  

        <section class="section-gap2">
           <div class="container">
              <div class="row">
                          <div class="col-lg-6">
                    <div class="bx">
                    <div class="bx-img">
                       <img class="img-fluid" src="{{asset ('front/images/img/purvi.jpg')}}" alt="">
                    </div>
                    </div>
                 </div>

                 <div class="col-lg-6">
                    <div class="bx-content">
                       <div class="d-flex justify-content-between align-items-center">
                          <div class="head-txt">Purvi Shah</div>
                          <div class="bg-num">01</div>
                           </div>
                           <div class="bx-txt">
                           <p>
                               
                               In a world where many find themselves stuck in roles they didn’t choose, Purvi & Pritesh Shah chose a different path — one of purpose, empowerment, and bold reinvention.

Once confined by societal norms, they turned personal pain into passion — guiding others to live more consciously and courageously. With over two decades of combined experience in network marketing, coaching, and leadership development, they’ve empowered thousands across India — especially women and professionals seeking clarity, confidence, and direction.

Their journey, rooted in authenticity and service, includes building a 5000+ member team, designing breakthrough programs, and launching their brand “Purvi & Pritesh – Life Success Coach.” Their work goes beyond motivation — offering deep mentorship, actionable tools, and a supportive community to create lasting change.

Their flagship program, Rebirth 2.0, is more than a course — it’s a movement. A journey from confusion to clarity, from people-pleasing to personal power, and from self-doubt to self-worth.

Through immersive 2-day transformation workshops and 3-to-12-month implementation programs, they guide individuals to take charge of their time, energy, health, relationships, and finances — all in a structured yet soulful way.

From homemakers and teachers to doctors and entrepreneurs, their clients step in uncertain… but step out transformed.

If you’ve been waiting for a sign to rise, this is it.

It’s time to rewrite your story, reclaim your voice, and rise into the most powerful version of yourself.

Because your next level isn’t just a dream — it’s a decision.

                           </p>
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
                          <div class="head-txt">Priya Jain</div>
                          <div class="bg-num">02</div>
                           </div>
                           <div class="bx-txt">
                           <p>I’m Priya Jain, an Image Consultant with a deep passion for helping people show up as their most confident and impactful selves. Over the years, I’ve worked closely with entrepreneurs, professionals, and leaders to align their inner strengths with their outer presence. Whether it’s through refining communication, personal style, or overall executive image, my goal has always been to support individuals in building self-awareness and projecting authenticity with impact. I believe when people feel aligned and seen for who they truly are, they lead better — in life and in business.</p>
                           </div>
                     </div>
                 </div>


                 <div class="col-lg-6">
                    <div class="bx">
                    <div class="bx-img">
                       <img class="img-fluid" src="{{asset ('front/images/img/priya.png')}}" alt="">
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
                       <img class="img-fluid" src="{{asset ('front/images/img/shweta.jpg')}}" alt="">
                    </div>
                    
                    </div>
                 </div>

                 <div class="col-lg-6">
                    <div class="bx-content">
                       <div class="d-flex justify-content-between align-items-center">
                          <div class="head-txt">Shweta Jaiswal</div>
                          <div class="bg-num">03</div>
                           </div>
                           <div class="bx-txt">
                           <p>
                               I’m Shweta — a leadership coach, people strategist, and founder of Elixgrowth. With over 15 years of experience, I specialize in psychological assessments, leadership development, and building high-performing, human-centered cultures.

My journey has been shaped by a deep belief: that people are the true engine of growth in any organization. Whether it’s a fast-scaling startup or an established enterprise, I’ve seen that success always starts with empowered, aligned, and emotionally intelligent teams.

I’ve had the privilege of working across industries — designing and delivering leadership programs, outbound trainings, culture-building workshops, and interventions in communication, sales, and team dynamics.

What sets me apart is my ability to blend psychological insight with practical action. I don’t just develop leaders — I help shape ecosystems where people and business grow together. Through Elixgrowth, I’m committed to helping organizations create meaningful impact from the inside out.

Let’s build what matters — through people.
                           </p>
                           </div>
                     </div>
                 </div>

               


              </div>
           </div>
        </section>
    <!-- Section End  -->
 
@endsection

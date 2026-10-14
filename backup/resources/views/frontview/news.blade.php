
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
                    <h2>Events</h2>
                    <!-- H1 Heading -->
                    <h1>Events</h1>
                    <!-- Bredcum links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                            <ul>
                                <li> <a href="{{route('FrontIndex')}}">Home » </a> </li>
                                <li> <a href="{{route('Frontnews')}}">Events</a> </li>
                            </ul>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End bootstrap -->
    </div>
    <!-- End Main banner -->


    <section class="section-gap">
    <div class="container">
        <div class="row">
            @foreach($News as $newsItem)
            <div class="col-lg-4">
                <figure class="snip1208">
                    <img src="{{ asset('event/' . $newsItem->photo) }}" alt="news_photo"/>
                    <div class="date">
                        <span class="day">{{ \Carbon\Carbon::parse($newsItem->eventstart_date)->format('d') }}</span>
                        <span class="month">{{ \Carbon\Carbon::parse($newsItem->eventstart_date)->format('M') }}</span>
                    </div>
                    <i class="ion-film-marker"></i>
                    <figcaption>
                        <h3>{{ $newsItem->name }}</h3>
                        {{-- <p>{!! $newsItem->description !!}</p> --}}
                        <div class="button">
                                <span class="button__icon-wrapper">
                                    <svg width="10" class="button__icon-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 15">
                                        <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                    </svg>
                                    
                                    <svg class="button__icon-svg  button__icon-svg--copy" xmlns="http://www.w3.org/2000/svg" width="10" fill="none" viewBox="0 0 14 15">
                                        <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                    </svg>
                                </span>
                                Read More
                            </div>
                    </figcaption>
                    <a href="{{ route('Frontnews-detail', $newsItem->event_slug) }}"></a>
                </figure>
            </div>
            @endforeach
        </div>
    </div>
</section>




<!-- 

    <section class="section-gap">
        <div class="container">
            <div class="row">
                 <div class="col-lg-4">
                    <figure class="snip1208">
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/sample66.jpg" alt="sample66"/>
                        <div class="date"><span class="day">28</span><span class="month">Oct</span></div><i class="ion-film-marker"></i>
                        <figcaption>
                          <h3>The World Ended Yesterday</h3>
                          <p>
                            I don't need to compromise my principles, because they don't have the slightest bearing on what happens to me anyway.
                          </p>
                          <button>Read More</button>
                        </figcaption><a href="#"></a>
                      </figure>
                 </div>

                 <div class="col-lg-4">
                    <figure class="snip1208 hover">
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/sample9.jpg" alt="sample9"/>
                        <div class="date"><span class="day">17</span><span class="month">Nov</span></div><i class="ion-headphone"> </i>
                        <figcaption>
                          <h3>An Abstract Post Heading</h3>
                          <p>
                            Sometimes the surest sign that intelligent life exists elsewhere in the universe is that none of it has tried to contact us.
                          </p>
                          <button>Read More</button>
                        </figcaption><a href="#"></a>
                      </figure>
                 </div>

                 
                  <div class="col-lg-4">
                    <figure class="snip1208">
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/sample6.jpg" alt="sample6"/>
                        <div class="date"><span class="day">01</span><span class="month">Dec</span></div><i class="ion-checkmark"> </i>
                        <figcaption>
                          <h3>Down with this sort of thing</h3>
                          <p>
                            I don't need to compromise my principles, because they don't have the slightest bearing on what happens to me anyway.
                          </p>
                          <button>Read More</button>
                        </figcaption><a href="#"></a>
                      </figure>
                  </div>   
            </div>
        </div>
    </section> -->
</div>

@endsection
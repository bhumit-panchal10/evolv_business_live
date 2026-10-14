
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
                    <h2>Our Events</h2>
                    <!-- H1 Heading -->
                    <h1>{{ $Newsdetail->name }}</h1>
                    <!-- Bredcum links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                            <ul>
                                <li> <a href="{{route('FrontIndex')}}">Home » </a> </li>
                                <li> <a href="{{route('Frontnews')}}">Events</a> </li>
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

    
    <!-- Blog Detail Start  -->
    <div class="rs-inner-blog pt-120 pb-120 section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 md-mb-50">
                    <div class="blog-details">
                        <div class="bs-img mb-35">
                           <a href="#"><img src="{{ asset('event/' . $Newsdetail->photo) }}" alt=""></a>
                        </div>
                        <div class="blog-full">
                        <b><p>{{ $Newsdetail->name }}</p></b>
                            <ul class="single-post-meta">
                                <!-- <li><span class="p-date"><i class="fa fa-calendar">Event Date</i>{{ \Carbon\Carbon::parse($Newsdetail->eventstart_date)->format('F j, Y') }}</span></li>
                                </li>  -->
                                <li><span class="p-date"><i style="color:#78c046" class="fa fa-calendar"></i> Event Date: {{ \Carbon\Carbon::parse($Newsdetail->eventstart_date)->format('F j, Y') }} To {{ \Carbon\Carbon::parse($Newsdetail->eventend_date)->format('F j, Y') }}</span></li>

                               
                                <li class="Post-cate">
                                    {{-- <div class="tag-line">
                                        <i class="fa fa-book"></i>
                                        <a href="">Business</a>
                                    </div> --}}
                                    <!-- <li class="post-comment">
                                    <i class="fa fa-user" id="commentIcon"></i>{{$newscountcount}} Participents 
                                    </li> -->
                            </ul>
                            <p>
                            {!! $Newsdetail->description !!}
                            </p>
                            
                            @if($Newsdetail->ispaid == 'Yes')
                                <p>This event is paid.</p>
                                <p>Price: {{$Newsdetail->price}}</p>
                            @else
                                {{-- <p>This event is not paid.</p> --}}
                            @endif

                            @if($Newsdetail->limitedset == 'Yes')
                                {{-- <p>This event has limited seats.</p> --}}
                                <p>   Available seats: {{($Newsdetail->setnumber-$newscountcount)}} <i class="fa fa-chair" id="commentIcon"></i></p>
                            @else
                                {{-- <p>This event is not limitedset.</p> --}}
                            @endif
                            <h3 class="comment-title">Get an invite</h3>
                            <p>Your email address will not be published. Required fields are marked *</p>
                            <div class="comment-note bg-shadow1">
                                <form id="contact-form" method="post" action="{{route('newscomment')}}">
                                    @csrf 
                                @php
                                    $amount = 0;
                                    $ispaidFlag = 0;

                                    if (isset($Newsdetail->price) && $Newsdetail->ispaid == 'Yes') {
                                        $amount = $Newsdetail->price;
                                        $ispaidFlag = 1;
                                    }
                                @endphp
                                <input type="hidden" name="amount" value="{{ $amount }}">
                                <input type="hidden" name="ispaid" value="{{ $ispaidFlag }}">
                                    <input type="hidden" name="news_id" value="{{$news}}">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-lg-6 mb-35 col-md-6 col-sm-6">
                                                <input class="from-control" type="text" id="name" name="name" placeholder="Name*" required="">
                                            </div> 
                                            <div class="col-lg-6 mb-35 col-md-6 col-sm-6">
                                                <input class="from-control" type="text" id="email" name="email" placeholder="E-Mail*" required="">
                                            </div>
                                            <!-- new add fields start  -->
                                            <div class="col-lg-6 mb-35 col-md-6 col-sm-6">
                                                <input class="from-control" type="text" id="number" name="number" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onKeyPress="if(this.value.length==10) return false;" maxlength="10" minlength="10" placeholder="number*" required="">
                                            </div> 
                                            <div class="col-lg-6 mb-35 col-md-6 col-sm-6">
                                                <input class="from-control" type="text" id="companyname" name="companyname" placeholder="company Name*" required="">
                                            </div> 
                                            <div class="col-lg-6 mb-35 col-md-6 col-sm-6">
                                                <input class="from-control" type="text" id="businesscategory" name="businesscategory" placeholder="Business category*" required="">
                                            </div> 
                                            
                                             <!-- Referred By and Reference Name Fields -->
                                            <div class="col-lg-6 mb-35 col-md-6 col-sm-6">
                                                <select class="from-control" name="referred_by" id="referred_by" required>
                                                    <option value="">Referred by</option>
                                                    <option value="Evolv member">Evolv member</option>
                                                    <option value="Other resource">Other resource</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 mb-35 col-md-6 col-sm-6">
                                                <input class="from-control" type="text" placeholder="Reference name" id="reference_name" name="reference_name" maxlength="50" value="{{ old('reference_name') }}">
                                            </div>
                                            <!-- New Add Fields End -->
                                            
                                            
                                            <!-- new add fields End  -->
                                            <div class="col-lg-12 mb-30">
                                                <textarea class="from-control" id="message" name="message" placeholder="Your message Here" required=""></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 mt-4">
                                            <button type="submit" class="button">
                                                <span class="button__icon-wrapper">
                                                    <svg width="10" class="button__icon-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 15">
                                                        <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                                    </svg>
                                                                                    
                                                    <svg class="button__icon-svg  button__icon-svg--copy" xmlns="http://www.w3.org/2000/svg" width="10" fill="none" viewBox="0 0 14 15">
                                                        <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                                    </svg>
                                                </span>
                                                Submit
                                            </button>
                                        </div>
                                    </fieldset>
                                </form>
                                <div class="mt-15" id="form-messages"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 pl-25 md-pl-15">
                    <div class="widget-area">
                        <div class="recent-posts mb-50">
                            <div class="widget-title">
                                <h3 class="title">Recent Posts</h3>
                            </div>
                         
                            @foreach ($resentpost as $post)
                            <div class="recent-post-widget">
                                <div class="post-img">
                                    <a href=" {{ route('Frontnews-detail', $post->event_id) }}">
                                        <img src="{{ asset('event/' . $post->photo) }}" alt=""></a>
                                </div>
                                <div class="post-desc">
                                    <a href="">{{ $post->name }}</a>
                                    <span class="date-post"> <i class="fi fi-rr-calendar"></i>{{ \Carbon\Carbon::parse($post->eventstart_date)->format('F j, Y') }}</span>
                                </div>
                            </div>
                            @endforeach      
                            {{ $resentpost->links() }}
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    
  <script>
    document.getElementById('referred_by').addEventListener('change', function () {
        var referenceNameInput = document.getElementById('reference_name');
        var selectedValue = this.value;

        if (selectedValue === 'Evolv member') {
            referenceNameInput.placeholder = 'Enter Evolv member name';
        } else if (selectedValue === 'Other resource') {
            referenceNameInput.placeholder = 'Enter other resource name';
        } else {
            referenceNameInput.placeholder = 'Enter reference name';
        }
    });
</script>
    
  
@endsection


                 

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
        .popup {
            position: absolute;
            left: 50%;
        }

        button {
            outline: none;
            cursor: pointer;
            font-weight: 500;
            border-radius: 4px;
            border: 2px solid transparent;
            transition: background 0.1s linear, border-color 0.1s linear, color 0.1s linear;
        }

        .view-modal {
            color: #e8e4ee;
            font-size: 16px;
            padding: -10px 10px;
            background: none;
            cursor: pointer;
            margin: -13px 7px;
        }

        .popup {
            background: rgb(255, 254, 254);
            padding: 25px;
            border-radius: 15px;
            top: 10%;
            max-width: 380px;
            width: 100%;
            opacity: 0;
            pointer-events: none;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            transform: translate(-50%, -50%) scale(1.2);
            transition: top 0s 0.2s ease-in-out,
                opacity 0.2s 0s ease-in-out,
                transform 0.2s 0s ease-in-out;
        }

        .popup.show {
            top: 20%;
            left: 50%;
            opacity: 1;
            pointer-events: auto;
            transform: translate(-50%, -50%) scale(1);
            transition: top 0s 0s ease-in-out, opacity 0.2s 0s ease-in-out, transform 0.2s 0s ease-in-out;
            z-index: 10010;

        }

        .popup :is(header, .icons, .field) {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .popup header {

            padding-bottom: 15px;
            border-bottom: 1px solid var(--bs-gray-400);
        }



        header .close,
        .icons a {
            display: flex;
            align-items: center;
            border-radius: 50%;
            justify-content: center;
            transition: all 0.3s ease-in-out;
        }

        header .close {
            color: #ffffff;
            font-size: 17px;
            background: #77be54;
            height: 33px;
            width: 33px;

            cursor: pointer;
        }

        header .close:hover {
            background: #ebedf9;
        }

        .content {
            padding: 0px;
        }

        .popup .icons {
            margin: 15px 0 20px 0;
        }

        .content p {
            font-size: 16px;
        }

        .content .icons a {
            height: 50px;
            width: 50px;
            font-size: 20px;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .icons a i {
            transition: transform 0.3s ease-in-out;
        }

        .icons a:nth-child(1) {
            color: #1877F2 !important;
            border-color: #1877F2;
        }

        .icons a:nth-child(1):hover {
            background: #1877F2;
        }

        .icons a:nth-child(2) {
            color: #46C1F6 !important;
            border-color: #46C1F6;
        }

        .icons a:nth-child(2):hover {
            background: #46C1F6;
        }

        .icons a:nth-child(3) {
            color: #e1306c !important;
            border-color: #e1306c;
        }

        .icons a:nth-child(3):hover {
            background: #e1306c;
        }

        .icons a:nth-child(4) {
            color: #25D366 !important;
            border-color: #25D366;
        }

        .icons a:nth-child(4):hover {
            background: #25D366;
        }

        .icons a:nth-child(5) {
            color: red !important;
            border-color: rgba(255, 0, 0, 0.652);
        }

        .icons a:nth-child(5):hover {
            background: red;
        }

        .icons a:hover {
            color: #fff !important;
            border-color: transparent;
        }

        .icons a:hover i {
            transform: scale(1.2);
        }

        .content .field {
            margin: 12px 0 -5px 0;
            height: 45px;
            border-radius: 4px;
            padding: 0 5px;
            border: 1px solid #757171;
        }

        .field.active {
            border-color: #7d2ae8;
        }

        .field i {
            width: 50px;
            font-size: 18px;
            text-align: center;
        }

        .field.active i {
            color: #7d2ae8;
        }

        .field input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            font-size: 15px;
        }

        .field button {
            color: #fff;
            padding: 5px 18px;
            background: rgb(120, 192, 70);
        }

        .field button:hover {
            background: rgb(120, 192, 70);
        }


        .popup :is(header, .icons, .field) {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .icons {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
        }



        .popup .content {
            margin: 20px 0;
        }
        
        
        
        .share-ul li{
            list-style:none;
            
        }
        
        .share-ul{
            justify-content: start;
  display: flex;
  padding-left: 0px;
        }
        
        .mrl-10{
            margin:0px 10px;
        }
        
        
        .rs-inner-blog .blog-details .blog-full .single-post-meta {
  display: flex;
  align-items: center;
  padding: 0 0 8px;
  list-style: none;
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
                    <h2>Our Blogs</h2>
                    <!-- H1 Heading -->
                    <h1>{{ $slug_to_id->blogTitle }}</h1>
                    <!-- Bredcum links -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                            <ul>
                                <li> <a href="{{ route('FrontIndex') }}">Home » </a> </li>
                                <li> <a href="{{ route('Frontblog') }}">Blogs</a> </li>
                            </ul>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting indus orem Ipsum has been
                                the industry's standard dummy.
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
                            <a href="#"><img src="{{ asset('Blog/' . $Blogdetail->blogImage) }}" alt=""></a>
                        </div>
                        <div class="blog-full">
                            <ul class="single-post-meta">
                                <li><span class="p-date"><i style="color:#78c046" class="fa fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($Blogdetail->blogDate)->format('F j, Y') }}</span></li>
                                </li>
                                <li><span class="p-date"><i style="color:#78c046" class="fa fa-user"></i>
                                        {{ $user->first_name }} - {{ $Member->name ?? 'Groath' }}</span></li>
                               
                                
                                
                                
                              



                                <!-- <li class="post-comment"> <i class="fa fa-comment"></i></li> -->
                            </ul>
                            
                              <ul class="share-ul">
                                  <li>
                                    <span class="text-black d-flex align-items-center">
                                        <i style="color:#78c046" class="fa fa-link fa-share"></i> <p class="mb-0 mrl-10">Share</p>
                                            <div class="sharethis-inline-share-buttons"></div>
                                    </span>
                                    
                                </li>
                              </ul>
                            <p>
                                {!! $Blogdetail->blogDescription !!}
                            </p>

                            <h3 class="comment-title">Leave a Reply</h3>
                            <p>Your email address will not be published. Required fields are marked *</p>
                            <div class="comment-note bg-shadow1">
                                <form id="contact-form" method="post" action="{{ route('blogcomment') }}">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{ $blogid }}">
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-lg-6 mb-35 col-md-6 col-sm-6">
                                                <input class="from-control" type="text" id="name" name="name"
                                                    placeholder="Name*" required="">
                                            </div>
                                            <div class="col-lg-6 mb-35 col-md-6 col-sm-6">
                                                <input class="from-control" type="text" id="email" name="email"
                                                    placeholder="E-Mail*" required="">
                                            </div>
                                            <div class="col-lg-12 mb-30">
                                                <textarea class="from-control" id="message" name="message" placeholder="Your message Here" required=""></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 mt-4">
                                            <button type="submit" class="button">
                                                <span class="button__icon-wrapper">
                                                    <svg width="10" class="button__icon-svg"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 15">
                                                        <path fill="currentColor"
                                                            d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z">
                                                        </path>
                                                    </svg>

                                                    <svg class="button__icon-svg  button__icon-svg--copy"
                                                        xmlns="http://www.w3.org/2000/svg" width="10" fill="none"
                                                        viewBox="0 0 14 15">
                                                        <path fill="currentColor"
                                                            d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z">
                                                        </path>
                                                    </svg>
                                                </span>
                                                Explore All
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
                                        <a href=" {{ route('Frontblog-detail', $post->id) }}">
                                            <img src="{{ asset('Blog/' . $post->blogImage) }}" alt=""></a>
                                    </div>
                                    <div class="post-desc">
                                        <a href="">{{ $post->blogTitle }}</a>
                                        <span class="date-post"> <i
                                                class="fi fi-rr-calendar"></i>{{ \Carbon\Carbon::parse($post->blogDate)->format('F j, Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                            {{ $resentpost->links() }}
                        </div>
                        <!-- <div class="categories mb-50">
                                <div class="widget-title mb-15">
                                    <h3 class="title">Categories</h3>
                                </div>
                                <ul>
                                    <li><a href="#">Business Planning</a></li>
                                    <li><a href="#">Financial Advices</a></li>
                                    <li><a href="#">Business Analysis</a></li>
                                    <li><a href="#">Reports Analysis</a></li>
                                    <li><a href="#">Fintech Analysis</a></li>
                                    <li><a href="#">Project Reporting</a></li>
                                </ul>
                            </div> -->
                        {{-- <div class="tags-cloud">
                            <div class="widget-title pb-23">
                                <h3 class="title">Tags</h3>
                            </div>
                            <div class="tagcloud">
                                <a href="#">Audit</a>
                                <a href="#">Consulting</a>
                                <a href="#">Credit</a>
                                <a href="#">Repair</a>
                                <a href="#">Solve</a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Detail  End  -->
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const blogUrl = window.location.href;
            document.getElementById('blog-url').value = blogUrl;

            // Copy to clipboard functionality
            document.getElementById('copy-button').addEventListener('click', () => {
                const copyText = document.getElementById('blog-url');
                copyText.select();
                copyText.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand('copy');
                alert("Copied the URL: " + copyText.value);
            });

            // Social media sharing functionality
            document.querySelector('.share-facebook').href =
                `https://www.facebook.com/sharer/sharer.php?u=${blogUrl}`;
            document.querySelector('.share-twitter').href = `https://twitter.com/intent/tweet?url=${blogUrl}`;
            document.querySelector('.share-instagram').href = `https://www.instagram.com/?url=${blogUrl}`;
            document.querySelector('.share-whatsapp').href = `https://api.whatsapp.com/send?text=${blogUrl}`;
            document.querySelector('.share-youtube').href = `https://www.youtube.com/share?url=${blogUrl}`;

            // Modal toggle functionality
            document.querySelector('.view-modal').addEventListener('click', () => {
                document.querySelector('.popup').classList.toggle('show');
            });
            document.querySelector('.close').addEventListener('click', () => {
                document.querySelector('.popup').classList.remove('show');
            });
        });
    </script>


@endsection

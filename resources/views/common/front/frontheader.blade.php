

    <style>
        .openBtn {
            /* background: #f1f1f1; */
            border: none;
            padding: 10px 15px;
            font-size: 20px;
            cursor: pointer;
        }

        .openBtn:hover {
            background: #bbb;
        }

        .overlay {
            height: 100%;
            width: 100%;
            display: none;
            position: fixed;
            z-index: 9999999999;
            top: 0;
            left: 0;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }

        .overlay-content {
            position: relative;
            top: 46%;
            width: 80%;
            text-align: center;
            margin-top: 30px;
            margin: auto;
        }

        .overlay .closebtn {
            position: absolute;
            top: 20px;
            right: 45px;
            font-size: 60px;
            cursor: pointer;
            color: white;
        }

        .overlay .closebtn:hover {
            color: #ccc;
        }

        .overlay input[type=text] {
            padding: 15px;
            font-size: 17px;
            border: none;
            float: left;
            width: 80%;
            background: white;
        }

        .overlay input[type=text]:hover {
            background: #f1f1f1;
        }

        .overlay button {
            float: left;
            width: 10%;
            padding: 15px;
            background: linear-gradient(to right, #78c046, #26a9cd);
            font-size: 17px;
            border: none;
            cursor: pointer;
            color: white;
        }

        .overlay button:hover {
            background: #bbb;
        }


        .overlay .closebtn {
            position: absolute;
            top: 20px !important;
            right: 45px !important;
            font-size: 60px !important;
            cursor: pointer;
            color: white !important;
        }
        
        
         #scrollToTopBtn {
            display: none;
            position: fixed;
            bottom: 60px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: black;
            color: white;
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 4px;
        }


        .whatsapp-icon i {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 60px;
            left: 20px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 38px;
            z-index: 9999999;
        }
    </style>



<!-- Header -->
<header class="site-header" id="sticky-header">

    <!-- Bootstrap -->
    <div class="container">
        <div class="row">
            <div class="col-xs-12 ls">

                <!-- Logo -->
                <div class="site-logo">
                    <!-- Link -->
                    <a href="{{route('FrontIndex')}}">
                        <!-- Logo Image -->
                        <img width="150" src="{{ asset ('front/images/img/logo.png')}}" alt="Logo">
                    </a>
                </div>
                <!-- End logo -->

                <!-- Navigation Toggle Button -->
                 <b class="ser-main" onclick="openSearch()"><i class="fa fa-search"></i></b>
                <div class="site-nav-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                
                
                
                <!-- End Nav Toggle Button -->

                <!-- Navigation -->
                <nav class="site-nav">
                    <ul>
                      
                          
                    
                     <li class="nav-item @if (request()->routeIs('Frontfront-login')) {{ 'active' }} @endif">
                        <a class="nav-link menu-link bsc-none"
                            href="{{route('Frontfront-login')}}">
                            <span data-key="t-dashboards">Login</span>
                        </a>
                    </li> 
                    
                        <li class="tb-scr-none">
                            <a class="button" href="{{route('Frontfront-login')}}">
                                <span class="button__icon-wrapper">
                                    <svg width="10" class="button__icon-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 15">
                                        <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                    </svg>
                                    
                                    <svg class="button__icon-svg  button__icon-svg--copy" xmlns="http://www.w3.org/2000/svg" width="10" fill="none" viewBox="0 0 14 15">
                                        <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                    </svg>
                                </span>
                                Login
                            </a>
                        </li>
                           <li>
                                    <a class="button openBtn" onclick="openSearch()">
                                        <span class="button__icon-wrapper">
                                            <svg width="13" class="button__icon-svg" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M23.384 20.616l-5.85-5.85A9.493 9.493 0 0019 9.5C19 4.262 14.738 0 9.5 0S0 4.262 0 9.5 4.262 19 9.5 19c2.254 0 4.331-.737 5.966-1.966l5.85 5.85 1.768-1.768zM9.5 17C5.364 17 2 13.636 2 9.5S5.364 2 9.5 2 17 5.364 17 9.5 13.636 17 9.5 17z">
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
                                        Search
                                    </a>
                                </li>
                    </ul>
                </nav>
                <!-- End Navigation -->
            </div>
        </div>
    </div>
    <!-- End Bootstrap -->

</header>


  <button id="scrollToTopBtn" title="Go to top"><i class="fa fa-chevron-up" aria-hidden="true"></i>

    </button>

    <!--<a target="_blank" class="whatsapp-icon text-center" href="https://api.whatsapp.com/send/?phone=9974897311">
        <i class="fa fa-whatsapp" aria-hidden="true"></i>
    </a>
-->
   <?php $Adminfirst_name =session()->get('Adminfirst_name'); 
   
   ?>

   <div id="myOverlay" class="overlay">
        <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
        <div class="overlay-content">
            <form action="{{route('Search')}}" method="post">
            @csrf
                <input type="text" placeholder="Search.." name="first_name" value="<?= isset($Adminfirst_name) ? $Adminfirst_name : '' ?>">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>

    <script>
        function openSearch() {
            document.getElementById("myOverlay").style.display = "block";
        }

        function closeSearch() {
            document.getElementById("myOverlay").style.display = "none";
        }
    </script>
    
    
      <script>
        // Get the button
        var scrollToTopBtn = document.getElementById("scrollToTopBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () {
            scrollFunction();
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollToTopBtn.style.display = "block";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        scrollToTopBtn.onclick = function () {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        };

    </script>
<!-- End Header -->
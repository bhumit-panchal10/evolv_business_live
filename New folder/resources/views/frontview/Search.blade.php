@extends('layouts.front')
@section('opTag')
@section('title', $seo->metaTitle)

<meta name="description" content="{{ $seo->metaDescription }}" />
<meta name="keywords" content="{{ $seo->metaKeyword }}" />
{!! $seo->head !!}
{!! $seo->body !!}


@endsection

@section('content')
<head>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: aliceblue;
        }

        .card-h {
            max-width: 100%;
            display: flex;
            flex-direction: row;
            background-color: #fff;
            border: 0;
            box-shadow: 0 7px 7px rgba(0, 0, 0, 0.18);
            padding: 10px;
            align-items: center;
            border-radius: 6px;
            margin: 0px 0px 30px 0px;
        }

        .card.dark {
            color: #fff;
        }

        .card.card.bg-light-subtle .card-title {
            color: dimgrey;
        }

        .card-h img {
            max-width: 25%;
            margin: auto;
            padding: 0.5em;
            border-radius: 0.7em;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
        }

        .text-section {
            max-width: 100%;
        }

        .cta-section {
            /* max-width: 40%; */
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
        }

        .cta-section .btn {
            padding: 0.3em 0.5em;
            /* color: #696969; */
        }

        .card.bg-light-subtle .cta-section .btn {
            background-color: #898989;
            border-color: #898989;
        }

        @media screen and (max-width: 475px) {
            .card {
                font-size: 0.9em;
            }
        }



        .inq-btn button {
            border: none;
            color: white;
            background: linear-gradient(to right, #78c046, #26a9cd);
            border-radius: 4px;
            padding: 6px 25px;
        }

        .mb-50 {
            margin-bottom: 30px;
        }

        .price {
            margin: 5px 0px;
            font-weight: 600;
        }


        /* Popup  */

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 10001;
        }

        .popup-content {
                /* background-color: #8BC34A; */
        max-width: 400px;
        padding: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        box-shadow: 0 7px 7px rgba(0, 0, 0,);
            }

        .closeBtn {
           color: #000;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            right: 12px;
            top: 0px;
        }

        .closeBtn:hover,
        .closeBtn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .inp-list input,
        textarea {
                border: none;
                padding: 7px;
                margin: 5px 0px;
                border: 1px solid #9E9E9E;
                    }


        .sb-btns {
             background: linear-gradient(to right, #78c046, #26a9cd);
            color: white;
            text-transform: uppercase;
        }
        
        
        
        
        /*New Css */
        
        
dropdownsearch{
  height:100%;
  display:flex;
  align-items:center;
  justify-content:center;
    font-family: 'Ubuntu', sans-serif;

}
.options{
  
  width:100%;  
}


select {
    display: none !important;
}

.dropdown-select {
    background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0) 100%);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#40FFFFFF', endColorstr='#00FFFFFF', GradientType=0);
    background-color: #fff;
   
    border: solid 1px #eee;
    box-shadow: 0px 2px 5px 0px rgba(155, 155, 155, 0.5);
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    float: left;
    font-size: 14px;
    font-weight: normal;
    height: 42px;
    line-height: 40px;
    outline: none;
    padding-left: 18px;
    padding-right: 30px;
    position: relative;
    text-align: left !important;
    transition: all 0.2s ease-in-out;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    white-space: nowrap;
    width: auto;

}

.dropdown-select:focus {
    background-color: #fff;
}

.dropdown-select:hover {
    background-color: #fff;
}

.dropdown-select:active,
.dropdown-select.open {
    background-color: #fff !important;
    border-color: #bbb;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05) inset;
}

.dropdown-select:after {
    height: 0;
    width: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid #777;
    -webkit-transform: origin(50% 20%);
    transform: origin(50% 20%);
    transition: all 0.125s ease-in-out;
    content: '';
    display: block;
    margin-top: -2px;
    pointer-events: none;
    position: absolute;
    right: 10px;
    top: 50%;
}

.dropdown-select.open:after {
    -webkit-transform: rotate(-180deg);
    transform: rotate(-180deg);
}

.dropdown-select.open .list {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 1;
    pointer-events: auto;
}

.dropdown-select.open .option {
    cursor: pointer;
}

.dropdown-select.wide {
    width: 100%;
}

.dropdown-select.wide .list {
    left: 0 !important;
    right: 0 !important;
}

.dropdown-select .list {
    box-sizing: border-box;
    transition: all 0.15s cubic-bezier(0.25, 0, 0.25, 1.75), opacity 0.1s linear;
    -webkit-transform: scale(0.75);
    transform: scale(0.75);
    -webkit-transform-origin: 50% 0;
    transform-origin: 50% 0;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.09);
    background-color: #fff;
    border-radius: 6px;
    margin-top: 4px;
    padding: 3px 0;
    opacity: 0;
    overflow: hidden;
    pointer-events: none;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 999;
    max-height: 250px;
    overflow: auto;
    border: 1px solid #ddd;
}

.dropdown-select .list:hover .option:not(:hover) {
    background-color: transparent !important;
}
.dropdown-select .dd-search{
  overflow:hidden;
  display:flex;
  align-items:center;
  justify-content:center;
  margin:0.5rem;
}

.dropdown-select .dd-searchbox{
  width:90%;
  padding:0.5rem;
  border:1px solid #999;
  border-color:#999;
  border-radius:4px;
  outline:none;
  height:38px;
}
.dropdown-select .dd-searchbox:focus{
  border-color:#12CBC4;
}

.dropdown-select .list ul {
    padding: 0;
}

.dropdown-select .option {
    cursor: default;
    font-weight: 400;
    line-height: 40px;
    outline: none;
    padding-left: 18px;
    padding-right: 29px;
    text-align: left;
    transition: all 0.2s;
    list-style: none;
}

.dropdown-select .option:hover,
.dropdown-select .option:focus {
    background-color: #f6f6f6 !important;
}

.dropdown-select .option.selected {
    font-weight: 600;
    color: #12cbc4;
}

.dropdown-select .option.selected:focus {
    background: #f6f6f6;
}

.dropdown-select a {
    color: #aaa;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}

.dropdown-select a:hover {
    color: #666;
}


.rs-inner-blog .widget-area .categories ul li {
     margin-top: 0px; 
     padding-top: 0px; 
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}


.src-btn{
    border: none;
    color: white;
    background: linear-gradient(to right, #78c046, #26a9cd);
    /*border-radius: 4px;*/
    height: 43px;

}

.spp{
    background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0) 100%);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#40FFFFFF', endColorstr='#00FFFFFF', GradientType=0);
    background-color: #fff;
    border: solid 1px #eee;
    box-shadow: 0px 2px 5px 0px rgba(155, 155, 155, 0.5);
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    float: left;
    font-size: 14px;
    font-weight: normal;
    height: 42px;
    line-height: 40px;
    outline: none;
    padding-left: 18px;
    padding-right: 30px;
    position: relative;
    text-align: left !important;
    transition: all 0.2s ease-in-out;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    white-space: nowrap;
    width: auto;
    width: 100%;
}


.w-18{
    width:18%;
}


.vm-btn{
       margin: 6px 0px 0px 0px;
    text-decoration: underline;
    font-weight: 500;
    font-size: 18px;
    color: #68bc5e;
    cursor:pointer;
}

.c li::marker{
    color:#68bc5e;
}



    </style>
</head>
    
        <section class="rs-inner-blog pt-120 pb-120 section-gap">
        <div class="container-fluid">
            <div class="row">
            <div class="col-lg-4">
                <div class="widget-area">
                    <div class="categories mb-50">
                        <div class="widget-title mb-15">
                         <h3 class="title">Search Filters</h3>
                            <!-- new -->
                               
                        <form action="{{route('Search')}}" method="post">
                           @csrf 
                            <div class="d-flex align-items-center mt-4">
                                <div class="dropdownsearch  w-75">
                                    <div class="options">
                                        <input class="spp" type="text" placeholder="Search" name="first_name1" id="searchInput" value="<?= isset($Adminfirst_name) ? $Adminfirst_name : '' ?>">
                                    </div>
                                </div>
                                    <!-- <button class="w-18 src-btn"><i class="fa fa-search" aria-hidden="true"></i></button> -->
                                    <button class="w-18 src-btn" id="cancelSearch"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </div>
                        </form>  
                            <!-- new -->
                            <h3 class="title pt-3">Categories</h3>
                            <ul class="mt-3 c">
                            @foreach($service as $item)
                                    <li><a href="{{route('Search', $item->category_slug)}}">{!! substr(strip_tags($item->name), 0, 20)."..."; !!}</a></li>
                            @endforeach  
                            
                            <div class="vm-btn">
                                view more
                            </div>
                            </ul>
                            
                            <!--{{ $service->links() }}-->
                            <!-- new -->
                        </div>  
                        <form action="{{route('Search')}}" method="post">
                           @csrf 
                            <div class="d-flex align-items-center mt-3">
                                <div class="dropdownsearch  w-75">
                                    <div class="options">
                                        <select name="categoriesid" id="dynamic_select">
                                            <option value="" disabled selected>Select Category</option>
                                            @foreach ($categorys as $Data)
                                                <option value="{{ $Data->id }}"{{isset($categories_id) && $Data->id == $categories_id ? 'selected' : '' }}>{{ $Data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- <button class="w-18 src-btn"><i class="fa fa-search" aria-hidden="true"></i></button> -->
                                <button class="w-18 src-btn" id="cancelSearch"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </div>
                        </form>  
                    </div>
                </div>
            </div>

            @if($Count > 0)
                <div class="col-lg-8" id="productsContainer">
                    <?php $i=1; ?>
                   @foreach($Products as $product)
                    <div class="card-h">
                        <img src="{{ asset('productimage') . '/' . $product->photo }}" class="card-img-top"
                            alt="...">
                        <div class="card-body">
                            <div class="text-section">
                                <h5 class="card-title">{{$product->product_name}}</h5>
                                @if(isset($product->price))
                                <div class="mt-2">₹{{$product->price}}</div>                
                                @else 
                                <div class="mt-2">₹{{$product->min_price}} - ₹{{$product->max_price}}</div>                                         
                                @endif  
                                <p class="card-text">{!! $product->description !!}</p>
                                <!-- <a onClick="inqueryPopup({{$i}});"  class="inq-btn"><button id="openBtn_{{$i}}" >Inquiry Now</button></a> -->
                                <a onClick="inqueryPopup({{$product->member_id}}, {{$product->id}});" class="inq-btn">
                                    <button id="openBtn_{{$i}}">i'm interested</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php $i++; ?>
                     @endforeach  
                      <!-- Pagination Links -->
                      <div class="d-flex justify-content-center mt-3" id="paginationLinks">
                         {{ $Products->links() }} 
                      </div>
                      @else 
                         <div class="col-lg-8 col-md-12  col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                             <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                 <h1 class="font-white text-center"> No Data Found ! </h1>
                             </div>
                         </div>
                    
                     @endif
                </div>
            </div>
        </div>
    </section>


    <!-- Popup  -->
    <div class="popup" id="popup">
        <div class="popup-content">
            <span class="closeBtn" id="closeBtn">&times;</span>
            <p class="mb-0">&nbsp;</p>
            <!--<p class="head-txt">Product Inquiry</p>-->
            <div>
                <form action="{{route('ProductInquiry')}}" class="mt-2 inp-list" method="post">
                    @csrf
                    <input type="hidden" name="memberid" id="member_id">
                    <input type="hidden" name="productid" id="product_id">
                    <input class="w-100" type="text" placeholder="Name" name="Name" required>
                    <input class="w-100" type="email" placeholder="Enter Email" name="email" required>
                    <input class="w-100" type="text" placeholder="Phone Number" name="Phone Number" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" onKeyPress="if(this.value.length==10) return false;" maxlength="10" required>
                    <textarea placeholder="Comment" class="w-100" name="Comment" id="" cols="30" rows="3"></textarea>
                    <input class="w-100 sb-btns" type="submit" value="submit">
                </form>
            </div>
        </div>
    </div>
    <!-- popup  -->


  <script>
        document.getElementById("closeBtn").addEventListener("click", function () {
            document.getElementById("popup").style.display = "none";
        });

        function inqueryPopup(memberId,id){
            // alert(memberId);
            // alert(id); 
            document.getElementById("popup").style.display = "block";
            $("#member_id").val(memberId);
            $("#product_id").val(id);
            // document.getElementById("openBtn_"+id).addEventListener("click", function () {
                
            // });
        }
    </script>
    
 

<script>
    function Inquiry(memberId, id) {
        // alert(memberId);
        // alert(id); 
        $("#member_id").val(memberId);
        $("#product_id").val(id);
    }
</script>


<script>
    
    function create_custom_dropdowns() {
    $('select').each(function (i, select) {
        if (!$(this).next().hasClass('dropdown-select')) {
            $(this).after('<div class="dropdown-select wide ' + ($(this).attr('class') || '') + '" tabindex="0"><span class="current"></span><div class="list"><ul></ul></div></div>');
            var dropdown = $(this).next();
            var options = $(select).find('option');
            var selected = $(this).find('option:selected');
            dropdown.find('.current').html(selected.data('display-text') || selected.text());
            options.each(function (j, o) {
                var display = $(o).data('display-text') || '';
                dropdown.find('ul').append('<li class="option ' + ($(o).is(':selected') ? 'selected' : '') + '" data-value="' + $(o).val() + '" data-display-text="' + display + '">' + $(o).text() + '</li>');
            });
        }
    });

    $('.dropdown-select ul').before('<div class="dd-search"><input id="txtSearchValue" autocomplete="off" onkeyup="filter()" class="dd-searchbox" type="text"></div>');
}

// Event listeners

// Open/close
$(document).on('click', '.dropdown-select', function (event) {
    if($(event.target).hasClass('dd-searchbox')){
        return;
    }
    $('.dropdown-select').not($(this)).removeClass('open');
    $(this).toggleClass('open');
    if ($(this).hasClass('open')) {
        $(this).find('.option').attr('tabindex', 0);
        $(this).find('.selected').focus();
    } else {
        $(this).find('.option').removeAttr('tabindex');
        $(this).focus();
    }
});

// Close when clicking outside
$(document).on('click', function (event) {
    if ($(event.target).closest('.dropdown-select').length === 0) {
        $('.dropdown-select').removeClass('open');
        $('.dropdown-select .option').removeAttr('tabindex');
    }
    event.stopPropagation();
});

function filter(){
    var valThis = $('#txtSearchValue').val();
    $('.dropdown-select ul > li').each(function(){
     var text = $(this).text();
        (text.toLowerCase().indexOf(valThis.toLowerCase()) > -1) ? $(this).show() : $(this).hide();         
   });
};
// Search

// Option click
$(document).on('click', '.dropdown-select .option', function (event) {
    $(this).closest('.list').find('.selected').removeClass('selected');
    $(this).addClass('selected');
    var text = $(this).data('display-text') || $(this).text();
    $(this).closest('.dropdown-select').find('.current').text(text);
    $(this).closest('.dropdown-select').prev('select').val($(this).data('value')).trigger('change');
});

// Keyboard events
$(document).on('keydown', '.dropdown-select', function (event) {
    var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
    // Space or Enter
    //if (event.keyCode == 32 || event.keyCode == 13) {
    if (event.keyCode == 13) {
        if ($(this).hasClass('open')) {
            focused_option.trigger('click');
        } else {
            $(this).trigger('click');
        }
        return false;
        // Down
    } else if (event.keyCode == 40) {
        if (!$(this).hasClass('open')) {
            $(this).trigger('click');
        } else {
            focused_option.next().focus();
        }
        return false;
        // Up
    } else if (event.keyCode == 38) {
        if (!$(this).hasClass('open')) {
            $(this).trigger('click');
        } else {
            var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
            focused_option.prev().focus();
        }
        return false;
        // Esc
    } else if (event.keyCode == 27) {
        if ($(this).hasClass('open')) {
            $(this).trigger('click');
        }
        return false;
    }
});

$(document).ready(function () {
    create_custom_dropdowns();
});




</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js">
</script>
    


<!-- on new code changed 22-05-2024 start -->
<script>
    $(document).ready(function(){
    $('#dynamic_select').change(function(){
        var categories_id = $(this).val();
        $.ajax({
            url: "{{ route('Search') }}",
            method: 'GET',
            data: { categories_id: categories_id },
            success: function(data){
                // Clear previous content
                $('#productsContainer').html('');
                $('#paginationLinks').html('');

                // Check if data.Products.data is empty
                if (data.Products.data.length === 0) {
                    // Display 'No Data Found' message
                    $('#productsContainer').html(`
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                    <h1 class="font-white text-center">No Data Found!</h1>
                                </div>
                            </div>
                        </div>
                    `);
                } else {
                    // Handle the received data
                    var productsHTML = '';
                    $.each(data.Products.data, function(index, product) {
                        productsHTML += '<div class="card-h">';
                        productsHTML += '<img src="{{ asset("productimage") }}/' + product.photo + '" class="card-img-top" alt="...">';
                        productsHTML += '<div class="card-body">';
                        productsHTML += '<div class="text-section">';
                        productsHTML += '<h5 class="card-title">' + product.product_name + '</h5>';
                        if (product.price != null) {
                            productsHTML += '<div class="mt-2">₹' + product.price + '</div>';
                        } else {
                            productsHTML += '<div class="mt-2">₹' + product.min_price + ' - ₹' + product.max_price + '</div>';
                        }
                        productsHTML += '<p class="card-text">' + product.description + '</p>';
                        productsHTML += '<a onClick="inqueryPopup(' + product.member_id + ', ' + product.id + ');" class="inq-btn">';
                        productsHTML += '<button id="openBtn_' + index + '">I\'m interested</button>';
                        productsHTML += '</a></div></div></div>';
                    });
                    $('#productsContainer').html(productsHTML);
                    // Update pagination links
                    $('#paginationLinks').html(data.Products.links);
                }
            },
            error: function(xhr, status, error){
                // Handle error
                console.error(error);
            }
        });
    });
 });

</script>
<!-- on changed code end 22-05-2024 -->

<!-- on key up 22-05-2024 start -->
<script>
    $(document).ready(function(){
        // Function to fetch products based on search input
        function fetchProducts(searchQuery) {
            $.ajax({
                url: "{{ route('Search') }}",
                method: 'GET',
                data: { first_name1: searchQuery },
                success: function(data){
                    // Clear previous results
                    $('#productsContainer').html('');

                    // Check if data is found
                    if (data.data.length === 0) {
                        $('#productsContainer').html(`
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 padding-5 bottom-border-verydark">
                                    <div class="alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                        <h1 class="font-white text-center">No Data Found!</h1>
                                    </div>
                                </div>
                            </div>
                        `);
                    } else {
                        // Render fetched products
                        $.each(data.data, function(index, product) {
                            var productHtml = `
                                <div class="card-h">
                                    <img src="{{ asset('productimage') }}/${product.photo}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <div class="text-section">
                                            <h5 class="card-title">${product.product_name}</h5>
                                            <div class="mt-2">₹${product.price}</div>
                                            <p class="card-text">${product.description}</p>
                                            <a onClick="inqueryPopup(${product.member_id}, ${product.id});" class="inq-btn">
                                                <button id="openBtn_${index+1}">I'm interested</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#productsContainer').append(productHtml);
                        });
                    }
                    // Update pagination links if needed
                    $('#paginationLinks').html(data.links);
                },
                error: function(xhr, status, error){
                    console.error(error);
                }
            });
        }
        // Trigger search on keyup event
        $('#searchInput').on('keyup', function(){
            var searchQuery = $(this).val();
            fetchProducts(searchQuery);
        });
    });
</script>
<!-- on key up end 22-05-2024 -->

<script>
    $(document).ready(function(){
        // Add click event listener to the cancel button
        $('#cancelSearch').click(function(){
           
            $('#searchInput').val('');
          
            $('#dynamic_select').val('');
            
            location.reload();
        });
    });
</script>


<!-- old on changed code start -->

<!-- <script>
    $(document).ready(function(){
        $('#dynamic_select').change(function(){
            var categories_id = $(this).val();
            // alert(category_id);
            $.ajax({
                url: "{{route('Search')}}",
                method: 'GET',
                data: { categories_id: categories_id },
                success: function(data){
                    // Handle the received data
                    $('#filteredDataContainer').html(data);
                    // Now, update the HTML with the data
                    var productsHTML = '';
                    $.each(data.Products.data, function(index, product) {
                        productsHTML += '<div class="card-h">';
                        productsHTML += '<img src="{{ asset("productimage") }}/' + product.photo + '" class="card-img-top" alt="...">';
                        productsHTML += '<div class="card-body">';
                        productsHTML += '<div class="text-section">';
                        productsHTML += '<h5 class="card-title">' + product.product_name + '</h5>';
                        if(product.price != null){
                            productsHTML += '<div class="mt-2">₹' + product.price + '</div>';
                        } else {
                            productsHTML += '<div class="mt-2">₹' + product.min_price + ' - ₹' + product.max_price + '</div>';
                        }
                        productsHTML += '<p class="card-text">' + product.description + '</p>';
                        productsHTML += '<a onClick="inqueryPopup(' + product.member_id + ', ' + product.id + ');" class="inq-btn">';
                        productsHTML += '<button id="openBtn_' + index + '">i\'m interested</button>';
                        productsHTML += '</a></div></div></div>';
                    });
                    $('#productsContainer').html(productsHTML);
                    // Update pagination links
                    $('#paginationLinks').html(data.Products.links);
                },
                error: function(xhr, status, error){
                    // Handle error
                    console.error(error);
                }
            });
        });
    });
</script> -->

<!-- <script>
    $(document).ready(function(){
        // Function to fetch products based on search input
        function fetchProducts(searchQuery) {
            $.ajax({
                url: "{{ route('Search') }}",
                method: 'GET',
                data: { first_name1: searchQuery },
                success: function(data){
                    // Clear previous results
                    $('#productsContainer').html('');

                    // Render fetched products
                    $.each(data.data, function(index, product) {
                        var productHtml = `
                            <div class="card-h">
                                <img src="{{ asset('productimage') }}/${product.photo}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <div class="text-section">
                                        <h5 class="card-title">${product.product_name}</h5>
                                        <div class="mt-2">₹${product.price}</div>
                                        <p class="card-text">${product.description}</p>
                                        <a onClick="inqueryPopup(${product.member_id}, ${product.id});" class="inq-btn">
                                            <button id="openBtn_${index+1}">i'm interested</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#productsContainer').append(productHtml);
                    });
                    // Update pagination links if needed
                    $('#paginationLinks').html(data.links);
                },
                error: function(xhr, status, error){
                    console.error(error);
                }
            });
        }
        // Trigger search on keyup event
        $('#searchInput').on('keyup', function(){
            var searchQuery = $(this).val();
            fetchProducts(searchQuery);
        });
    });
</script> -->

<!-- old on changed code  end -->

    @endsection

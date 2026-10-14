@extends('layouts.app')

@section('title', 'Detail List')

@section('content')
    <style>
        .product-header {
            background: #67a63f;
            color: #fff;
            font-weight: 600;
            border: 0;
        }

        .product-card {
            border: 1px solid #ececec;
            border-radius: 10px;
            background: #fff;
            height: 100%;
            transition: 0.3s;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .product-inner {
            display: flex;
            gap: 10px;
            padding: 10px;
        }

        .product-image {
            width: 85px;
            height: 85px;
            flex-shrink: 0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .product-content {
            flex: 1;
            min-width: 0;
        }

        .product-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #111;
        }

        .product-price {
            font-size: 13px;
            font-weight: 700;
            color: #67a63f;
            white-space: nowrap;
        }

        .product-desc {
            font-size: 12px;
            line-height: 1.5;
            color: #666;
            margin-top: 4px;
            word-break: break-word;
        }

        .member-profile-card {
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        .member-profile-header {
            background: linear-gradient(135deg, #67a63f, #568d34);
            padding: 18px;
        }

        .member-avatar {
            width: 90px;
            height: 90px;
            border-radius: 12px;
            object-fit: cover;
            border: 3px solid #fff;
            background: #fff;
        }

        .member-contact {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            font-size: 13px;
        }

        .member-contact span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .member-priority-badge {
            background: #fff;
            color: #111;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .member-detail-card {
            background: #f8fafc;
            border-radius: 10px;
            padding: 10px 12px;
            height: 100%;
        }

        .member-detail-card label {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 2px;
            display: block;
        }

        .member-detail-card p {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .member-social-icons {
            display: flex;
            gap: 10px;
        }

        .member-social-icons a {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #67a63f;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .member-about-box {
            background: #f8fafc;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            line-height: 1.7;
            color: #4b5563;
        }

        @media(max-width:768px) {

            .product-inner {
                align-items: flex-start;
            }

            .product-image {
                width: 75px;
                height: 75px;
            }

        }
    </style>

    <style>
        .award-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 14px;
            transition: 0.3s;
        }

        .award-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .award-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .award-desc {
            font-size: 13px;
            line-height: 1.6;
            word-break: break-word;
        }

        @media (max-width: 576px) {

            .award-img {
                width: 75px;
                height: 75px;
            }

            .award-desc {
                font-size: 12px;
            }
        }
    </style>
    <div class="main-content mt-3">
        <div class="page-content">
            <div class="container-fluid">

                {{-- ================= MEMBER PROFILE HEADER ================= --}}
                <div class="member-profile-card mb-3">

                    {{-- HEADER --}}
                    <div class="member-profile-header">

                        <div class="d-flex align-items-center">

                            {{-- IMAGE --}}
                            <div class="me-3">

                                @if (!empty($Member->profile_photo))
                                    <img src="{{ asset('profile_photo/' . $Member->profile_photo) }}" class="member-avatar">
                                @else
                                    <img src="https://groath.in/assets/images/noimage.png" class="member-avatar">
                                @endif

                            </div>

                            {{-- INFO --}}
                            <div class="flex-grow-1 text-white">

                                <div class="d-flex align-items-center flex-wrap gap-2">

                                    <h3 class="mb-0 fw-bold">
                                        {{ $Member->Contact_person ?? '-' }}
                                    </h3>

                                    @if (isset($Member->priority_club_3_year) && $Member->priority_club_3_year == 1)
                                        <span class="member-priority-badge">
                                            ⭐ Priority Member
                                        </span>
                                    @endif

                                </div>

                                <div class="small mt-1">
                                    <i class="fas fa-building me-1"></i>
                                    {{ $Member->companyname ?? '-' }}
                                </div>

                                <div class="member-contact mt-2">

                                    <span>
                                        <i class="fas fa-phone-alt"></i>
                                        {{ $Member->phonenumber ?? '-' }}
                                    </span>

                                    <span>
                                        <i class="fas fa-envelope"></i>
                                        {{ $Member->email ?? '-' }}
                                    </span>

                                    <span>
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $Member->city_name ?? '-' }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-3">

                        <div class="row g-2">

                            <div class="col-md-6">
                                <div class="member-detail-card">
                                    <label>Address</label>
                                    <p>{{ $Member->address ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="member-detail-card">
                                    <label>Date of Birth</label>
                                    <p>{{ $Member->date_of_birth ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="member-detail-card">
                                    <label>GST Number</label>
                                    <p>{{ $Member->gstnumber ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="member-detail-card">
                                    <label>Subscription Expiry</label>
                                    <p>
                                        {{ !empty($Member->SubscriptionExpiredDate)
                                            ? \Carbon\Carbon::parse($Member->SubscriptionExpiredDate)->format('d-m-Y')
                                            : '-' }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-9">

                                <div class="member-detail-card">

                                    <label>Social Media</label>

                                    <div class="member-social-icons mt-1">

                                        @if (!empty($Member->facebook_link))
                                            <a href="{{ $Member->facebook_link }}" target="_blank">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        @endif

                                        @if (!empty($Member->instagram_link))
                                            <a href="{{ $Member->instagram_link }}" target="_blank">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endif

                                        @if (!empty($Member->linkedin_link))
                                            <a href="{{ $Member->linkedin_link }}" target="_blank">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        @endif

                                        @if (!empty($Member->youtube_link))
                                            <a href="{{ $Member->youtube_link }}" target="_blank">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        @endif

                                    </div>

                                </div>

                            </div>

                            @if (!empty($Member->description))
                                <div class="col-12">
                                    <div class="member-about-box">
                                        {!! $Member->description !!}
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

                {{-- ================= PRODUCTS ================= --}}
                <div class="card mb-3">

                    <div class="card-header product-header">
                        <i class="fas fa-shopping-bag me-2"></i>
                        Products
                    </div>

                    <div class="card-body p-2">

                        <div class="row g-2">

                            @forelse ($memberproduct as $product)
                                <div class="col-lg-4 col-md-6">

                                    <div class="product-card">

                                        <div class="product-inner">

                                            {{-- IMAGE --}}
                                            <div class="product-image">

                                                @if ($product->photo == null)
                                                    <img src="https://groath.in/assets/images/noimage.png">
                                                @else
                                                    <img src="{{ '/productimage/' . $product->photo }}">
                                                @endif

                                            </div>

                                            {{-- CONTENT --}}
                                            <div class="product-content">

                                                <div class="d-flex justify-content-between gap-2">

                                                    <h6 class="product-title">
                                                        {{ $product->product_name }}
                                                    </h6>

                                                    <div class="product-price">

                                                        @if (isset($product->price))
                                                            ₹{{ $product->price }}
                                                        @else
                                                            ₹{{ $product->min_price }} - ₹{{ $product->max_price }}
                                                        @endif

                                                    </div>

                                                </div>

                                                <div class="product-desc">
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($product->description), 70) !!}
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="col-12">
                                    <div class="text-center py-3">
                                        No products found.
                                    </div>
                                </div>
                            @endforelse

                        </div>

                    </div>

                </div>

                {{-- ================= AWARDS ================= --}}
                <div class="card mb-3">

                    <div class="card-header product-header">
                        <i class="fas fa-trophy me-2"></i>
                        Awards
                    </div>

                    <div class="card-body p-2">

                        <div class="row g-2">

                            @forelse ($Memberaward as $award)
                                <div class="col-lg-4 col-md-6">

                                    <div class="product-card">

                                        <div class="product-inner">

                                            {{-- IMAGE --}}
                                            <div class="product-image">

                                                @if (!empty($award->photos))
                                                    <img src="{{ asset('Award/' . $award->photos) }}">
                                                @else
                                                    <img src="https://groath.in/assets/images/noimage.png">
                                                @endif

                                            </div>

                                            {{-- CONTENT --}}
                                            <div class="product-content">

                                                <div class="d-flex justify-content-between gap-2 flex-wrap">

                                                    <h6 class="product-title mb-0">
                                                        {{ $award->title ?? '-' }}
                                                    </h6>

                                                    @if (!empty($award->created_at))
                                                        <div class="product-price">
                                                            {{ \Carbon\Carbon::parse($award->created_at)->format('d-m-Y') }}
                                                        </div>
                                                    @endif

                                                </div>

                                                <div class="product-desc mt-1">
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($award->description), 80) !!}
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="col-12">
                                    <div class="text-center py-3">
                                        No awards found.
                                    </div>
                                </div>
                            @endforelse

                        </div>

                    </div>

                </div>

                {{-- ================= ANNOUNCEMENTS ================= --}}
                <div class="card mb-3">
                    <div class="card-header bg-white py-2">
                        <h5 class="section-title">
                            <i class="fas fa-bullhorn text-danger"></i>
                            Announcements
                        </h5>
                    </div>

                    <div class="card-body py-2">
                        @forelse ($Memberannouncement as $announcement)
                            <div class="item-card">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                    <div>
                                        <h6 class="mb-1 text-black fw-bold">
                                            {{ $announcement->title ?? '-' }}
                                        </h6>

                                        @if (!empty($announcement->created_at))
                                            <div class="text-muted compact-text mb-1">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($announcement->created_at)->format('d-m-Y') }}
                                            </div>
                                        @endif
                                    </div>

                                    <span class="badge-soft">
                                        Announcement
                                    </span>
                                </div>

                                <div class="text-muted mt-1 compact-text">
                                    {!! $announcement->description ?? '-' !!}
                                </div>
                            </div>
                        @empty
                            <div class="empty-box">
                                No announcements found.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

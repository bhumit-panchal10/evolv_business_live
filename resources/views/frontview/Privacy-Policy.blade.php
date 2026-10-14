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
      .priv-head p {
            color: #000;
            font-size: 16px;
        }

        .priv-head p strong {
            color: #78c046;
            font-size: 20px;
        }
</style>
<section class="blog-single section section-gap">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 priv-head">
                        <h2 class="mb-5">Privacy Policy</h2>



                        <p><strong>What Do We Do With Our Information</strong></p>


                        <p>When you purchase something from our store, as part of the buying and selling process, we
                            collect the personal information you give us such as your name, address and email address.
                        </p>

                        <p>When you browse our store, we also automatically receive your computer’s internet protocol
                            (IP)
 address in order to provide us with information that helps us learn about your browser
                            and operating system.</p>

                        <p>Email marketing (if applicable): With your permission, we may send you emails about our
                            store, new products and other updates</p>

                        <p>.</p>

                        <p><strong>Conset</strong></p>



                        <p>How do you get my consent?</p>

                        <p>When you provide us with personal information to complete a transaction, verify your credit
                            card, place an order, arrange for a delivery or return a purchase, we imply that you consent
                            to our collecting it and using it for that specific reason only.</p>

                        <p>If we ask for your personal information for a secondary reason, like marketing, we will
                            either ask you directly for your expressed consent, or provide you with an opportunity to
                            say no.</p>

                        <p>How do I withdraw my consent?</p>

                        <p>If after you opt-in, you change your mind, you may withdraw your consent for us to contact
                            you, for the continued collection, use or disclosure of your information, at anytime, by
                            contacting us at 307, Titanium One, Pakvan Cross Road, SG Highway, Ahmedabad-380054 or mailing us at: info@getdemo.in</p>



                        <p><strong>Disclosure</strong></p>



                        <p>We may disclose your personal information if we are required by law to do so or if you
                            violate our Terms of Service.</p>

                        <p>&nbsp;</p>

                        <p><strong>Payment</strong></p>



                        <p>We use Razorpay for processing payments. We/Razorpay do not store your card data on their
                            servers. The data is encrypted through the Payment Card Industry Data Security Standard
                            (PCI-DSS) when processing payment. Your purchase transaction data is only used as long as is
                            necessary to complete your purchase transaction. After that is complete, your purchase
                            transaction information is not saved. Our payment gateway adheres to the standards set by
                            PCI-DSS as managed by the PCI Security Standards Council, which is a joint effort of brands
                            like Visa, MasterCard, American Express and Discover. PCI-DSS requirements help ensure the
                            secure handling of credit card information by our store and its service providers. For more
                            insight, you may also want to read terms and conditions of razorpay on https://razorpay.com
                        </p>



                        <p><strong>Third Party Services</strong></p>



                        <p>In general, the third-party providers used by us will only collect, use and disclose your
                            information to the extent necessary to allow them to perform the services they provide to
                            us.</p>

                        <p>However, certain third-party service providers, such as payment gateways and other payment
                            transaction processors, have their own privacy policies in respect to the information we are
                            required to provide to them for your purchase-related transactions.</p>

                        <p>For these providers, we recommend that you read their privacy policies so you can understand
                            the manner in which your personal information will be handled by these providers.</p>

                        <p>In particular, remember that certain providers may be located in or have facilities that are
                            located a different jurisdiction than either you or us. So if you elect to proceed with a
                            transaction that involves the services of a third-party service provider, then your
                            information may become subject to the laws of the jurisdiction(s) in which that service
                            provider or its facilities are located.</p>

                        <p>Once you leave our store’s website or are redirected to a third-party website or application,
                            you are no longer governed by this Privacy Policy or our website’s Terms of Service.</p>

                        <p>Links When you click on links on our store, they may direct you away from our site. We are
                            not responsible for the privacy practices of other sites and encourage you to read their
                            privacy statements.</p>



                        <p><strong>Security</strong></p>



                        <p>To protect your personal information, we take reasonable precautions and follow industry best
                            practices to make sure it is not inappropriately lost, misused, accessed, disclosed, altered
                            or destroyed.</p>



                        <p><strong>Cookies</strong></p>



                        <p>We use cookies to maintain session of your user. It is not used to personally identify you on
                            other websites.</p>



                        <p><strong>Age Of Consent</strong></p>



                        <p>By using this site, you represent that you are at least the age of majority in your state or
                            province of residence, or that you are the age of majority in your state or province of
                            residence and you have given us your consent to allow any of your minor dependents to use
                            this site.</p>



                        <p><strong>Changes To The Privacy Policy</strong></p>



                        <p>We reserve the right to modify this privacy policy at any time, so please review it
                            frequently. Changes and clarifications will take effect immediately upon their posting on
                            the website. If we make material changes to this policy, we will notify you here that it has
                            been updated, so that you are aware of what information we collect, how we use it, and under
                            what circumstances, if any, we use and/or disclose it.</p>

                        <p>If our store is acquired or merged with another company, your information may be transferred
                            to the new owners so that we may continue to sell products to you.</p>



                        <p><strong>Questions And Contact Information</strong></p>



                        <p>If you would like to: access, correct, amend or delete any personal information we have about
                            you, register a complaint, or simply want more information contact our Privacy Compliance
                            Officer at 307, Titanium One, Pakvan Cross Road, SG Highway, Ahmedabad-380054 or by mail at info@getdemo.in</p>
                    </div>
                </div>
            </div>
        </section>

@endsection

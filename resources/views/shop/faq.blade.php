@extends('layouts.shop_layout.master')
@section('content')
    <!-- faq-area area start here  -->
    <div class="faq-area section" style="padding-top: 0%">
        <div class="container">
            <div class="row">
                @include('shop.include.page_sidebar')

                <div class="col-lg-9 col-md-8">
                    <div class="accordion" id="accordionFaq">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    What is CITi24?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p class="faq-text">CITi24 is your premier online destination for cutting-edge electronic gadgets and tech products. We offer a curated selection of innovative devices with guaranteed 24-hour delivery to keep you at the forefront of technology.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                                    How does CITi24 work?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p class="faq-text">Browse our extensive collection of tech products, place your order online, and enjoy lightning-fast 24-hour delivery. Our platform is designed for a seamless shopping experience with round-the-clock customer support.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                                    What types of products are available on CITi24?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p class="faq-text">We offer a wide range of tech products including smartphones, laptops, tablets, smartwatches, headphones, gaming accessories, smart home devices, and the latest innovative gadgets.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                                    How can I be sure about product quality and authenticity?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p class="faq-text">All products on CITi24 are sourced directly from authorized distributors and manufacturers. We guarantee 100% genuine products with valid warranties. Our quality assurance team thoroughly checks every item before dispatch.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                                    How does your 24-hour delivery work?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p class="faq-text">Our 24-hour delivery guarantee means your order will be at your doorstep within one day of purchase. We achieve this through our optimized logistics network and strategically located warehouses. Delivery times may vary slightly based on your location.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading6">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
                                    Do you offer technical support for purchased products?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p class="faq-text">Yes! CITi24 provides comprehensive technical support for all products purchased through our platform. Our support team is available 24/7 to assist with setup, troubleshooting, and any technical questions you may have.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading7">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
                                    What payment methods are accepted on CITi24?
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p class="faq-text">We accept all major payment methods including credit/debit cards, bank transfers, PayPal, and popular mobile payment options. All transactions are secured with advanced encryption technology.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading8">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse8" aria-expanded="true" aria-controls="collapse8">
                                    Are there any membership benefits?
                                </button>
                            </h2>
                            <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p class="faq-text">Our CITi24 Premium Membership offers exclusive benefits including priority 24-hour delivery, extended warranties, special discounts, early access to new products, and dedicated tech support.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading9">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse9" aria-expanded="true" aria-controls="collapse9">
                                    How can I contact CITi24 for support?
                                </button>
                            </h2>
                            <div id="collapse9" class="accordion-collapse collapse show" aria-labelledby="heading9"
                                data-bs-parent="#accordionFaq">
                                <div class="accordion-body">
                                    <p class="faq-text">Our 24/7 customer support is available via:<br>
                                    • Phone: (+234)9013762265<br>
                                    • Email: innovatewithciti@gmail.com<br>
                                    • Live chat on our website<br>
                                    • Social media channels</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- faq-area area end here  -->
@endsection
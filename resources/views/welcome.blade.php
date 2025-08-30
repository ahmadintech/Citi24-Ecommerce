<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== FAVICON ===============-->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00a300">
    <meta name="theme-color" content="#ffffff">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="user/css/style.css">

    <title>CITi24</title>


    <style>
        /* CSS */
        .button-3 {
            appearance: none;
            background-color: #01204c;
            border: 1px solid rgba(27, 31, 35, .15);
            border-radius: 6px;
            box-shadow: rgba(27, 31, 35, .1) 0 1px 0;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            padding: 6px 16px;
            position: relative;
            text-align: center;
            text-decoration: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: middle;
            white-space: nowrap;
        }

        .button-3:focus:not(:focus-visible):not(.focus-visible) {
            box-shadow: none;
            outline: none;
        }

        .button-3:hover {
            background-color: #2c974b;
        }

        .button-3:focus {
            box-shadow: rgba(46, 164, 79, .4) 0 0 0 3px;
            outline: none;
        }

        .button-3:disabled {
            background-color: #94d3a2;
            border-color: rgba(27, 31, 35, .1);
            color: rgba(255, 255, 255, .8);
            cursor: default;
        }

        .button-3:active {
            background-color: #298e46;
            box-shadow: rgba(20, 70, 32, .2) 0 1px 0 inset;
        }
    </style>


</head>

<body>
    <!--=============== HEADER ===============-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="" class="nav-logo">
                <img src="user/img/logo.png" alt="" class=""> CITi24
            </a>
            <span style="">
                <li class="nav-item" style="list-style-type: none">
                    <a class="button-3" href="{{ route('shop.product') }}" role="button">Shop</a>
                </li>

            </span>

            <div class="nav-menu" id="nav-menu">
                <ul class="nav-list">


                    <li class="nav-item">
                        <a href="#home" class="nav-link active-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="#why" class="nav-link">Why Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#how" class="nav-link">How it Works</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link">Contact</a>
                    </li>
                </ul>

                <!-- Close button -->
                <div class="nav-close" id="nav-close">
                    <i class="ri-close-line"></i>
                </div>
            </div>

            <!-- Toggle button -->
            <div class="nav-toggle" id="nav-toggle">
                <i class="ri-menu-4-fill"></i>
            </div>
        </nav>
    </header>

    <!--=============== MAIN ===============-->
    <main class="main">
        <section class="home section" id="home">
            <div class="home-container container grid">
                <div class="home-data">
                    <h1 class="home-title">Welcome to CITi24 </h1>

                    <p class="home-description">
                        Organic Bounty, Nurturing Wellness
                    </p>

                    <p class="home-description">
                        At CITi24, we believe in fostering a direct
                        connection between farmers and consumers. Our marketplace
                        is dedicated to supporting local agriculture and providing
                        fresh, high-quality farm produce to individuals and businesses
                        in our community. With our easy-to-use platform, you can discover
                        a wide range of farm-fresh products, support sustainable farming
                        practices, and enjoy the bounties of the land.
                    </p>

                    <!-- <a href="" class="button">Order Now</a> -->

                    <!-- <img src="user/img/apple.png" alt="" class="home-fruit"> -->
                </div>

                <img src="user/img/hero.jpg" alt="" class="home-img">
            </div>
        </section>

        <!--=============== MISSION ===============-->
        <section class="section-alt">
            <div class="about-container container grid">
                <img src="user/img/basket.png" alt="" class="about-img">

                <div class="about-data">
                    <h2 class="section-title">Mission Statement</h2>

                    <p class="about-description">
                        Our mission is to empower farmers to share their organic bounty while
                        offering health-conscious consumers easy access to fresh, ethically sourced foods.
                        Through our dedication to transparency, quality, and environmental responsibility,
                        we strive to cultivate a community where the principles of well-being and sustainability
                        converge, inspiring healthier lifestyles and supporting the livelihoods of farmers committed
                        to organic agriculture.
                    </p>
                </div>
            </div>
        </section>

        <!--=============== VISION ===============-->
        <section class="section-alt">
            <div class="about-container container grid">
                <div class="about-data">
                    <h2 class="section-title">Vision Statement</h2>

                    <p class="about-description">
                        Our vision is to establish a digital marketplace that champions
                        wellness and vitality by connecting consumers with a diverse array
                        of organic farm produce. We aim to empower farmers to share their
                        organic harvests with health-conscious consumers, fostering a community
                        where sustainable, ethical, and nourishing food choices are readily accessible.
                        Through our commitment to transparency and quality, we seek to inspire a future
                        where the CITi24 journey embodies the principles of holistic well-being,
                        supporting both the health of individuals and the planet.
                    </p>
                </div>

                <img src="user/img/basket.png" alt="" class="about-img">
            </div>
        </section>

        <!--=============== POPULAR ===============-->
        <section class="popular section" id="about">
            <h2 class="section-title">Discover the Bounty of the Land</h2>

            <p class="section-description">
                At CITi24, we bring the farm to your table. Our marketplace offers an extensive selection
                of farm produce, including:
            </p>

            <div class="popular-container container grid">
                <article class="popular-card">
                    <div class="popular-bg"></div>

                    <img src="user/img/apple.png" alt="" class="popular-img">
                    <h3 class="popular-title">Fresh Fruits</h3>
                    <span class="popular-subtitle">Enjoy the juiciest apples, berries, citrus fruits, and more,
                        straight from the orchard</span>
                </article>
                <article class="popular-card">
                    <div class="popular-bg"></div>

                    <img src="user/img/vegetable.png" alt="" class="popular-img">
                    <h3 class="popular-title">Crisp Vegetables</h3>
                    <span class="popular-subtitle">From leafy greens and vibrant peppers to root vegetables and exotic
                        varieties, our marketplace has it all</span>
                </article>
                <article class="popular-card">
                    <div class="popular-bg"></div>

                    <img src="user/img/cow.png" alt="" class="popular-img">
                    <h3 class="popular-title">Farm-Raised Meats</h3>
                    <span class="popular-subtitle">Savor the flavor of locally sourced beef, pork, poultry, and
                        seafood</span>
                </article>
                <article class="popular-card">
                    <div class="popular-bg"></div>

                    <img src="user/img/milk.png" alt="" class="popular-img">
                    <h3 class="popular-title">Dairy Delights</h3>
                    <span class="popular-subtitle">Indulge in creamy cheeses, farm-fresh milk, and artisanal
                        butter</span>
                </article>
                <article class="popular-card">
                    <div class="popular-bg"></div>

                    <img src="user/img/organic.png" alt="" class="popular-img">
                    <h3 class="popular-title">Organic Options</h3>
                    <span class="popular-subtitle">Discover a range of certified organic produce, free from pesticides
                        and chemicals</span>
                </article>
            </div>
        </section>

        <!--=============== WHY CHOOSE US ===============-->
        <section class="popular section" id="why">
            <h2 class="section-title">Why Choose CITi24?</h2>

            <div class="popular-container-alt container grid">
                <article class="popular-card-alt">
                    <div class="popular-bg-alt"></div>

                    <img src="user/img/1.png" alt="" class="popular-img-alt">
                    <h3 class="popular-title-alt">Supporting Local Farmers</h3>
                    <span class="popular-subtitle-alt">
                        By purchasing from our marketplace, you directly contribute
                        to the growth and sustainability of local farming communities
                    </span>
                </article>
                <article class="popular-card-alt">
                    <div class="popular-bg-alt"></div>

                    <img src="user/img/2.png" alt="" class="popular-img-alt">
                    <h3 class="popular-title-alt">Freshness Guaranteed</h3>
                    <span class="popular-subtitle-alt">
                        We prioritize freshness and quality. Our produce comes straight
                        from the farm, ensuring you receive the tastiest and most nutritious
                        products available
                    </span>
                </article>

                <article class="popular-card-alt">
                    <div class="popular-bg-alt"></div>

                    <img src="user/img/3.png" alt="" class="popular-img-alt">
                    <h3 class="popular-title-alt">Sustainable Practices</h3>
                    <span class="popular-subtitle-alt">
                        We prioritize environmentally friendly farming practices.
                        Many of our farmers utilize organic and regenerative techniques,
                        promoting soil health and biodiversity
                    </span>
                </article>

                <article class="popular-card-alt">
                    <div class="popular-bg-alt"></div>

                    <img src="user/img/4.png" alt="" class="popular-img-alt">
                    <h3 class="popular-title-alt">Transparent Sourcing</h3>
                    <span class="popular-subtitle-alt">
                        Know where your food comes from. Each product listing
                        includes details about the farm, its practices, and the
                        farmers behind the produce
                    </span>
                </article>
            </div>
        </section>

        <!--=============== HOW IT WORKS ===============-->
        <section class="how section" id="how">
            <h2 class="section-title">How It Works</h2>

            <div class="how-container container grid">
                <article class="how-card">
                    <div class="how-bg"></div>

                    <h3 class="how-title">Browse the Marketplace</h3>
                    <span class="how-subtitle">
                        Explore our wide selection of farm produce. Use filters to find specific products,
                        such as organic or locally grown items
                    </span>
                    <img src="user/img/market.png" alt="" class="how-img">
                </article>

                <article class="how-card">
                    <div class="how-bg"></div>

                    <h3 class="how-title">Place Your Order</h3>
                    <span class="how-subtitle">
                        Add your desired products to your cart and proceed to checkout.
                        Select your preferred delivery or pick-up option
                    </span>
                    <img src="user/img/buy.png" alt="" class="how-img">
                </article>

                <article class="how-card">
                    <div class="how-bg"></div>

                    <h3 class="how-title">Delivery or Pick-up</h3>
                    <span class="how-subtitle">
                        Choose to have your order delivered directly to your doorstep
                        or pick it up at a convenient location near you
                    </span>
                    <img src="user/img/fast-delivery.png" alt="" class="how-img">
                </article>

                <article class="how-card">
                    <div class="how-bg"></div>

                    <h3 class="how-title">Enjoy Fresh Farm Produce</h3>
                    <span class="how-subtitle">
                        Receive your order and delight in the freshness of Farmers
                        Marketplace goodness. Cook, bake, and create delicious meals
                        with confidence
                    </span>
                    <img src="user/img/apple.png" alt="" class="how-img">
                </article>
            </div>
        </section>


        <!--=============== JOIN US ===============-->
        <section class="join section" id="join">
            <div class="join-container container grid">
                <div class="join-content grid">
                    <div class="join-data">
                        <h2 class="section-title">
                            App Coming Soon
                        </h2>

                        <p class="join-description">
                            Launching soon on Google Play Store and Apple Store
                        </p>

                    </div>
                    <img src="user/img/hero.jpg" alt="" class="join-bg">
                </div>
            </div>
        </section>
    </main>


    <!--=============== FOOTER ===============-->
    <footer class="footer" id="contact">
        <div class="footer-container container grid">
            <div>
                <a href="" class="footer-logo">
                    <img src="user/img/logo-alt.png" alt="">CITi24
                </a>

                <p class="footer-description">
                    Organic Bounty, Nurturing Wellness
                </p>
            </div>

            <div class="footer-data grid">
                <div>
                    <h3 class="footer-title">About</h3>

                    <ul class="footer-links">
                        <li><a href="#" class="footer-link">Home</a></li>
                        <li><a href="#why" class="footer-link">Why us</a></li>
                        <li><a href="#how" class="footer-link">How it works</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer-title">Contact</h3>

                    <ul class="footer-links">
                        <li><a href="" class="footer-link">+234 802 454 3272</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer-title">Get in Touch</h3>

                    <div class="footer-social">
                        <a href="" target="_blank" class="footer-social-link">
                            <i class="ri-facebook-circle-line"></i>
                        </a>
                        <a href="" target="_blank" class="footer-social-link">
                            <i class="ri-instagram-line"></i>
                        </a>
                        <a href="" target="_blank" class="footer-social-link">
                            <i class="ri-twitter-x-line"></i>
                        </a>
                        <a href="" target="_blank" class="footer-social-link">
                            <i class="ri-linkedin-line"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <span class="footer-copy">
            &#169; CITi24 2024. All Rights Reserved
        </span>

        <div class="tooltip">
            <small><i class="ri-information-line tooltip-text"></i>License</small>
            <i class="tooltip-tooltip">Images by Freepik, Icons from Flaticon</a></i>
        </div>
    </footer>


    <!--=============== SCROLL UP ===============-->
    {{-- <a href="#" class="scrollup" id="scroll-up">
        <i class="ri-arrow-up-s-line"></i>
    </a> --}}

    <!--=============== SCROLLREVEAL ===============-->
    <script src="user/js/scrollreveal.min.js"></script>

    <!--=============== JS ===============-->
    <script src="user/js/main.js"></script>
</body>

</html>

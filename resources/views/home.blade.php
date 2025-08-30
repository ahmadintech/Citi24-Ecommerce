@extends('layouts.shop_layout.master')
@section('content')
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .onboarding-container {
            background: linear-gradient(135deg, #023357 0%, #04578a 100%);
            min-height: 100vh;
            color: white;
            padding: 2rem;
            text-align: center;
            overflow: hidden;
        }

        .onboarding-slide {
            animation: fadeIn 0.8s ease-out forwards;
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
        }

        .onboarding-slide.active {
            opacity: 1;
        }

        .slide-icon {
            font-size: 4rem;
            margin-bottom: 2rem;
            color: #fff;
        }

        .slide-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .slide-description {
            font-size: 1.1rem;
            max-width: 300px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .cta-button {
            background-color: #fff;
            color: #023357;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
            margin-top: 2rem;
            text-decoration: none;
            display: inline-block;
        }

        .cta-button:hover {
            background-color: #f0f0f0;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .indicators {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.3);
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .indicator.active {
            background-color: white;
            width: 20px;
            border-radius: 5px;
        }
    </style>

    <div class="onboarding-container">
        <!-- Slide 1 -->
        <div class="onboarding-slide active" id="slide1">
            <div class="slide-icon">🚀</div>
            <h2 class="slide-title">Welcome to CITi24</h2>
            <p class="slide-description">Your premier destination for cutting-edge tech gadgets with lightning-fast 24-hour delivery.</p>
            <div class="indicators">
                <div class="indicator active"></div>
                <div class="indicator"></div>
                <div class="indicator"></div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="onboarding-slide" id="slide2">
            <div class="slide-icon">⚡</div>
            <h2 class="slide-title">24-Hour Delivery</h2>
            <p class="slide-description">Get the latest tech products delivered to your doorstep within 24 hours. We guarantee it!</p>
            <div class="indicators">
                <div class="indicator"></div>
                <div class="indicator active"></div>
                <div class="indicator"></div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="onboarding-slide" id="slide3">
            <div class="slide-icon">🔌</div>
            <h2 class="slide-title">Premium Tech Selection</h2>
            <p class="slide-description">Curated collection of the most innovative gadgets from trusted brands worldwide.</p>
            <div class="indicators">
                <div class="indicator"></div>
                <div class="indicator"></div>
                <div class="indicator active"></div>
            </div>
        </div>

        <a href="{{ route('shop.product') }}" class="cta-button">Explore Products</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.onboarding-slide');
            const indicators = document.querySelectorAll('.indicator');
            let currentSlide = 0;

            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove('active'));
                indicators.forEach(ind => ind.classList.remove('active'));

                slides[index].classList.add('active');
                indicators[index].classList.add('active');
                currentSlide = index;
            }

            // Auto-advance slides every 3 seconds
            setInterval(() => {
                let nextSlide = (currentSlide + 1) % slides.length;
                showSlide(nextSlide);
            }, 3000);

            // Click on indicators to navigate
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    showSlide(index);
                });
            });
        });
    </script>
@endsection

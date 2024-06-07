<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <style>
        footer {
            padding: 50px 0;
        }

        .footer-section {
            margin-bottom: 30px;
        }

        .heading {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .heading span {
            font-weight: 400;
        }

        .footer-info {
            margin-bottom: 10px;
        }

        .footer-links li {
            list-style: none;
            margin-bottom: 5px;
        }

        .footer-links a {
            color: #fff;
            text-decoration: none;
        }

        .tag-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .social-media-container {
            margin-top: 20px;
        }

        .facebook-iframe {
            width: 100%;
        }

        .map-container {
            width: 100%;
            height: 150px;
            overflow: hidden;
            border-radius: 10px;
            margin-top: 10px;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
</head>
<body>

<footer class="relative bg-gray-800" data-aos="fade-up" data-aos-duration="300">
    <section class="container grid grid-cols-4 gap-10 mx-auto text-white py-10">
        <div class="col-span-4 lg:col-span-1">
            <div class="footer-section">
                <h2 class="heading">BLOG <span>STORE</span></h2>
                <p class="footer-info"><i class="zmdi zmdi-pin"></i> Địa chỉ: 6 Trần Hưng Đạo, Thành phố Huế, Tỉnh Thừa Thiên Huế</p>
                <p class="footer-info"><i class="zmdi zmdi-smartphone-iphone"></i> Số điện thoại: 032 950 4405</p>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3826.09512049709!2d107.58471217460799!3d16.47072052856578!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3141a13e81ed38e1%3A0x78a3316dd9b76a08!2sBPO%20Tech%20Joint%20Stock%20Company!5e0!3m2!1svi!2s!4v1717136449695!5m2!1svi!2s" width="100%" height="150" style="border: 0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

        <div class="col-span-4 lg:col-span-1">
            <div class="footer-section">
                <h2 class="heading">Chính sách</h2>
                <ul class="footer-links">
                    <li><a href="/home1">Chính sách đổi trả</a></li>
                    <li><a href="/about1">Chính sách bảo mật</a></li>
                    <li><a href="/authors1">Chính sách đổi trả</a></li>
                    <li><a href="/membership1">Chính sách thanh tóan</a></li>
                </ul>
            </div>
        </div>


        <div class="col-span-4 lg:col-span-1">
            <div class="footer-section">
                <h2 class="heading">Tags</h2>
                <div class="tag-container">
                    <button class="default-button">Outdoors</button>
                    <button class="default-button">Health</button>
                    <button class="default-button">Environment</button>
                    <button class="default-button">Fitness</button>
                    <button class="default-button">Family</button>
                    <button class="default-button">Decor</button>
                    <button class="default-button">Beauty</button>
                    <button class="default-button">DIY</button>
                </div>
            </div>
        </div>

        <div class="col-span-4 lg:col-span-1">
            <div class="footer-section">
                <h2 class="heading">Social Media</h2>
                <div class="social-media-container">
                    <div class="facebook-iframe">
                        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fdecor8blog&tabs=timeline&width=250&height=150&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="150" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="curve curve-top"></div>

    <div class="p-t-40" style="display: flex; justify-content: center;">
        <div class="flex-c-m p-b-18">
            <a href="#" class="m-all-1" style="display: inline-block;">
                <img src="{{ asset('img/bg/icon-pay-01.png') }}" alt="ICON-PAY" style="display: block;" />
            </a>

            <a href="#" class="m-all-1" style="display: inline-block;">
                <img src="{{ asset('img/bg/icon-pay-02.png') }}" alt="ICON-PAY" style="display: block;" />
            </a>

            <a href="#" class="m-all-1" style="display: inline-block;">
                <img src="{{ asset('img/bg/icon-pay-03.png') }}" alt="ICON-PAY" style="display: block;" />
            </a>

            <a href="#" class="m-all-1" style="display: inline-block;">
                <img src="{{ asset('img/bg/icon-pay-04.png') }}" alt="ICON-PAY" style="display: block;" />
            </a>

            <a href="#" class="m-all-1" style="display: inline-block;">
                <img src="{{ asset('img/bg/icon-pay-05.png') }}" alt="ICON-PAY" style="display: block;" />
            </a>
        </div>
    </div>



</footer>

</body>
</html>

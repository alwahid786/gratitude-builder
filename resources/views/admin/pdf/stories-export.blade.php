@php
    function base64Image($relativePath)
    {
        $path = public_path($relativePath);
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return null;
    }

    $coverImage = base64Image('pdf-cover.png');
    $donImage = base64Image('assets/images/don-williams.png');
    $facebookIcon = base64Image('assets/images/facebook.png');
    $youtubeIcon = base64Image('assets/images/youtube.png');
    $instagramIcon = base64Image('assets/images/instagram.png');
    $twitterIcon = base64Image('assets/images/twitter.png');
    $podcastIcon = base64Image('assets/images/podcast.png');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gratitude Stories From Our Hearts</title>
    <style>
        @page {
            size: A4;
            margin: 2.5cm 2cm 3cm 2cm;

            @bottom-center {
                content: "Page " counter(page);
                font-family: 'Times New Roman', serif;
                font-size: 11px;
                color: #333;
            }
        }

        @page: first {
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', serif;
            font-size: 35px;
            line-height: 1.5;
            color: #000;
            background: white;
        }

        /* Page 1: Cover */
        .cover-page {
            padding-top: 170px;
            width: 100%;
            background: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            /* page-break-after: always; */

        }

        .contribute-title,
        .cover-title {
            font-size: 58px;
            font-weight: normal;
            color: #000;
            margin-bottom: 20px;
            font-family: 'Times New Roman', serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cover-subtitle {
            font-size: 40px;
            color: #000;
            margin-bottom: 20px;
            font-weight: normal;
            font-family: 'Times New Roman', serif;
            text-transform: uppercase;
        }

        .cover-by {
            font-size: 46px;
            ;
            color: #000;
            margin-bottom: 40px;
            font-weight: normal;
            font-family: 'Times New Roman', serif;
            text-transform: uppercase;
        }

        .cover-author {
            font-size: 38px;
            color: #000;
            margin-bottom: 60px;
            font-weight: normal;
            font-family: 'Times New Roman', serif;
            text-transform: uppercase;
        }

        .cover-heart-section {
            margin: 40px 0;
        }

        .cover-heart-section img {
            max-width: 100%;
            width: 400px;
            height: 600px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .heart-image {
            max-width: 200px;
            height: auto;
        }

        .cover-artwork-credit {
            font-size: 35px;
            color: #000;
            margin-top: 40px;
            margin-bottom: 20px;
            font-style: italic;
            font-family: 'Times New Roman', serif;
        }

        .cover-copyright {
            font-size: 33px;
            color: #000;
            font-family: 'Times New Roman', serif;
        }

        /* Page 3: Contributors */
        .contributors-page {
            page-break-before: always;
            padding: 80px 60px;
            text-align: center;
        }

        .contributors-title {
            font-size: 58px;
            color: #000;
            font-weight: 800;
            margin: 60px 0;
            font-family: 'Times New Roman', serif;
        }

        .contributors-grid {
            display: flex;
            justify-content: space-between;
            max-width: 500px;
            margin: 0 auto;
        }

        .contributor-left,
        .contributor-right {
            width: 45%;
        }

        .contributor-name {
            font-size: 35px;
            color: #000;
            margin-bottom: 20px;
            font-family: 'Times New Roman', serif;
            text-align: center;
            text-transform: capitalize;
        }

        /* Page 4: Copyright */
        .copyright-page {
            page-break-before: always;
            padding: 80px 60px;
        }

        .copyright-info {
            font-size: 35px;
            line-height: 1.4;
            color: #000;
            margin-bottom: 40px;
            font-family: 'Times New Roman', serif;
        }

        .contact-info {
            font-size: 35px;
            line-height: 1.8;
            color: #000;
            margin-bottom: 60px;
            font-family: 'Times New Roman', serif;
        }

        .copyright-text {
            font-size: 33px;
            line-height: 1.6;
            color: #000;
            text-align: justify;
            font-family: 'Times New Roman', serif;
        }

        /* Page 5: Testimonials */
        .testimonials-page {
            page-break-before: always;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            text-align: center;
            background: white;
            height: 100vh;
            width: 100vw;
            /* position: relative; */
            box-sizing: border-box;
        }

        .testimonials-title {
            font-size: 46px;
            ;
            color: #000;
            margin-bottom: 80px;
            font-weight: normal;
            font-family: 'Times New Roman', serif;
        }

        .testimonial {
            /* max-width: 70%;
            margin: 0 auto; */
            font-size: 38px;
            line-height: 1.8;
            color: #000;
            font-family: 'Times New Roman', serif;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
        }

        .testimonial-text {
            margin-bottom: 25px;
            text-align: center;
        }

        .testimonial-author {
            text-align: center;
            font-weight: normal;
            margin: 40px 0 15px 0;
            font-size: 46px;
            ;
            font-family: 'Times New Roman', serif;
        }

        .testimonial-title {
            text-align: center;
            font-size: 32px;
            ;
            color: #000;
            font-family: 'Times New Roman', serif;
            font-style: italic;
        }

        /* Page 6: Dedication */
        .dedication-page {
            page-break-before: always;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: white;
            margin-top: 500px;
            height: 100vh;
            width: 100vw;
            position: relative;
            box-sizing: border-box;
        }

        .dedication-title {
            font-size: 58px;
            font-weight: normal;
            color: #000;
            margin-bottom: 20px;
            font-family: 'Times New Roman', serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .dedication-content {
            max-width: 70%;
            margin: 0 auto;
            font-size: 38px;
            line-height: 1.8;
            color: #000;
            font-family: 'Times New Roman', serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .dedication-text {
            margin-bottom: 25px;
            text-align: center;
        }

        .dedication-author {
            text-align: center;
            font-weight: normal;
            margin-bottom: 10px;
            font-size: 46px;
            ;
            font-family: 'Times New Roman', serif;
        }

        .dedication-title {
            text-align: center;
            font-size: 33px;
            color: #000;
            font-family: 'Times New Roman', serif;
        }

        /* Table of Contents */
        .toc-page {
            page-break-before: always;
            padding: 80px 60px;
        }

        .toc-entry {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 8px;
            font-size: 35px;
            color: #000;
            font-family: 'Times New Roman', serif;
        }

        .toc-title-text {
            flex: 0 0 auto;
        }

        .toc-dots {
            flex: 1;
            border-bottom: 1px dotted #000;
            /* border-width:400px; */
            margin: 0 10px 3px 10px;
            height: 1px;
        }

        .toc-page-num {
            flex: 0 0 auto;
        }

        /* Story Pages */
        .story-page {
            page-break-before: always;
            padding: 60px;
        }

        .story-title {
            font-size: 38px;
            color: #000;
            margin-bottom: 30px;
            text-align: center;
            font-weight: bold;
            font-family: 'Times New Roman', serif;
        }

        .story-content {
            padding: 20px;
            font-size: 35px;
            line-height: 1.7;
            color: #000;
            text-align: justify;
            font-family: 'Times New Roman', serif;
            margin-bottom: 30px;
        }

        .story-content p {
            margin-bottom: 14px;
            text-indent: 0;
        }

        .story-author {
            text-align: center;
            font-size: 35px;
            color: #000;
            font-style: italic;
            font-family: 'Times New Roman', serif;
        }

        /* Conclusion Page */
        .conclusion-page {
            page-break-before: always;
            padding: 80px 60px;
        }

        .conclusion-title {
            font-size: 32px;
            color: #000;
            margin-bottom: 50px;
            text-align: center;
            font-weight: normal;
            font-family: 'Times New Roman', serif;
        }

        .conclusion-content {
            font-size: 35px;
            line-height: 1.6;
            color: #000;
            text-align: justify;
            font-family: 'Times New Roman', serif;
        }

        /* Page 238: About the Author */
        .about-author-page {
            page-break-before: always;
            padding: 60px 80px;
            text-align: center;
        }

        .about-author-title {
            font-size: 38px;
            color: #000;
            margin-bottom: 40px;
            font-weight: normal;
            font-family: 'Times New Roman', serif;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            display: inline-block;
        }

        .author-photo-section {
            margin: 40px 0;
            display: flex;
            justify-content: center;
        }

        .author-photo-placeholder {
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, #1e3a8a, #3b82f6);
            transform: rotate(45deg);
            margin: 20px 0;
        }

        .author-bio {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .author-bio p {
            font-size: 26px;
            line-height: 1.6;
            color: #000;
            margin-bottom: 20px;
            font-family: 'Times New Roman', serif;
        }

        /* Page 239: Contact Page */
        .contact-page {
            page-break-before: always;
            padding: 60px 80px;
            text-align: center;
            background-color: white;
        }

        .contact-title {
            font-size: 38px;
            color: #000;
            margin-bottom: 60px;
            font-weight: normal;
            font-family: 'Times New Roman', serif;
        }

        .contact-content p {
            font-size: 28px;
            ;
            color: #000;
            margin-bottom: 30px;
            font-family: 'Times New Roman', serif;
        }

        .contact-tagline {
            font-size: 30px;
            ;
            margin-bottom: 40px;
        }

        .contact-location {
            font-size: 30px;
            ;
            margin-bottom: 40px;
        }

        .contact-label {
            font-size: 28px;
            ;
            margin-bottom: 20px;
        }

        .contact-email {
            font-size: 26px;
            ;
            text-decoration: underline;
            color: #666;
            margin-bottom: 20px;
        }

        .contact-phone {
            font-size: 28px;
            ;
            margin-bottom: 40px;
        }

        .contact-social {
            font-size: 26px;
            ;
            margin-bottom: 30px;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icon {
            width: 60px;
            height: 60px;
            border-radius: 8px;
        }

        .social-icon img {
            width: 100%;
            height: 100%;
            border-radius: 8px;
            object-fit: cover;
        }

        .work-section {
            page-break-before: always;
            max-width: 600px;
            margin: 60px auto;
            padding: 20px;
            text-align: center;
        }

        .work-section h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .work-section p {
            font-size: 1rem;
            margin: 10px 0;
        }

        .contact-heading {
            font-weight: 600;
            margin-top: 30px;
        }

        .work-section a {
            color: #555;
            text-decoration: none;
        }

        .work-section a:hover {
            text-decoration: underline;
        }

        .social-icons {
            margin: 25px 0;
        }

        .social-icons img {
            width: 50px;
            height: 50px;
            margin: 0 10px;
            vertical-align: middle;
        }

        .author-section {
            page-break-before: always;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .divider {
            height: 4px;
            width: 80px;
            background-color: #111;
            margin: 0 auto 20px auto;
        }

        .author-image img {
            border-radius: 10px;
        }

        .author-description p {
            margin: 15px 0;
            line-height: 1.6;
            font-size: 1rem;
        }

        .pdf-whatwesay {
            page-break-before: always;
            padding: 20px 80px;
            background-color: white;
            text-align: left;
            font-family: 'Times New Roman', serif;
            font-size: 35px;
            line-height: 1.6;
            color: #000;
        }

        .section-title {
            font-size: 37pt;
            font-weight: bold;
            margin-bottom: 30px;
        }

        /* .quote-block {
            margin-bottom: 20px;
        } */

        .quote-line {
            margin-bottom: 16px;
            font-size:45px;
        }

        .quote-line:first-child {
            margin-top: 10px;
        }

        .quote-signature {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 30pt;
            color: #000;
        }

        .quote-credentials {
            text-align: center;
            font-size: 23.5pt;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <!-- Page 1: Cover -->
    <div class="cover-page">
        <h1 class="cover-title">GRATITUDE</h1>
        <h2 class="cover-subtitle">STORIES FROM OUR HEARTS</h2>
        <div class="cover-by">BY</div>
        <div class="cover-author">DON WILLIAMS AND FRIENDS</div>

        <div class="cover-heart-section">
            @if ($coverImage)
                <img src="{{ $coverImage }}" alt="The Gratitude Heart" class="heart-image" />
            @else
                <div
                    style="width: 200px; height: 250px; background: #8B4513; color: white; display: flex; align-items: center; justify-content: center; ">
                    ♥
                </div>
            @endif
        </div>

        <div class="cover-artwork-credit">"The Gratitude Heart"</div>
        <div class="cover-copyright">© @php
            echo date('Y');
        @endphp Leta Farnsworth https://letafarnsworthart.com</div>
    </div>

    <!-- Page 3: Contributors -->
    <div class="contributors-page">
        <h1 class="contributors-title">Thank You to My Co-Authors</h1>
        <div class="contributors-grid">
            @php
                $contributors = $usersWithStories->pluck('name')->toArray();
                $leftColumn = array_slice($contributors, 0, ceil(count($contributors) / 2));
                $rightColumn = array_slice($contributors, ceil(count($contributors) / 2));
            @endphp

            <div class="contributor-left">
                @foreach ($leftColumn as $contributor)
                    <div class="contributor-name">{{ $contributor }}</div>
                @endforeach
            </div>
            <div class="contributor-right">
                @foreach ($rightColumn as $contributor)
                    <div class="contributor-name">{{ $contributor }}</div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Page 4: Copyright -->
    <div class="copyright-page">
        <div class="copyright-info">
            <p>Copyright {{ now()->year }} Don Williams, Don Williams</p>
            <p>Global, Alliance PDMS, LLC</p>
            <p>All Rights Reserved</p>
        </div>

        <div class="contact-info">
            <p>Contact the Author at:</p>
            <p>1050 W. Pipeline Road, Suite 103</p>
            <p>Hurst, TX 76053-4730</p>
            <p>First Edition</p>
        </div>

        <div class="copyright-text">
            <p>All rights reserved. No part of this publication may be reproduced, distributed, or transmitted in any
                form or by any means, including photocopying, recording. Or other electronic or mechanical method(s) or
                by any information storage and retrieval systems without the prior written permission of the publisher
                and author, except in the case of brief quotations embodied in reviews and certain other non-commercial
                uses permitted by copyright law.</p>
        </div>
    </div>

    <!-- Page 5: Testimonials -->
    <div class="pdf-whatwesay">
        <h1 class="section-title">What Others are Saying...</h1>

        <div class="quote-block">
            <p class="quote-line">“Don Williams is living proof that actively practicing gratitude can change your life.
            </p>
            <p class="quote-line">Don has done an exceptional job of illustrating that the key to gratitude is
                disciplined practice and eloquently presents numerous stories that reinforce this message.</p>
            <p class="quote-line">Gratitude shifts you into a higher state and is the secret ingredient to living a more
                powerful life.</p>
            <p class="quote-line">Buy two copies of this book and give one to a friend.”</p>
        </div>

        <div class="quote-signature">Gina Mollicone-Long</div>
        <div class="quote-credentials">
            International Best-Selling Author, Creator of Greatness U
            and the ACME Coaching Framework
        </div>
    </div>
    <!-- Page 5: dedation -->
    <div class="dedication-page">
        <h2 class="cover-title">Dedication.</h2>

        <div class="dedication-content">
            <div class="dedication-text">"DT Every who has shared atory of the inexplicable beaty ad powerof Grattude
                wth another person -thank you for making the worl a better place.</div>
            <div class="dedication-title">This book is for you</div>
        </div>
    </div>
    <!-- Page 5: dedication -->
    <div class="dedication-page">
        
        <div class="dedication-content">
<div class="dedication-text" style="font-style: italic; font-size: 38pt; text-align: center;">
  “Maybe Stories are Just Data with Soul".
</div>

            <div class="dedication-title">Dr. Brene’ Brown</div>
        </div>
    </div>

    <!-- Table of Contents -->
    @php $pageNum = 25; @endphp
    <div class="toc-page">
        <h2 class="cover-title">Table of Contents .</h2>
        @foreach ($usersWithStories as $user)
            @foreach ($user->gratitudeStories as $story)
                <div class="toc-entry">
                    <span class="toc-title-text">{{ $story->title }}</span>
                    <div class="toc-dots"></div>
                    <span class="toc-page-num">{{ $pageNum++ }}</span>
                </div>
            @endforeach
        @endforeach

        @foreach ($storiesWithoutUser as $story)
            <div class="toc-entry">
                <span class="toc-title-text">{{ $story->title }}</span>
                <div class="toc-dots"></div>
                <span class="toc-page-num">{{ $pageNum++ }}</span>
            </div>
        @endforeach

        <div class="toc-entry">
            <span class="toc-title-text">Conclusion</span>
            <div class="toc-dots"></div>
            <span class="toc-page-num">{{ $pageNum + 10 }}</span>
        </div>

        <div class="toc-entry">
            <span class="toc-title-text">About the Author</span>
            <div class="toc-dots"></div>
            <span class="toc-page-num">{{ $pageNum + 12 }}</span>
        </div>
    </div>

    <!-- Story Pages -->
    @php $currentPage = 25; @endphp
    @foreach ($usersWithStories as $user)
        @foreach ($user->gratitudeStories as $story)
            <div class="story-page">
                <h3 class="story-title">{{ $story->title }}</h3>
                <div class="story-content">
                    {!! nl2br(e($story->generated_story)) !!}
                </div>
                <div class="story-author">{{ $user->name }}</div>
            </div>
        @endforeach
    @endforeach

    <!-- Anonymous Stories -->
    @foreach ($storiesWithoutUser as $story)
        <div class="story-page">
            <h3 class="story-title">{{ $story->title }}</h3>
            <div class="story-content">
                {!! nl2br(e($story->generated_story)) !!}
            </div>
            <div class="story-author">Anonymous Contributor</div>
        </div>
    @endforeach

    <!-- Conclusion -->
    <div class="conclusion-page">
        <h2 class="cover-title " style="text-align:center">Conclusion</h2>
        <div class="conclusion-content">
            <p>Thank you for joining us on this journey through gratitude. Each story in this collection represents a
                unique perspective on thankfulness, appreciation, and the power of recognizing the good in our lives.
            </p>

            <p>These stories were generated through our AI-powered platform, but the emotions, experiences, and
                gratitude they represent are deeply human. They remind us that no matter our circumstances, there is
                always something to be grateful for.</p>

            <p>We hope these stories inspire you to reflect on your own moments of gratitude and perhaps share your own
                story of thankfulness with others.</p>

            <p>Remember: Gratitude is not just an attitude—it's a way of life.</p>
        </div>
    </div>

    <!-- Page 238: About the Author -->
    <div class="author-section">
        <h2 class="cover-title">About the Author</h2>
        {{-- <div class="divider"></div> --}}
        <div class="author-image">
            @if ($donImage)
                <img src="{{ $donImage }}" alt="Don Williams" />
            @endif

        </div>
        <div class="author-description">
            <p class="dedication-text">Don Williams is a 35-year serial entrepreneur. He lives outside Dallas-Ft. Wort,
                Texas with the love of
                his life Leta and their Labrador Retrievers Maggie and Tess.</p>
            <p class="dedication-text">Don spends most of his time speaking, writing, and consulting.</p>
            <p class="dedication-text">Don is a sales, service, culture, and leadership experience expert. Don helps
                Companies from startups to
                the Fortune 100 do more business and do “better” business.</p>
        </div>
    </div>

    <div class="work-section">
        <h2 cass="cover-title">Want to Work with Don?</h2>
        <p class="dedication-text">Don Speaks, Consults and Facilitates</p>
        <p class="dedication-text"><strong>Anywhere on Earth!</strong></p>

        <p class="contact-heading">Contact Don at:</p>
        <p class="dedication-text"> <a href="mailto:don@donwilliamsglobal.com">don@donwilliamsglobal.com</a></p>
        <p class="dedication-text"><a href="tel:8008230403">800 823 0403</a></p>

        <p class="dedication-text">Or Nearly Everywhere on Social Media</p>

        <div class="social-icons">
            @if ($facebookIcon)
                <img src="{{ $facebookIcon }}" alt="Facebook" />
            @endif
            @if ($youtubeIcon)
                <img src="{{ $youtubeIcon }}" alt="YouTube" />
            @endif
            @if ($instagramIcon)
                <img src="{{ $instagramIcon }}" alt="Instagram" />
            @endif
            @if ($twitterIcon)
                <img src="{{ $twitterIcon }}" alt="Twitter" />
            @endif
            @if ($podcastIcon)
                <img src="{{ $podcastIcon }}" alt="Podcast" />
            @endif
        </div>


        {{-- <p class="page-number">Page 240</p> --}}
    </div>

</body>

</html>

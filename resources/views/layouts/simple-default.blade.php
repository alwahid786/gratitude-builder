<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Builder</title>
    @include('layouts.header')
    <link rel="stylesheet" href="{{asset('assets/css/new-layout.css')}}">
</head>

<body>
    <main>
        <section class="main-layout">
            <section class="sidebar">
                @include('layouts.book-layout.new-navbar')

            </section>
            <section class="content-container">
                <section class="content-header">
                    <div>
                        <h3>My Book</h3>
                        <span>Tuesday, Jan 27 2023</span>
                    </div>
                    <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_77_1458)">
                            <path
                                d="M32.9989 21.1615L30.5289 12.2747C29.8049 9.6712 28.2314 7.38444 26.0586 5.77788C23.8858 4.17132 21.2383 3.33715 18.537 3.40797C15.8356 3.4788 13.2355 4.45055 11.1499 6.16876C9.0642 7.88697 7.61274 10.253 7.02617 12.8909L5.11387 21.4904C4.90264 22.4406 4.90752 23.4261 5.12816 24.3742C5.3488 25.3223 5.77955 26.2087 6.38863 26.968C6.9977 27.7273 7.76954 28.3401 8.64715 28.7612C9.52477 29.1823 10.4858 29.4009 11.4592 29.4009H12.9074C13.2057 30.8702 14.0029 32.1913 15.1638 33.1402C16.3247 34.089 17.778 34.6074 19.2774 34.6074C20.7767 34.6074 22.23 34.089 23.3909 33.1402C24.5518 32.1913 25.349 30.8702 25.6474 29.4009H26.7368C27.7388 29.4009 28.7273 29.1693 29.6251 28.7241C30.5228 28.2789 31.3054 27.6322 31.9118 26.8345C32.5183 26.0368 32.932 25.1096 33.1208 24.1255C33.3096 23.1414 33.2683 22.127 33.0002 21.1615H32.9989ZM19.2774 32.0009C18.4736 31.9975 17.6905 31.746 17.0353 31.2806C16.38 30.8151 15.8845 30.1586 15.6166 29.4009H22.9382C22.6703 30.1586 22.1748 30.8151 21.5195 31.2806C20.8642 31.746 20.0811 31.9975 19.2774 32.0009ZM29.8412 25.2604C29.4789 25.7409 29.0096 26.1304 28.4705 26.3978C27.9313 26.6652 27.3373 26.8032 26.7355 26.8009H11.4592C10.8752 26.8008 10.2987 26.6695 9.77221 26.4168C9.24574 26.1641 8.78274 25.7964 8.41738 25.3408C8.05202 24.8853 7.79364 24.3535 7.6613 23.7847C7.52896 23.2159 7.52605 22.6246 7.65277 22.0546L9.56377 13.4538C10.0244 11.3818 11.1645 9.52335 12.8027 8.17375C14.4409 6.82415 16.4832 6.06089 18.605 6.0053C20.7268 5.94972 22.8063 6.605 24.5129 7.86698C26.2195 9.12895 27.4553 10.9252 28.0238 12.9702L30.4938 21.857C30.657 22.4359 30.683 23.045 30.5697 23.6358C30.4564 24.2266 30.207 24.7828 29.8412 25.2604Z"
                                fill="black" />
                            <rect x="20.8359" y="3.40015" width="14.04" height="14.04" rx="7.02" fill="#FE3A30" />
                        </g>
                        <defs>
                            <clipPath id="clip0_77_1458">
                                <rect width="31.2" height="31.2" fill="white" transform="translate(3.67773 3.40015)" />
                            </clipPath>
                        </defs>
                    </svg>

                </section>
                <section class="main-content">
                    @yield('content')
                </section>
            </section>

        </section>
    </main>



    @include('layouts.footer')

    <!-- Modal -->
    <div class="modal fade" id="myAIReviewModal" tabindex="-1" role="dialog" aria-labelledby="myAIReviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myAIReviewModalLabel">AI Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>

</body>

</html>
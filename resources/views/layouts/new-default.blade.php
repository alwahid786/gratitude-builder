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
<style>
.sidebar {
    height: 100vh;
    position: sticky;
    top: 0;
    overflow-y: auto;
}
.sidebar::-webkit-scrollbar {
    display: none;
}
</style>
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
                        <span>{{date('D, M d Y')}}</span>
                    </div>
                </section>
                <section class="main-content">
                    @include('layouts.book-layout.progress')
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
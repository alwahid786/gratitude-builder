<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gratitude Builder</title>
    @include('layouts.header')
</head>

<body>
     {{-- @include('layouts.book-layout.navbar') --}}
    {{-- @include('layouts.book-layout.progress')--}} 

    @yield('content')
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
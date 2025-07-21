<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
<style>
    .disableTab {
        color: inherit !important;
        text-decoration: none !important;
        pointer-events: none !important;
    }

    .filled-circle {
        margin-left: 10%;
    }

    .side-bar .menu .item a {
        color: #fff;
        font-size: 16px;
        text-decoration: none;
        display: block;
        padding: 5px 10px 5px 18px;
        line-height: 30px;
    }

    .filled-circle {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
    }

    .logoImg {
        max-width: 250px;
        width: 80% !important;
        border: none;
        object-fit: contain;
        border-radius: none !important;
    }

    img {
        border-radius: 0px !important;
    }

    .item a i {
        width: 8%;

    }

    .item a span {
        width: 92%;
    }

    .side-bar .menu .item .sub-menu a {
        padding-left: 65px !important;
    }
</style>
<?php
$sections = bookProgress()['sections'];
?>
<div class="side-bar">

    <div class="menu">
        <div class=" text-center text-white"
            style="height: 85px; display:flex; font-size:30px; justify-content:center; align-items:center"><img
                class="logoImg m-0" style="border-radius:none !important;" src="{{asset('assets/images/LOGO_SVG.svg')}}"
                alt=""></div>
        <div class="item position-relative text-white" style="cursor:default; padding: 0px 10px; ">Welcome</div>
        <div class="item position-relative text-white" style="cursor:default; font-size:18px;padding:  0px 10px; ">
            <strong style="font-family: 'Roboto', sans-serif !important;">My Co-Author Stories</strong>
        </div>
        <div class="item position-relative">
            <a href="{{url('/welcome?url=story')}}"><i class="fas fa-microphone"></i><span>Story Telling</span>
            </a>
        </div>
        <div class="item position-relative">
            <a href="{{url('/welcome?url=gratitude')}}"><i class="fas fa-comment-alt"></i>My Gratitude Story
            </a>
        </div>
        <div class="item position-relative">
            <a href="{{url('/welcome?url=romance-customer')}}"
                style="line-height: 25px; padding-top: 5px;padding-bottom: 5px;"><i class="fas fa-scroll"></i>My
                Romancing Your <span style="margin-left: 30px;">Customer Story</span>
            </a>
        </div>
        @if(auth()->user() != null)
        @if(auth()->user()->type === 1)
        <hr>
        <div class="item position-relative text-white mt-2" style="cursor:default; font-size:18px;padding:  0px 10px; ">
            <strong style="font-family: 'Roboto', sans-serif !important;">Administration</strong>
        </div>
        <div class="item position-relative">
            <a href="{{route('allUsers')}}" style="line-height: 25px; padding-top: 5px;padding-bottom: 5px;"><i
                    class="fas fa-users"></i>All Users
            </a>
        </div>
        <div class="item position-relative">
            <a href="{{route('TokenLimits')}}" style="line-height: 25px; padding-top: 5px;padding-bottom: 5px;"><i {{--
                    <a href="{{route('TokenLimits')}}"
                    style="line-height: 25px; padding-top: 5px;padding-bottom: 5px;"><i --}}
                        class="fas fa-cog"></i>AI Management
            </a>
        </div>
        @endif
        <hr>
        <div class="item position-relative text-white mt-2" style="cursor:default; font-size:18px;padding:  0px 10px; ">
            <strong style="font-family: 'Roboto', sans-serif !important;">My Book</strong>
        </div>
        <div class="item position-relative">
            <a href="{{route('avatar')}}" class="@if(!$sections['avatar']) disableTab @endif"><i
                    class="fas fa-book"></i>Avatar
                @if($sections['avatar'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a>
        </div>
        <div class="item"><a href="{{route('bookTitleDetail')}}"
                class="@if(!$sections['book_title']) disableTab @endif"><i class="fas fa-heading"></i>Book Title
                @if($sections['book_title'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item">
            <a href="{{route('outline')}}" class="@if(!$sections['outline']) disableTab @endif sub-btn"><i
                    class="fas fa-file-alt"></i>Outline
                @if($sections['outline'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a>
        </div>
        <div class="item" style="display: none"><a href="{{route('coverArt')}}"
                class="@if(!$sections['cover_art']) disableTab @endif"><i class="fas fa-images"></i>Cover Art
                @if($sections['cover_art'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item"><a href="{{route('insideCover')}}"
                class="@if(!$sections['inside_cover']) disableTab @endif"><i class="fas fa-book-open"></i>Inside Cover
                @if($sections['inside_cover'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item"><a href="{{route('copyright')}}" class="@if(!$sections['copy_right']) disableTab @endif"><i
                    class="fas fa-copyright"></i>Copyright
                @if($sections['copy_right'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item"><a href="{{route('praise')}}" class="@if(!$sections['praise']) disableTab @endif"><i
                    class="fas fa-thumbs-up"></i>Praise
                @if($sections['praise'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item"><a href="{{route('dedication')}}" class="@if(!$sections['dedication']) disableTab @endif"><i
                    class="fas fa-heart"></i>Dedication
                @if($sections['dedication'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item"><a href="{{route('howToUse')}}" class="@if(!$sections['how_to_use']) disableTab @endif"><i
                    class="fas fa-question-circle"></i>How To Use
                @if($sections['how_to_use'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item"><a href="{{route('forward')}}" class="@if(!$sections['forword']) disableTab @endif"><i
                    class="fas fa-share"></i>Forward
                @if($sections['forword'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item">
            <a class="sub-btn @if(!$sections['table_of_content']) disableTab @endif"><i class="fas fa-list"></i>Chapters
                <!-- @if($sections['table_of_content'])<i class="fas fa-check-circle filled-circle"></i>@endif -->
            </a>
            <div class="sub-menu">
                @foreach(outlines() as $outline)
                <?php
                                                $id = $sections['sub_outline_' . $outline['order']];
                                                ?>
                <a href="{{route('content', ['id'=> $outline['id']] )}}" data-class="{{$outline['order']}}"
                    class="sub-item position-relative"><span class="d-block" style="width:82%;">
                        {{$outline['outline_name']}}</span>

                    @if($id)<i class="fas fa-check-circle filled-circle"></i>@endif
                </a>
                @endforeach
            </div>
        </div>
        <div class="item"><a href="{{route('conclusion')}}" class="@if(!$sections['conclusion']) disableTab @endif"><i
                    class="fas fa-flag-checkered"></i>Conclusion
                @if($sections['conclusion'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item"><a href="{{route('workWithUs')}}" class="@if(!$sections['work_with_us']) disableTab @endif"><i
                    class="fas fa-handshake"></i>Work with Me
                @if($sections['work_with_us'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item"><a href="{{route('about')}}" class="@if(!$sections['about']) disableTab @endif"><i
                    class="fas fa-user"></i>About The Author
                @if($sections['about'])<i class="fas fa-check-circle filled-circle"></i>@endif
            </a></div>
        <div class="item"><a href="{{route('congratulations')}}" class="@if(!$sections['about']) disableTab @endif"><i
                    class="fas fa-award"></i>CONGRATULATIONS
            </a>
        </div>
        @endif
    </div>
</div>
<!-- @if($sections['table_of_content'])
<script>
     $('.sub-menu').slideToggle();
</script>
@endif -->
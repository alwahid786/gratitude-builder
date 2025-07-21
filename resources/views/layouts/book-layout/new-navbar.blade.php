<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/new-navbar.css')}}">
<?php
$sections = bookProgress()['sections'];
?>
<div class="sidebar-wrapper">
    <i class="mdi mdi-menu menu-toggle"></i>
    <img src="{{asset('assets/images/blue-logo.png')}}" class="side-logo" alt="blue logo">
    <div>
        <h5>My Co-Author Stories</h5>
        <ul class="story-list">
            <li>
                <a href="{{url('/welcome')}}">
                    <img src="{{asset('assets/images/book-icon.svg')}}" alt="book-icon">
                    Story Telling
                </a>
            </li>
            <li>
                <a href="{{url('/welcome?gratitude')}}">
                    <img src="{{asset('assets/images/book-icon.svg')}}" alt="book-icon">
                    My Gratitude Story
                </a>
            </li>
            <li>
                <a href="{{url('/welcome?romance')}}">
                    <img src="{{asset('assets/images/book-icon.svg')}}" alt="book-icon">
                    Romance Story
                </a>
            </li>
        </ul>

    </div>
    @if(auth()->user()->email === 'don@donwilliamsglobal.com')
    <hr>
    <div class="adminstration">
        <h5>Adminstration</h5>
        <ul class="admin-list">
            <li>
                <img src="{{asset('assets/images/users.svg')}}" alt="book-icon">
                <a href="{{route('allUsers')}}">
                    All Users
                </a>
            </li>
            <li>
                <img src="{{asset('assets/images/setting.svg')}}" alt="book-icon">
                <a href="{{route('TokenLimits')}}">
                   AI Management 
                </a>
            </li>

        </ul>
    </div>
    @endif
    <hr>
    <div>
        <h5>My Book</h5>
        <ul class="book-list">

        </ul>
    </div>
    <div class="profile">
        <div class="profile-data">
            @if(auth()->user()->image != null)
            <img src="{{ asset('uploads/' . auth()->user()->image) }}" class="" alt="">
            @else
            <img src="{{asset('assets/images/logo.jpeg')}}" alt="" />
            @endif
            <div>
                <h5>{{auth()->user()->name}}</h5>
                <span>{{auth()->user()->email}}</span>
            </div>
        </div>
        <i class="mdi mdi-dots-vertical">
            <div>
                <a href="/welcome">Welcome</a>
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </i>
    </div>

</div>
<?php
$outline = outlines();
?>
<script>
    let contentRoute = "{{ route('content', ['id' => '__ID__']) }}";
let sections = @json($sections);
let outlines = @json($outline);

// Define sub-menu HTML
let subMenuHTML = `<div class="active sub-menu" ></div>`;

let dataArray = [{
        "key": "avatar",
        "title": "Avatar",
        "url": "{{route('avatar')}}"
    },
    {
        "key": "book_title",
        "title": "Book Title",
        "url": "{{route('bookTitle')}}"
    },
    {
        "key": "outline",
        "title": "Outline",
        "url": "{{route('outline')}}"
    },
    {
        "key": "inside_cover",
        "title": "Inside Cover",
        "url": "{{route('insideCover')}}"
    },
    {
        "key": "copy_right",
        "title": "Copyright",
        "url": "{{route('copyright')}}"
    },
    {
        "key": "praise",
        "title": "Praise",
        "url": "{{route('praise')}}"
    },
    {
        "key": "dedication",
        "title": "Dedication",
        "url": "{{route('dedication')}}"
    },
    {
        "key": "how_to_use",
        "title": "How to Use",
        "url": "{{route('howToUse')}}"
    },
    {
        "key": "forword",
        "title": "Forward",
        "url": "{{route('forward')}}"
    },
    {
        "key": "table_of_content",
        "title": "Chapters",
        "hasSubMenu": true
    },
    {
        "key": "conclusion",
        "title": "Conclusion",
        "url": "{{route('conclusion')}}"
    },
    {
        "key": "work_with_us",
        "title": "Work with Me",
        "url": "{{route('workWithUs')}}"
    },
    {
        "key": "about",
        "title": "About The Author",
        "url": "{{route('about')}}"
    },
    {
        "key": "congratulations",
        "title": "Congratulations",
        "url": "{{route('congratulations')}}",
    }
];

let bookList = document.querySelector('.book-list');
bookList.innerHTML = "";

dataArray.forEach((data) => {
    let disable = sections[data.key] ? "" : "disableTab";
    let isActive = data.url == window.location.pathname ? "active-nav" : "";

    let classList = `${data.key}-list ${isActive} ${disable}`;
    if (data.key === "congratulations" && sections["about"]) {
        classList = `${data.key}-list`;
    }
    let downArrow = data.hasSubMenu ? `<i class="mdi mdi-chevron-down sub-menu-arrow"></i>` : "";
    let linkToNav = data.url ? `href="${data.url}"` : "";
    let listItem = `
    <a ${linkToNav} class="${classList.trim()} my-book-item">
        <li>
            <img src="{{asset('assets/images/active-checkbox.svg')}}" alt="active checkbox" class="active">
            <img src="{{asset('assets/images/disable-checkbox.svg')}}" alt="disabled checkbox" class="disable">
            <img src="{{asset('assets/images/complete-checkbox.svg')}}" alt="completed checkbox" class="complete">
            ${data.title}

        </li>
${downArrow}
    </a>
    `;

    bookList.insertAdjacentHTML('beforeend', listItem);

    if (data.hasSubMenu) {
        let subMenu = document.createElement("div");
        subMenu.className = "sub-menui";
        subMenu.style.display = "flex";
        subMenu.style.flexDirection = "column";

        outlines.forEach((outline) => {
            let contentUrl = contentRoute.replace('__ID__', outline.id);
            let isActive = window.location.pathname === new URL(contentUrl, window.location.origin).pathname ? "active" : "";
            let listItem = `<a class="${isActive}" href="${contentUrl}">${outline.outline_name}</a>`;
            subMenu.insertAdjacentHTML('beforeend', listItem);
        });

        bookList.insertAdjacentElement('beforeend', subMenu);
    }
});
if (window.location.pathname.includes('/content/%24')) {
    bookList.classList.add('active');
}
let chapterBtn = document.querySelector('.table_of_content-list');
chapterBtn.addEventListener('click', () => {
    bookList.classList.toggle('active');
})


let toggleBtn = document.querySelector('.menu-toggle');
let sidebar = document.querySelector('.sidebar');
let isOpen = true;
toggleBtn.addEventListener('click', () => {
    if (isOpen) {
        sidebar.classList.add('close');
        toggleBtn.classList.remove('mdi-close');
        toggleBtn.classList.add('mdi-menu');
        isOpen = false;
    } else {
        sidebar.classList.remove('close');
        toggleBtn.classList.remove('mdi-menu');
        toggleBtn.classList.add('mdi-close');
        isOpen = true;
    }
});

// Set initial icon state on page load
if (sidebar.classList.contains('close')) {
    toggleBtn.classList.remove('mdi-close');
    toggleBtn.classList.add('mdi-menu');
    isOpen = false;
} else {
    toggleBtn.classList.remove('mdi-menu');
    toggleBtn.classList.add('mdi-close');
    isOpen = true;
}

let optionMenu = document.querySelector('.mdi-dots-vertical');
let menuList = document.querySelector('.mdi-dots-vertical div');
let optionOpen = false;
optionMenu.addEventListener('click', () => {
    if (optionOpen) {
        menuList.style.display = 'none';
        optionOpen = false;
    } else {
        menuList.style.display = 'flex';
        optionOpen = true;
    }
});
</script>
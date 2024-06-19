<nav class="flex-div">
    <div class="nav-left flex-div">
        <a href="{{route('home')}}"><img src="{{ URL::asset('home_assets/images/logo1.png') }}" class="logo" alt="" srcset=""></a>
    </div>
    <div class="nav-middle flex-div">
        <div class="search-box flex-div">
            <input type="text" id="searchInput" placeholder="Search.." onkeydown="handleSearchKey(event)">
            <img src="{{ URL::asset('home_assets/images/search.png') }}" alt="" srcset="" onclick="filterVideosBySearch()">
        </div>
    </div>
    <div class="nav-right flex-div">

    </div>
</nav>
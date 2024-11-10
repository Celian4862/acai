<nav class="sticky-top bg-white p-3 text-center">
    <a href="/" style="margin: 0 2% 0 0;">
        <img src="/images/logo.png" alt="logo" width="55px" class="img-fluid" />
    </a>
    <div class="d-inline-flex">
        <ul class="p-0 m-0">
            <?php if (session()->has('logged_in') && session()->get('logged_in') === true) : ?>
                <li class="d-inline-block mx-4"><a href="/accounts/dashboard">Dashboard</a></li>
            <?php else : ?>
                <li class="d-inline-block mx-4"><a href="/about-us">About Us</a></li>
                <li class="d-inline-block mx-4"><a href="/support">Support</a></li>
            <?php endif ?>
        </ul>
        <form id="search" class="px-5">
            <input id="search-bar" name="search-bar" type="text" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
        <ul class="p-0 m-0">
            <?php if (session()->has('logged_in') && session()->get('logged_in') === true) : ?>
                <li class="d-inline-block mx-4"><a href="/accounts/settings">Settings</a></li>
                <li class="d-inline-block mx-4"><a href="/accounts/logout">Log out</a></li>
            <?php else : ?>
                <li class="d-inline-block mx-4"><a href="/accounts/signup">Sign up</a></li>
                <li class="d-inline-block mx-4"><a href="/accounts/login">Log in</a></li>
            <?php endif ?>
        </ul>
    </div>
</nav>
<!-- Navigation -->
<nav>
    <ul class="navigation-menu">
        <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
        <li class="{{ request()->is('reports*') ? 'active' : '' }}"><a href="{{ route('reports') }}">Reports</a></li>
        <!-- Add more navigation links as needed -->
    </ul>
</nav>
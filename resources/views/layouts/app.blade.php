@include('inc.head')

@auth
	@include('inc.sidebar')
@endauth

@yield('content')

@include('inc.footer')
@include('inc.head')

@auth
	@if(Request::route()->getPrefix() == '/admin' || Request::route()->getName() == 'home')
		@include('inc.sidebar')
	@endif
@endauth

@yield('content')

@include('inc.footer')
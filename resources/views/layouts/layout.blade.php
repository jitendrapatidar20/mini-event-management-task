<!DOCTYPE html>
<html lang="en">
@include('includes.head')
<body>
    @include('includes.header')
    @yield('content')
    @include('includes.footer')
	<div class="loading" style="display:none; z-index: 9999;">Loading</div>
    @include('includes.script') 
</body>
</html>

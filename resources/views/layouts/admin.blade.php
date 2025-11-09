<!DOCTYPE html>
<html lang="en">
@include('includes.admin.head')
<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
    @include('includes.admin.header')
    @include('includes.admin.sidebar')
    @yield('content')
    @include('includes.admin.footer')
	<div class="loading" style="display:none; z-index: 9999;">Loading</div>
    @include('includes.admin.script') 
    @include('includes.admin.errorMsg') 
    </div>
</body>
</html>

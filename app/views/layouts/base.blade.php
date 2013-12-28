<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>WPA9 - Project Manager</title>
	@section('head')
		{{ HTML::style('css/bootstrap.css') }}
		{{ HTML::style('css/datepicker.css') }}
		{{ HTML::style('css/style.css') }}

		{{ HTML::script('js/jquery-2.0.3.js') }}
		{{ HTML::script('js/bootstrap.js') }}
		{{ HTML::script('js/bootstrap-datepicker.js') }}
		{{ HTML::script('js/bootstrap-alert.js') }}
		{{ HTML::script('js/script.js') }}

	@show
</head>
<body>
	@yield('body')
	@include('partials.footer')
</body>
</html>
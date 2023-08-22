<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Future Care and Helping Hands Insurance Service</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" href="/images/logo.png" type="image/x-icon">

	@vite('resources/css/app.css')

  <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css">
  <link rel="stylesheet" href="/flat-top.css" >
</head>

<body class="sidebar-mini">
	<div id="app">

    <div id="loading-bg">
      <div class="loading-bg">
        <img src="/images/logo.png" style="width: 140px; height: auto; z-index: 10"/>
      </div>

      <div class="loading-bg" style="margin-top: 0px; margin-bottom: 0px">
        <h3>Future Care & Helping Hands Insurance Service</h3>
      </div>
      <div class="loading-bg" style="margin-top: 0px">
        <h3>Development {{ env('VITE_VER') }}</h3>
      </div>
    </div>

  </div>

	@vite('resources/js/app.ts')
</body>
</html>

<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: http://ogp.me/ns#">
<head>

    <meta charset="utf-8" lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Currencies</title>

    <meta name="description" content="Currencies" />
    <meta name="keywords" content="currency, exchange currency, dollars" />
    <meta name="author" content="Alexander" />

    <meta property="og:title"       content="Currencies" />
    <meta property="og:description" content="Currencies for differents countries" />
    <meta property="og:type"        content="website" />
    <meta property="og:url"         content="http://currencies.loc" />
    <meta property="og:site_name"   content="currencies" />
    <meta property="og:image"       content="<?= config('app.url').'/img/currencies.png' ?>" />

    <link rel="shortcut icon" href="<?=config('app.url')?>/favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('/css/bootstrap4/css/bootstrap.min.css?'.time()) }}" />
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('/css/fontawesome5/css/all.css?'.time()) }}" />
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('/css/jquery-ui.css?'.time()) }}" />

    <script type="text/javascript" src='<?=config('app.url')?>/js/jquery-3.4.0.min.js'></script>
    <script type="text/javascript" src='<?=config('app.url')?>/css/bootstrap4/js/bootstrap.min.js'></script>
    <script type="text/javascript" src="<?=config('app.url')?>/js/jquery-ui.js"></script>
</head>
<body>
<main role="main">

    <div class="container">
        <h1>CURRENCIES</h1>

        @include('partials.flash')
        @yield('content')
    </div>

</main>
</body>
</html>

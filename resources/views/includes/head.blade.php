<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title><?php echo isset($title)?$title:'' ?></title>
    <meta name="title" content="<?php echo isset($meta_title)?$meta_title:'' ?>"/>
    <meta name="keywords" content="<?php echo isset($meta_keyword)?$meta_keyword:'' ?>" />
    <meta name="description" content="<?php echo isset($meta_description)?$meta_description:'' ?>" />
    <link rel="shortcut icon" href="<?= asset('public/favicon.ico') ?>" type="image/x-icon" /> 
 
    <!-- New Css -->
    <link rel="stylesheet" href="{{asset('assets/lobibox/css/lobibox.css')}}">    
    <link rel="stylesheet" href="{{asset('assets/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link href="{{asset('assets/css/password-policy.css')}}" rel="stylesheet" type="text/css" />
</head>

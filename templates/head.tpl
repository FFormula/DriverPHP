<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
        <link href="/css/driverstyle.css" rel="stylesheet">
    </head>
    <body>
{if $user.id}
        {include file="menu.user.tpl"}
{else}
        {include file="menu.demo.tpl"}
{/if}
    <div class="container" style="height: 100px;">
    </div>
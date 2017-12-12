<?php
/**
 * User: suraj
 * Date: 10/7/17
 * Time: 3:09 PM
 */
?>


<html>
<head>
    <title>{{ isset($title) ? $title : 'Laravel Admin' }}</title>
    <style type="text/css">
        .navbar .navigation {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding: auto 50px;
            display: table;
            width: 100%;
            background-color: #fff;
        }

        .navbar .navigation .nav {
            float: left;
            list-style: none;
            /*padding: 20px;*/
        }

        .navbar .navigation .nav a {
            display: block;
            padding: 20px;
            text-decoration: none;
        }

        .navbar .navigation .nav a:hover {
            background-color: #ddd;
            text-decoration: none;
        }

        .navbar .navigation .nav ul {
            display: none;
            position: absolute;
            background-color: #fff;
            /*margin-top: 20px;*/
        }

        .navbar .navigation .nav:hover ul {
            display: table;
            border-top: none;
            border: 1px solid #ddd;
            /*padding: 10px;*/
            padding: 0;
        }

        .navbar .navigation .nav ul li {
            /*padding: 10px;*/
            list-style: none;
        }

        .text-center {
            text-align: center;
        }

        form div {
            margin-top: 10px;
        }

        form label {
            display: block;
        }

        form input, form textarea {
            padding: 5px;
            width: 100%;
        }

        form button {
            padding: 3px 5px;
        }
    </style>
</head>
<body>
<div class="navbar">
    @if(isset($menus) && count($menus))
        <ul class="navigation">
            @foreach($menus as $menu)
                @if($menu->entity == 'product')
                    <li class="nav">
                        <a href="{{ url($menu->menu_link) }}" target="{{ $menu->link_type == 'external' ? '_blank' : '_self' }}">{{ $menu->menu_title }}</a>
                        @if($products)
                            <ul>
                                @foreach($products as $product)
                                    <li>
                                        <a href="#">{{ $product->product_title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @elseif($menu->entity == 'service')
                    <li class="nav">
                        <a href="{{ url($menu->menu_link) }}" target="{{ $menu->link_type == 'external' ? '_blank' : '_self' }}">{{ $menu->menu_title }}</a>
                        @if($services)
                            <ul>
                                @foreach($services as $service)
                                    <li>
                                        <a href="#">{{ $service->service_title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @elseif($menu->entity == 'download')
                    <li class="nav">
                        <a href="{{ url($menu->menu_link) }}" target="{{ $menu->link_type == 'external' ? '_blank' : '_self' }}">{{ $menu->menu_title }}</a>
                        @if($downloads)
                            <ul>
                                @foreach($downloads as $download)
                                    <li>
                                        <a href="{{ $download->download_file != '' ?  url('uploads/download/' . $download->download_file) : ($download->download_link != '' ? url($download->download_link) : '#') }}">{{ $download->download_title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @elseif($menu->childMenus->count() > 0)
                    <li class="nav">
                        <a href="{{ url($menu->menu_link) }}" target="{{ $menu->link_type == 'external' ? '_blank' : '_self' }}">{{ $menu->menu_title }}</a>
                        @if($menu->childMenus)
                            <ul>
                                @foreach($menu->childMenus as $childMenu)
                                    <li>
                                        <a href="{{ $childMenu->page ? route('page', $childMenu->page->slug) : url($childMenu->menu_link) }}" target="{{ $childMenu->link_type == 'external' ? '_blank' : '_self' }}">{{ $childMenu->menu_title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @elseif($menu->page)
                    <li class="nav">
                        <a href="{{ route('page', $menu->page->slug) }}" target="{{ $menu->link_type == 'external' ? '_blank' : '_self' }}">{{ $menu->menu_title }}</a>
                    </li>
                @else
                    <li class="nav">
                        <a href="{{ url($menu->menu_link) }}" target="{{ $menu->link_type == 'external' ? '_blank' : '_self' }}">{{ $menu->menu_title }}</a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif
</div>

@if(isset($home_page) && !empty($home_page))
    @include('home.' . $home_page)
@else
    <h1>Integrate Your Frontend</h1>
@endif
</body>
</html>

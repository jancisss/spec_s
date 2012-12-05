<!DOCTYPE HTML>
<html>

    <head>
        <title>simplestyle_7</title>
        <meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine&amp;v1" />
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css" />
        <script src="http://d3js.org/d3.v3.min.js"></script>
    </head>

    <body>
        <div id="main">
            <div id="header">
                <div id="logo">
                    <h1>Specseminārs</h1>

                </div>
                <div id="menubar">
                    <ul id="menu">
                        <!-- put class="current" in the li tag for the selected page - to highlight which page you're on -->
                        <li <?php
if (isset($active_page))
    if ($active_page == 'c') {
       ?> class="current" <?php } ?> > 
                            <a href="<?php echo base_url('/contest'); ?>">Iepirkumi</a></li>
                        <li<?php
                    if (isset($active_page))
                        if ($active_page == 'i') {
       ?> class="current" <?php } ?> >
<a href="<?php echo base_url('/inst'); ?>">Institūcijas</a></li>
                        <li><a href="page.html">A Page</a></li>
                        <li><a href="another_page.html">Another Page</a></li>

                    </ul>
                </div>
            </div>
            <div id="site_content">
<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<title>Specseminārs</title>
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url(); ?>css/bootstrap-responsive.min.css" rel="stylesheet">
	 <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" media="screen">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script>
  </head>
  <body>
	<div class="navbar navbar-static-top">
        <div class="navbar-inner">            
            <a class="brand" href="<?php echo base_url();?>">Specseminārs</a>            
            <ul class="nav"><?if(!isset($active_page)) $active_page = '';?>
              <li class="<?php if($active_page == 'c') 
					  echo 'active';?>"><a href="<?php 
					  echo base_url('/contest'); ?>">Iepirkumi</a></li>
              <li class="<?php if($active_page == 'i') 
					  echo 'active';?>"><a href="<?php 
					  echo base_url('/inst'); ?>">Institūcijas</a></li>
				  <li class="<?php if($active_page == 'budget') 
					  echo 'active';?>"><a href="<?php 
					  echo base_url('/budget'); ?>">Budžets</a></li>
            </ul>
            
        </div>
    </div>
	<div class=" center_elem">
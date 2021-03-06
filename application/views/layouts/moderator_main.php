<!DOCTYPE html>
<html lang="en">
    <head>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PAKODI</title>
        <link type="text/css" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo base_url(); ?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link type="text/css" href="<?php echo base_url(); ?>css/theme.css" rel="stylesheet">
       <link type="text/css" href="<?php echo base_url(); ?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url(); ?>images/icons/css/font-awesome.css" rel="stylesheet">
        <link type="text/css" href='<?php echo base_url(); ?>css/fonts.css' rel='stylesheet'>
		
		<link type="text/css" href='<?php echo base_url(); ?>bootstrap/css/bootstrap-datetimepicker-standalone.css' rel='stylesheet'>
		<link type="text/css" href='<?php echo base_url(); ?>bootstrap/css/bootstrap-datetimepicker.min.css' rel='stylesheet'>
        
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <style>
        .pakodi{
            background: #E01E1C;
            text-align: center;
            color: white;
        }
        a{
            padding-left: 2px;
            padding-right: 2px;
            margin-top: -3px;
        }
		.iconred{
		color: red;			
		}
		.icongreen{
		color: green;			
		}
		.col1{
		float:left;width: 4%;  padding-left:15px;	
		}
		.col2{
		float:left;width: 28%;	
		}
		.col3{
		float:left;width: 35%;	
		}
        
    </style>
    <style>
.overlay {
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:105%;
    z-index:1000;
    background-color:#313131;
    filter:alpha(opacity=70);
    -moz-opacity:0.5;
    -khtml-opacity: 0.5;
    opacity: 0.5;
    z-index: 100;
    display: none;
}
.popup{
    position: absolute;
    left: 27%;
    top: 20%;
    margin-left: -32px; /* -1 * image width / 2 */
    margin-top: -32px;  /* -1 * image height / 2 */
    display: none;
    z-index: 101;
    background: rgb(246, 246, 246) none repeat scroll 0 0;
    opacity: 1;
    width: auto;
    max-width: 45%;
    height: auto;
}
.popup-content{
    border: 4px solid #f6f6f6;
}
.popup img{
    width: auto;
    height: auto;
}
.popup video{
    width: 500px;
    height: auto;
}
.play-popup{
     position: absolute;
        left: 27%;
        margin-left: -32px; /* -1 * image width / 2 */
        margin-top: -32px; /* -1 * image height / 2 */
        display: none;
        z-index: 101;
        background: rgb(246, 246, 246) none repeat scroll 0 0;
        opacity: 1;
        width: 370px;
        max-width: 100%;
      //border: 4px solid #f6f6f6;
        border: 4px solid;
       // overflow-y: scroll !important;
}
.play-popup-content {
    border: 4px solid #f6f6f6;
}
.tric{height:auto;} .tric .redo{ position:relative; top:-25px;height:auto;opacity:0.8;}.redo b{text-align: center; color: white;margin-left: 28px;} 
.input-group {
    border-collapse: separate;
    display: table;
    position: relative;
}
.input-group-addon {
    background-color: #eee;
    border: 1px solid #ccc;
    border-radius: 4px;
    color: #555;
    font-size: 14px;
    font-weight: 400;
    line-height: 1;
    padding: 6px 12px;
    text-align: center;
}
.form-inline .input-group {
    display: inline-table;
    vertical-align: middle;
}
.form-inline .input-group .input-group-addon, .form-inline .input-group .input-group-btn, .form-inline .input-group .form-control {
    width: auto;
}
.form-inline .input-group > .form-control {
    width: 100%;
}
.btn-toolbar .btn-group, .btn-toolbar .input-group {
    float: left;
}
.btn-toolbar > .btn, .btn-toolbar > .btn-group, .btn-toolbar > .input-group {
    margin-left: 5px;
}
.input-group {
    border-collapse: separate;
    display: table;
    position: relative;
}
.input-group[class*="col-"] {
    float: none;
    padding-left: 0;
    padding-right: 0;
}
.input-group .form-control {
    float: left;
    margin-bottom: 0;
    position: relative;
    /*width: 100%;*/
    z-index: 2;
}
.input-group-lg > .form-control, .input-group-lg > .input-group-addon, .input-group-lg > .input-group-btn > .btn {
    border-radius: 6px;
    font-size: 18px;
    height: 46px;
    line-height: 1.33;
    padding: 10px 16px;
}
select.input-group-lg > .form-control, select.input-group-lg > .input-group-addon, select.input-group-lg > .input-group-btn > .btn {
    height: 46px;
    line-height: 46px;
}
textarea.input-group-lg > .form-control, textarea.input-group-lg > .input-group-addon, textarea.input-group-lg > .input-group-btn > .btn, select.input-group-lg[multiple] > .form-control, select.input-group-lg[multiple] > .input-group-addon, select.input-group-lg[multiple] > .input-group-btn > .btn {
    height: auto;
}
.input-group-sm > .form-control, .input-group-sm > .input-group-addon, .input-group-sm > .input-group-btn > .btn {
    border-radius: 3px;
    font-size: 12px;
    height: 30px;
    line-height: 1.5;
    padding: 5px 10px;
}
select.input-group-sm > .form-control, select.input-group-sm > .input-group-addon, select.input-group-sm > .input-group-btn > .btn {
    height: 30px;
    line-height: 30px;
}
textarea.input-group-sm > .form-control, textarea.input-group-sm > .input-group-addon, textarea.input-group-sm > .input-group-btn > .btn, select.input-group-sm[multiple] > .form-control, select.input-group-sm[multiple] > .input-group-addon, select.input-group-sm[multiple] > .input-group-btn > .btn {
    height: auto;
}

.input-group-addon, .input-group-btn {
    vertical-align: middle;
    white-space: nowrap;
    /*width: 1%;*/
}
.input-group-addon {
    background-color: #eee;
    border: 1px solid #ccc;
    border-radius: 4px;
    color: #555;
    font-size: 14px;
    font-weight: 400;
    line-height: 2.3;
    padding: 5px 4px 4px 8px;
    text-align: center;
}
.input-group-addon.input-sm {
    border-radius: 3px;
    font-size: 12px;
    padding: 5px 10px;
}
.input-group-addon.input-lg {
    border-radius: 6px;
    font-size: 18px;
    padding: 10px 16px;
}
.input-group-addon input[type="radio"], .input-group-addon input[type="checkbox"] {
    margin-top: 0;
}
.input-group .form-control:first-child, .input-group-addon:first-child, .input-group-btn:first-child > .btn, .input-group-btn:first-child > .btn-group > .btn, .input-group-btn:first-child > .dropdown-toggle, .input-group-btn:last-child > .btn:not(:last-child):not(.dropdown-toggle), .input-group-btn:last-child > .btn-group:not(:last-child) > .btn {
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
}
.input-group-addon:first-child {
    border-right: 0 none;
}
.input-group .form-control:last-child, .input-group-addon:last-child, .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group > .btn, .input-group-btn:last-child > .dropdown-toggle, .input-group-btn:first-child > .btn:not(:first-child), .input-group-btn:first-child > .btn-group:not(:first-child) > .btn {
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;
}
.input-group-addon:last-child {
    border-left: 0 none;
}
.input-group-btn {
    font-size: 0;
    position: relative;
    white-space: nowrap;
}
.input-group-btn > .btn {
    position: relative;
}
.input-group-btn > .btn + .btn {
    margin-left: -1px;
}
.input-group-btn > .btn:hover, .input-group-btn > .btn:focus, .input-group-btn > .btn:active {
    z-index: 2;
}
.input-group-btn:first-child > .btn, .input-group-btn:first-child > .btn-group {
    margin-right: -1px;
}
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    margin-left: -1px;
}
.navbar-form .input-group {
    display: inline-table;
    vertical-align: middle;
}
.navbar-form .input-group .input-group-addon, .navbar-form .input-group .input-group-btn, .navbar-form .input-group .form-control {
    width: auto;
}
.navbar-form .input-group > .form-control {
    width: 100%;
}
.bootstrap-datetimepicker-widget > ul > li{
            float:left;
            width:50%
}

.dropdown-menu.pull-right {
    right: 0;
    left: auto;
}
html {
    font-family: sans-serif;
    -webkit-text-size-adjust: 100%;
    -ms-text-size-adjust: 100%;
}

table {
    border-spacing: 0;
    border-collapse: collapse;
}
td,
th {
    padding: 0;
}

* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
*:before,
*:after {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}


ul,
ol {
    margin-top: 0;
    margin-bottom: 10px;
}
ul ul,ol ul,ul ol,ol ol {
    margin-bottom: 0;
}

.list-unstyled {
    padding-left: 0;
    list-style: none;
}
.list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;
}
.list-inline > li {
    display: inline-block;
    padding-right: 5px;
    padding-left: 5px;
}

.row {
    margin-right: -15px;
    margin-left: -15px;
}

input{
    height: auto !important;
}


.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}
.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
    float: left;
}
.col-xs-12 {
    width: 100%;
}
.col-xs-11 {
    width: 91.66666667%;
}
.col-xs-10 {
    width: 83.33333333%;
}
.col-xs-9 {
    width: 75%;
}
.col-xs-8 {
    width: 66.66666667%;
}
.col-xs-7 {
    width: 58.33333333%;
}
.col-xs-6 {
    width: 50%;
}
.col-xs-5 {
    width: 41.66666667%;
}
.col-xs-4 {
    width: 33.33333333%;
}
.col-xs-3 {
    width: 25%;
}
.col-xs-2 {
    width: 16.66666667%;
}
.col-xs-1 {
    width: 8.33333333%;
}
.col-xs-pull-12 {
    right: 100%;
}
.col-xs-pull-11 {
    right: 91.66666667%;
}
.col-xs-pull-10 {
    right: 83.33333333%;
}
.col-xs-pull-9 {
    right: 75%;
}
.col-xs-pull-8 {
    right: 66.66666667%;
}
.col-xs-pull-7 {
    right: 58.33333333%;
}
.col-xs-pull-6 {
    right: 50%;
}
.col-xs-pull-5 {
    right: 41.66666667%;
}
.col-xs-pull-4 {
    right: 33.33333333%;
}
.col-xs-pull-3 {
    right: 25%;
}
.col-xs-pull-2 {
    right: 16.66666667%;
}
.col-xs-pull-1 {
    right: 8.33333333%;
}
.col-xs-pull-0 {
    right: auto;
}
.col-xs-push-12 {
    left: 100%;
}
.col-xs-push-11 {
    left: 91.66666667%;
}
.col-xs-push-10 {
    left: 83.33333333%;
}
.col-xs-push-9 {
    left: 75%;
}
.col-xs-push-8 {
    left: 66.66666667%;
}
.col-xs-push-7 {
    left: 58.33333333%;
}
.col-xs-push-6 {
    left: 50%;
}
.col-xs-push-5 {
    left: 41.66666667%;
}
.col-xs-push-4 {
    left: 33.33333333%;
}
.col-xs-push-3 {
    left: 25%;
}
.col-xs-push-2 {
    left: 16.66666667%;
}
.col-xs-push-1 {
    left: 8.33333333%;
}
.col-xs-push-0 {
    left: auto;
}
.col-xs-offset-12 {
    margin-left: 100%;
}
.col-xs-offset-11 {
    margin-left: 91.66666667%;
}
.col-xs-offset-10 {
    margin-left: 83.33333333%;
}
.col-xs-offset-9 {
    margin-left: 75%;
}
.col-xs-offset-8 {
    margin-left: 66.66666667%;
}
.col-xs-offset-7 {
    margin-left: 58.33333333%;
}
.col-xs-offset-6 {
    margin-left: 50%;
}
.col-xs-offset-5 {
    margin-left: 41.66666667%;
}
.col-xs-offset-4 {
    margin-left: 33.33333333%;
}
.col-xs-offset-3 {
    margin-left: 25%;
}
.col-xs-offset-2 {
    margin-left: 16.66666667%;
}
.col-xs-offset-1 {
    margin-left: 8.33333333%;
}
.col-xs-offset-0 {
    margin-left: 0;
}
@media (min-width: 768px) {
    .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
        float: left;
    }
    .col-sm-12 {
        width: 100%;
    }
    .col-sm-11 {
        width: 91.66666667%;
    }
    .col-sm-10 {
        width: 83.33333333%;
    }
    .col-sm-9 {
        width: 75%;
    }
    .col-sm-8 {
        width: 66.66666667%;
    }
    .col-sm-7 {
        width: 58.33333333%;
    }
    .col-sm-6 {
        width: 50%;
    }
    .col-sm-5 {
        width: 41.66666667%;
    }
    .col-sm-4 {
        width: 33.33333333%;
    }
    .col-sm-3 {
        width: 25%;
    }
    .col-sm-2 {
        width: 16.66666667%;
    }
    .col-sm-1 {
        width: 8.33333333%;
    }
    .col-sm-pull-12 {
        right: 100%;
    }
    .col-sm-pull-11 {
        right: 91.66666667%;
    }
    .col-sm-pull-10 {
        right: 83.33333333%;
    }
    .col-sm-pull-9 {
        right: 75%;
    }
    .col-sm-pull-8 {
        right: 66.66666667%;
    }
    .col-sm-pull-7 {
        right: 58.33333333%;
    }
    .col-sm-pull-6 {
        right: 50%;
    }
    .col-sm-pull-5 {
        right: 41.66666667%;
    }
    .col-sm-pull-4 {
        right: 33.33333333%;
    }
    .col-sm-pull-3 {
        right: 25%;
    }
    .col-sm-pull-2 {
        right: 16.66666667%;
    }
    .col-sm-pull-1 {
        right: 8.33333333%;
    }
    .col-sm-pull-0 {
        right: auto;
    }
    .col-sm-push-12 {
        left: 100%;
    }
    .col-sm-push-11 {
        left: 91.66666667%;
    }
    .col-sm-push-10 {
        left: 83.33333333%;
    }
    .col-sm-push-9 {
        left: 75%;
    }
    .col-sm-push-8 {
        left: 66.66666667%;
    }
    .col-sm-push-7 {
        left: 58.33333333%;
    }
    .col-sm-push-6 {
        left: 50%;
    }
    .col-sm-push-5 {
        left: 41.66666667%;
    }
    .col-sm-push-4 {
        left: 33.33333333%;
    }
    .col-sm-push-3 {
        left: 25%;
    }
    .col-sm-push-2 {
        left: 16.66666667%;
    }
    .col-sm-push-1 {
        left: 8.33333333%;
    }
    .col-sm-push-0 {
        left: auto;
    }
    .col-sm-offset-12 {
        margin-left: 100%;
    }
    .col-sm-offset-11 {
        margin-left: 91.66666667%;
    }
    .col-sm-offset-10 {
        margin-left: 83.33333333%;
    }
    .col-sm-offset-9 {
        margin-left: 75%;
    }
    .col-sm-offset-8 {
        margin-left: 66.66666667%;
    }
    .col-sm-offset-7 {
        margin-left: 58.33333333%;
    }
    .col-sm-offset-6 {
        margin-left: 50%;
    }
    .col-sm-offset-5 {
        margin-left: 41.66666667%;
    }
    .col-sm-offset-4 {
        margin-left: 33.33333333%;
    }
    .col-sm-offset-3 {
        margin-left: 25%;
    }
    .col-sm-offset-2 {
        margin-left: 16.66666667%;
    }
    .col-sm-offset-1 {
        margin-left: 8.33333333%;
    }
    .col-sm-offset-0 {
        margin-left: 0;
    }
}
@media (min-width: 992px) {
    .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
        float: left;
    }
    .col-md-12 {
        width: 100%;
    }
    .col-md-11 {
        width: 91.66666667%;
    }
    .col-md-10 {
        width: 83.33333333%;
    }
    .col-md-9 {
        width: 75%;
    }
    .col-md-8 {
        width: 66.66666667%;
    }
    .col-md-7 {
        width: 58.33333333%;
    }
    .col-md-6 {
        width: 50%;
    }
    .col-md-5 {
        width: 41.66666667%;
    }
    .col-md-4 {
        width: 33.33333333%;
    }
    .col-md-3 {
        width: 25%;
    }
    .col-md-2 {
        width: 16.66666667%;
    }
    .col-md-1 {
        width: 8.33333333%;
    }
    .col-md-pull-12 {
        right: 100%;
    }
    .col-md-pull-11 {
        right: 91.66666667%;
    }
    .col-md-pull-10 {
        right: 83.33333333%;
    }
    .col-md-pull-9 {
        right: 75%;
    }
    .col-md-pull-8 {
        right: 66.66666667%;
    }
    .col-md-pull-7 {
        right: 58.33333333%;
    }
    .col-md-pull-6 {
        right: 50%;
    }
    .col-md-pull-5 {
        right: 41.66666667%;
    }
    .col-md-pull-4 {
        right: 33.33333333%;
    }
    .col-md-pull-3 {
        right: 25%;
    }
    .col-md-pull-2 {
        right: 16.66666667%;
    }
    .col-md-pull-1 {
        right: 8.33333333%;
    }
    .col-md-pull-0 {
        right: auto;
    }
    .col-md-push-12 {
        left: 100%;
    }
    .col-md-push-11 {
        left: 91.66666667%;
    }
    .col-md-push-10 {
        left: 83.33333333%;
    }
    .col-md-push-9 {
        left: 75%;
    }
    .col-md-push-8 {
        left: 66.66666667%;
    }
    .col-md-push-7 {
        left: 58.33333333%;
    }
    .col-md-push-6 {
        left: 50%;
    }
    .col-md-push-5 {
        left: 41.66666667%;
    }
    .col-md-push-4 {
        left: 33.33333333%;
    }
    .col-md-push-3 {
        left: 25%;
    }
    .col-md-push-2 {
        left: 16.66666667%;
    }
    .col-md-push-1 {
        left: 8.33333333%;
    }
    .col-md-push-0 {
        left: auto;
    }
    .col-md-offset-12 {
        margin-left: 100%;
    }
    .col-md-offset-11 {
        margin-left: 91.66666667%;
    }
    .col-md-offset-10 {
        margin-left: 83.33333333%;
    }
    .col-md-offset-9 {
        margin-left: 75%;
    }
    .col-md-offset-8 {
        margin-left: 66.66666667%;
    }
    .col-md-offset-7 {
        margin-left: 58.33333333%;
    }
    .col-md-offset-6 {
        margin-left: 50%;
    }
    .col-md-offset-5 {
        margin-left: 41.66666667%;
    }
    .col-md-offset-4 {
        margin-left: 33.33333333%;
    }
    .col-md-offset-3 {
        margin-left: 25%;
    }
    .col-md-offset-2 {
        margin-left: 16.66666667%;
    }
    .col-md-offset-1 {
        margin-left: 8.33333333%;
    }
    .col-md-offset-0 {
        margin-left: 0;
    }
}
@media (min-width: 1200px) {
    .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
        float: left;
    }
    .col-lg-12 {
        width: 100%;
    }
    .col-lg-11 {
        width: 91.66666667%;
    }
    .col-lg-10 {
        width: 83.33333333%;
    }
    .col-lg-9 {
        width: 75%;
    }
    .col-lg-8 {
        width: 66.66666667%;
    }
    .col-lg-7 {
        width: 58.33333333%;
    }
    .col-lg-6 {
        width: 50%;
    }
    .col-lg-5 {
        width: 41.66666667%;
    }
    .col-lg-4 {
        width: 33.33333333%;
    }
    .col-lg-3 {
        width: 25%;
    }
    .col-lg-2 {
        width: 16.66666667%;
    }
    .col-lg-1 {
        width: 8.33333333%;
    }
    .col-lg-pull-12 {
        right: 100%;
    }
    .col-lg-pull-11 {
        right: 91.66666667%;
    }
    .col-lg-pull-10 {
        right: 83.33333333%;
    }
    .col-lg-pull-9 {
        right: 75%;
    }
    .col-lg-pull-8 {
        right: 66.66666667%;
    }
    .col-lg-pull-7 {
        right: 58.33333333%;
    }
    .col-lg-pull-6 {
        right: 50%;
    }
    .col-lg-pull-5 {
        right: 41.66666667%;
    }
    .col-lg-pull-4 {
        right: 33.33333333%;
    }
    .col-lg-pull-3 {
        right: 25%;
    }
    .col-lg-pull-2 {
        right: 16.66666667%;
    }
    .col-lg-pull-1 {
        right: 8.33333333%;
    }
    .col-lg-pull-0 {
        right: auto;
    }
    .col-lg-push-12 {
        left: 100%;
    }
    .col-lg-push-11 {
        left: 91.66666667%;
    }
    .col-lg-push-10 {
        left: 83.33333333%;
    }
    .col-lg-push-9 {
        left: 75%;
    }
    .col-lg-push-8 {
        left: 66.66666667%;
    }
    .col-lg-push-7 {
        left: 58.33333333%;
    }
    .col-lg-push-6 {
        left: 50%;
    }
    .col-lg-push-5 {
        left: 41.66666667%;
    }
    .col-lg-push-4 {
        left: 33.33333333%;
    }
    .col-lg-push-3 {
        left: 25%;
    }
    .col-lg-push-2 {
        left: 16.66666667%;
    }
    .col-lg-push-1 {
        left: 8.33333333%;
    }
    .col-lg-push-0 {
        left: auto;
    }
    .col-lg-offset-12 {
        margin-left: 100%;
    }
    .col-lg-offset-11 {
        margin-left: 91.66666667%;
    }
    .col-lg-offset-10 {
        margin-left: 83.33333333%;
    }
    .col-lg-offset-9 {
        margin-left: 75%;
    }
    .col-lg-offset-8 {
        margin-left: 66.66666667%;
    }
    .col-lg-offset-7 {
        margin-left: 58.33333333%;
    }
    .col-lg-offset-6 {
        margin-left: 50%;
    }
    .col-lg-offset-5 {
        margin-left: 41.66666667%;
    }
    .col-lg-offset-4 {
        margin-left: 33.33333333%;
    }
    .col-lg-offset-3 {
        margin-left: 25%;
    }
    .col-lg-offset-2 {
        margin-left: 16.66666667%;
    }
    .col-lg-offset-1 {
        margin-left: 8.33333333%;
    }
    .col-lg-offset-0 {
        margin-left: 0;
    }
}
.form-control{
    height:auto !important;
}
        .nohover{
            cursor: default;
        }
        .nohover:hover{
            color:#E01E1C;
        }
.nohover:hover > i{
    color:#E01E1C;
}


</style>
    </head>
    <body>
        <script>
			var base_url = "<?php echo base_url(); ?>";
			var uriseg = "<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2); ?>";
		</script>
        <div class="navbar navbar-fixed-top">
            <?php $this->load->view('includes/moderator_header'); ?>
        </div>
        <!-- /navbar -->
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <?php $this->load->view('includes/moderator_leftmenu'); ?>
                    </div>
                    <div align="center" class="<?php echo $this->session->flashdata('type'); ?>"><?php echo $this->session->flashdata('msg'); ?></div>
                    <div class="span9">
                        <?php echo $content_for_layout; ?>
                    </div>
                    <!--/.span9-->
                </div>
            </div>
            <!--/.container-->
        </div>
        <!--/.wrapper-->
        <div class="overlay"></div>
<div class="popup" id="popup">
    <div style="position:absolute;width:100%; z-index: 102"><span class="close-button"><img class="close-button" src="<?php echo base_url(); ?>appimages/lightbox-close.png" style="float: right;"/></span></div>
    <div class="popup-content"></div>
</div>
        <div class="play-popup">
    <div style="position:absolute;width:380px; z-index: 102; margin-top: -20px;"><span class="close-button"><img class="close-button" src="<?php echo base_url(); ?>appimages/lightbox-close.png" style="float: right;"/></span></div> 
<div class="play-popup-content">
    <audio id="media_file" src='http://sprintmediasg.s3.amazonaws.com/audios/' controls></audio>    
    </div>
</div>
        <?php $this->load->view('includes/footer'); ?>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/additional-methods.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!--        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.resize.js"></script>
        <script src="<?php echo base_url(); ?>js/flot/jquery.flot.pie.js" type="text/javascript"></script>-->
        <script src="<?php echo base_url(); ?>js/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/common.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/form_validation.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/tinymce/tinymce.min.js" type="text/javascript"></script>
		
		<script src="<?php echo base_url(); ?>js/moment.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
	 <script>
$(document).on('click', '.test', function () {
     jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + 
                                                $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + 
                                                $(window).scrollLeft()) + "px");
    return this;
    }
      //var idd=  '#'+ $(this).attr('id');
       $(this).clone().removeClass('test').appendTo(".popup-content"); 
       
       $('.overlay').show();
       $('.overlay').center();
        $('.popup').show();
        $('.popup').center();
        $('.redo').css('display','none');
        //$('.popup-content').next('.test').removeClass('test');
        $('body').css('overflow-y','hidden');

        });

	$("#from_date").datetimepicker({
        format:"MM/DD/YYYY  HH:mm:ss",
        //minDate: new Date(),
        sideBySide: true,
        //enabledHours:[08,09,10,11,12,13,14,15,16,17,18,19,20],
        keepOpen: false,
    });

	$("#to_date").datetimepicker({
        format:"MM/DD/YYYY  HH:mm:ss",
        //minDate: new Date(),
        sideBySide: true,
        //enabledHours:[08,09,10,11,12,13,14,15,16,17,18,19,20],
        keepOpen: false,
    });
	$(document).ready(function(){
    $(".close-button").click(function(){
         $(".popup-content").html("");
         $('.overlay').hide();
         $('.popup').hide();
         $('.play-popup').hide();
         $('.redo').css('display','block');
         $('body').css('overflow-y','visible');
    });
    $('.overlay').click(function(){
        $(".popup-content").html("");
         $('.overlay').hide();
         $('.popup').hide();
         $('.play-popup').hide();
         $('.redo').css('display','block');
         $('body').css('overflow-y','visible');
    });
});
$(document).on('click', '.play-content', function () {
    jQuery.fn.center = function () {
        this.css("position","absolute");
        this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
                $(window).scrollTop()) + "px");
        this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
                $(window).scrollLeft()) + "px");
        return this;
    }
    //var idd=  '#'+ $(this).attr('id');
    //$(this).removeClass('test').appendTo(".report-popup-content");

    $('.overlay').show();
    $('.overlay').center();
   // $("#ctype").html($(this).attr('data-contenttype'));
    var file=$(this).attr('data-media');
    $('#media_file').attr('src',"http://sprintmediasg.s3.amazonaws.com/dubs/"+file);
    $('#media_file').attr('autoplay',true);
    $('.play-popup').show();
    $('.play-popup').center();
    //$('.popup-content').next('.test').removeClass('test');
    $('body').css('overflow-y','hidden');

});
               </script>	
        <style>
            #txtinput{width:400px;height: 30px;border-radius:8px;border:1px solid #999;}
            .ui-autocomplete {
                max-height: 100px;
                overflow-y: auto;
                /* prevent horizontal scrollbar */
                overflow-x: hidden;
            }
        </style>
        </body> 
</html>
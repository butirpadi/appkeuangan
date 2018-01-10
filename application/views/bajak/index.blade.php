<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
		<link href='http://fonts.googleapis.com/css?family=Creepster|Audiowide' rel='stylesheet' type='text/css'>
		
		<style>
			*{
				margin:0;
				padding:0;
			}
			body{
				font-family: 'Audiowide', cursive, arial, helvetica, sans-serif;
				background:url(img/error_bg.png) repeat;
				background-color:#212121;
				color:white;
				font-size: 18px;
				padding-bottom:20px;
			}
			.error-code{
				font-family: 'Creepster', cursive, arial, helvetica, sans-serif;
				font-size: 200px;
				color: white;
				color: rgba(255, 255, 255, 0.98);
				width: 50%;
				text-align: right;
				margin-top: 5%;
				text-shadow: 5px 5px hsl(0, 0%, 25%);
				float: left;
			}
			.not-found{
				width: 47%;
				float: right;
				margin-top: 5%;
				font-size: 50px;
				color: white;
				text-shadow: 2px 2px 5px hsl(0, 0%, 61%);
				padding-top: 70px;
			}
			.clear{
				float:none;
				clear:both;
			}
			.content{
				text-align:center;
				line-height: 30px;
			}
			input[type=text]{
				border: hsl(247, 89%, 72%) solid 1px;
				outline: none;
				padding: 5px 3px;
				font-size: 16px;
				border-radius: 8px;
			}
			a{
				text-decoration: none;
				color: #9ECDFF;
				text-shadow: 0px 0px 2px white;
			}
			a:hover{
				color:white;
			}

		</style>
		<title>Error</title>
	</head>
	<body>
		
		<p class="error-code">
			STOP
		</p>
		<p class="not-found">PEMBAJAKAN</p>
		<div class="clear"></div>
		<div class="content">
			ANDA TIDAK MEMPUNYAI HAK UNTUK MENGGUNAKAN SOFTWARE INI
                        <BR/>
                        HUBUNGI SOFTWARE DEVELOPER KAMI UNTUK MEMBELI DAN MENGGUNAKAN SOFTWARE INI SECARA LEGAL
                        <BR/>
                        TERIMA KASIH
                        <BR/>
                        CONTACT PERSON:
                        <BR/>
                        LOGIKAMEDIA
                        <BR/>
                        ERIES HERMANTO S.Kom
                        <BR/>
                        081-357-359-019
                        
			<br/><a href="<?php echo URL::to('home') ?>">Go Home</a> 
		</div>
                <div style="text-align: center;font-family: serif;">
                    Kirimkan Request Key berikut kepada kami melalui sms/email, dan inputkan serial key yang kami berikan kepada anda.
                    <br/>
                    <br/>
                    Request Key : <label style="background-color: #60b044;color: black;padding: 5px;">{{ $reqkey }}</label> <i>*perhatikan huruf besar kecilnya</i>
                    <br/>
                    <br/>
                    <?php echo \Laravel\Form::open();?>
                    Serial Number : <?php echo \Laravel\Form::text('snkey', null,array('size'=>'50', 'placeholder' => 'type your SNKEY here','autocomplete' => 'off'));?>
                    <?php echo \Laravel\Form::submit('Activate', array('style'=>'background-color:orangered;border:none;padding:5px;color:white;'));?>
                    <?php echo \Laravel\Form::close();?>
                </div>
	</body>
</html>

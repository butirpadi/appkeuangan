<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php echo \Laravel\Form::open()?>
        <?php echo \Laravel\Form::password('auth', array('placeholder' => 'AUTH'));?>
        <?php echo \Laravel\Form::text('snkey', null,array('placeholder' => 'Type your reqkey'));?>
        <?php echo \Laravel\Form::submit();?>
        <?php echo \Laravel\Form::close()?>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estructuras de control con blade</title>
</head>
<body>
    Su nota es::{{$nota}}
    <br>
    Situación:
    @if ($nota>13)
        Aprobado 
    @else
        Desaprobado
    @endif

    
    <?php  
    phpinfo();
    ?>
    
    
</body>
</html>
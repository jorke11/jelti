<html>
    <head>

    </head>
    <body>
        {!! Form::open(['id'=>'frm','url' => 'setinventory',]) !!}
        <textarea id="urls" name="urls" cols="80" rows="20"></textarea>
        <br>
        <button type="submit">Enviar</button>
        {!!Form::close()!!}
    </body>
</html>
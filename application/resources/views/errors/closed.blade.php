<!DOCTYPE html>
<html>
<head>
    <title>Sistema Temporariamente Indisponível</title>
</head>
<body>
    <h1>Sistema Temporariamente Indisponível</h1>
    <p>O sistema está temporariamente indisponível. Por favor, tente novamente mais tarde.</p>
    @if (isset($nextOpening))
        <p>O sistema estará disponível novamente em {{ gmdate("H:i:s", $nextOpening) }}.</p>
    @endif
</body>
</html>

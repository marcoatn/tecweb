<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Método Simplex</title>
<link rel="stylesheet" type="text/css" href="datatables.css"/>
<script type="text/javascript" src="datatables.js"></script>
<link rel="stylesheet" type="text/css" href="estilo.css"/>
<script type="text/javascript" src="scripts.js"></script>
</head>
<body>
<section class='main'> 
    <form action='tabela.php' method='post'>
    <div class="corpo">
        <h1>Variaveis de Decisão: <div class='button'>
            <button id='addVariavelDecisao'>Inserir Variavel</button>
            <button id='delVariavelDecisao'>Remover Variavel</button>
        </div></h1>
        <div id='funcaoObjetiva'>
            <b style='font-size:1.5em'>F.O.(x) -></b> 
            <select id='tipoFuncao' name='tipoFuncao' required>
                <option value=''></option>
                <option value='MAX'>MAX</option>
                <option value='MIN'>MIN</option>
            </select>
            <b style='font-size:1.5em'> Z = </b>
                <div id='exibeVariavelDecisao' hidden style='display:inline-block;'>
                </div>
        </div>
        
        <h1>Restrições: <div class='button'>
            <button id='addRestricao'>Inserir restrição</button>
            <button id='delRestricao'>Remover restrição</button>
        </div></h1>
         <br>    
        <div id='exibeRestricoes' hidden style='display:inline-block;'>
        </div>
    </div>
    <div id='rodape'>
        Total de variaveis de decisão: <input class='valores' type='text' id='totalVariaveis' name='totalVariaveis' readonly>
        Total de restrições: <input class='valores' type='text' id='totalRestricoes' name = 'totalRestricoes' readonly>
    </div>
    <button name='gerarTabela' id='gerarTabela'>Gerar Tabela</button>
    </form>
</section>
</body>
</html>

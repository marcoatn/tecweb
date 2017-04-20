<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Método Simplex</title>
<link rel="stylesheet" type="text/css" href="http://10.4.5.10/intra/datatables.css"/>
<script type="text/javascript" src="http://10.4.5.10/intra/datatables.js"></script>
<link rel="stylesheet" type="text/css" href="http://10.4.5.10/simplex/estilo.css"/>
<script type="text/javascript" src="http://10.4.5.10/simplex/scripts.js"></script>
</head>
<body>
<section class='main'> 
    <form action='tabela.php' method='post'>
    <div class="corpo">
        <h1>Função Objetiva - Variaveis de Decisão</h1>
        <div id='funcaoObjetiva'>
            <b style='font-size:1.5em'>F.O.(x) -></b> 
            <select id='tipoFuncao' name='tipoFuncao'>
                <option value=''></option>
                <option value='max'>MAX</option>
                <option value='min'>MIN</option>
            </select>
            <b style='font-size:1.5em'> Z = </b>
                <div id='exibeVariavelDecisao' hidden style='display:inline-block;'>
                </div>
        </div>
        <div class='button'>
            <button id='addVariavelDecisao'>Inserir Variavel</button>
            <button id='delVariavelDecisao'>Remover Variavel</button>
        </div>
        <h1>Restrições</h1>
        <div class='button'>
            <button id='addRestricao'>Inserir restrição</button>
            <button id='delRestricao'>Remover restrição</button>
        </div>
        
        <div id='exibeRestricoes' hidden style='display:inline-block;'>
        </div>
    </div>
    <div id='rodape'>
        Total de variaveis de decisão: <input class='valores' type='text' id='totalVariaveis' name='totalVariaveis'>
        Total de restrições: <input class='valores' type='text' id='totalRestricoes' name = 'totalRestricoes'>
    </div>
    <button name='gerarTabela' id='gerarTabela'>Gerar Tabela</button>
    </form>
</section>
</body>
</html>

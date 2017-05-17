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
    <div class="corpo" >
    <h1>RESOLUÇÃO MÉTODO SIMPLEX:</h1>

<?php
//VERIFICA SE O BOTÃO "GERAR TABELA" FOI CLICADO
if(isset($_POST['gerarTabela']))
{
    //DECLARA UM ARRAY QUE SERÁ A MATRIZ DAS SUB-CELULAS SUPERIORES
    $tabelaSimplex=array();
    //DECLARA UM ARRAY QUE CONTERÁ AS VARIAVEIS NÃO BASICAS
    $VNB = array();
    //DECLARA UM ARRAY QUE CONTERÁ AS VARIAVEIS BÁSICAS
    $VB = array();
    //INSERE O VALOR ZERO NA POSIÇAO 0-0 NA MATRIZ
    $tabelaSimplex[0][0] = 0;
    //RECEBE O NUMERO DE VARIAVEIS QUE O PROBLEMA CONTEM
    $totalVariaveis = $_POST['totalVariaveis'];
    //RECEBE O NUMERO DE RESTRIÇÕES QUE O PROBLEMA CONTEM
    $totalRestricoes = $_POST['totalRestricoes'];

    //VERIFICA QUAL SE A FUNÇÃO SERÁ DE MAXIMIZAÇÃO OU DE MINIMIZAÇÃO
    if($_POST['tipoFuncao'] == "MAX")
    {
        $tipoFuncao = "MIN";
    }

    //LAÇO FOR QUE PERCORRE O ARRAY $VNB E A PRIMEIRA LINHA DA $TABELASIMPLEX
    for($i=0; $i < $totalVariaveis; $i++)
    {   
        //ADICIONA CADA VARIAVEL NAO BASICA A UMA POSIÇÃO DO ARRAY
        $VNB[] = "x".($i+1);
        //ADICIONA AS VARIAVEIS DE RESTRIÇAO EM CADA COLUNA DA PRIMEIRA LINHA DA $TABELASIMPLEX
        if($_POST['tipoFuncao'] == "MIN")
        {
            $tabelaSimplex[0][($i+1)] = $_POST['v'.($i+1)]*(-1);
        }
        else
        {
            $tabelaSimplex[0][($i+1)] = $_POST['v'.($i+1)];
        }
    }

//IMPRIME NA TELA A FUNÇÃO OBJETIVA
    echo "<div id='fObjetiva'> F.O(x) -> ".$_POST['tipoFuncao']." Z = ";

    //PERCORRE A PRIMEIRA LINHA DA $TABELASIMPLEX
    for($i=1;$i< count($tabelaSimplex[0]); $i++)
    {
        //PARA MELHOR ENTENDIMENTO DO USUARIO, VERIFICA SE O VALOR É POSITIVO, SE SIM IMPRIME O VALOR COM UM SINAL DE +
        if($tabelaSimplex[0][$i] >= 0)
        {
            echo " +".$tabelaSimplex[0][$i]."x<span class='variavel'>".($i)."</span>";
        }
        //SE O VALOR FOR NEGATIVO ELE É IMPRESSO EM TELA NORMALMENTE POIS JA VEM COM SINAL -
        else
        {
            echo $tabelaSimplex[0][$i]."x<span class='variavel'>".($i)."</span>";
        }         
    }
    echo "<br>";

    for($i=0; $i < $totalRestricoes; $i++)
    {   
        echo "R".($i+1).":";
        for($j=0; $j < $totalVariaveis; $j++)
        {
            if($_POST['r'.($i+1).'_v'.($j+1)] >= 0)
            {
                echo " +".$_POST['r'.($i+1).'_v'.($j+1)]."x<span class='variavel'>".($j+1)."</span>";
            }
            else
            {
                echo " ".$_POST['r'.($i+1).'_v'.($j+1)]."x<span class='variavel'>".($j+1)."</span>";
            }
        }
        echo " ".$_POST['r'.($i+1)]." ".$_POST['r'.($i+1).'_total']."<br>";
    }
    echo "</div>";

    //IMPRIME NA TELA A NOVA FUNÇÃO OBJETIVA
    echo "<div id='novaFuncao'> F.O(x) -> ".$tipoFuncao." Z = ".$tabelaSimplex[0][0]." - ( ";

    //PERCORRE A PRIMEIRA LINHA DA $TABELASIMPLEX
    for($i=1;$i< count($tabelaSimplex[0]); $i++)
    {
        //PARA MELHOR ENTENDIMENTO DO USUARIO, VERIFICA SE O VALOR É POSITIVO, SE SIM IMPRIME O VALOR COM UM SINAL DE +
        if($tabelaSimplex[0][$i] > 0)
        {
            echo " +".$tabelaSimplex[0][$i]."x<span class='variavel'>".($i)."</span>";
        }
        //SE O VALOR FOR NEGATIVO ELE É IMPRESSO EM TELA NORMALMENTE POIS JA VEM COM SINAL -
        else
        {
            echo $tabelaSimplex[0][$i]."x<span class='variavel'>".($i)."</span>";
        } 
    }
    //IMPRIME O FINAL DA F.O. COM UMA QUEBRA DE LINHA
    echo " )<br>";

    //LAÇO FOR PARA PERCORRER AS LINHAS DA $TABELASIMPLEX
    for($i=0; $i < $totalRestricoes; $i++)
    {
        //PREENCHE CADA POSICAO DO ARRAY COM O NOME DE CADA VARIAVEL BASICA
        $VB[] = "x".(($totalVariaveis)+($i+1));

        //VERIFICA O VALOR DO SINAL DA RESTRIÇÃO 
        if($_POST['r'.($i+1)] == ">=")
        {   
            //SE O SINAL FOR DE >= , A $TABELASIMPLEX RECEBE O VALOR DO TERMO INDEPENDENTE MULTIPLICADO POR -1                       
            $tabelaSimplex[($i+1)][0]  = ($_POST['r'.($i+1).'_total'])*(-1);                          
        }
        else
        {
            //SENÃO A $TABELASIMPLEX RECEBE O VALOR SEM ALTERAÇÃO
            $tabelaSimplex[($i+1)][0] = $_POST['r'.($i+1).'_total'];
        }

        //LAÇO FOR QUE PERCORRE AS COLUNAS DA $TABELASIMPLEX
        for($j=0;$j < $totalVariaveis; $j++)
        {
            //VERIFICA O VALOR DO SINAL DA RESTRIÇÃO 
            if($_POST['r'.($i+1)] == ">=")
            {
                //SE O SINAL FOR DE >= , A $TABELASIMPLEX RECEBE O VALOR DO COEFICIENTE DA VARIAVEL DE RESTRIÇÃO MULTIPLICADO POR -1 
                $tabelaSimplex[($i+1)][($j+1)] = ($_POST['r'.($i+1).'_v'.($j+1)])*(-1);
            }
            else
            {   
                //SENÃO A $TABELASIMPLEX RECEBE O VALOR SEM ALTERAÇÃO
                $tabelaSimplex[($i+1)][($j+1)] = ($_POST['r'.($i+1).'_v'.($j+1)]);
            }
        }

        //IMPRIME AS RESTRIÇÕES EM TELA
        echo "x";
        echo $totalVariaveis+($i+1);
        echo " = ";
        echo $tabelaSimplex[$i+1][0];
        echo " - ( ";

        //LAÇO FOR QUE PERCORRE A $TABELASIMPLEX E IMPRIME EM TELA SEUS VALORES            
        for($k=1;$k < count($tabelaSimplex[($i+1)]);$k++ )
        {
            //SE O VALOR FOR POSITIVO, IMPRIME EM TELA O VALOR COM O SINAL DE +
            if($tabelaSimplex[($i+1)][$k] > 0)
            {
                echo " +".$tabelaSimplex[($i+1)][$k]."x<span class='variavel'>".$k."</span>";
            }
            else
            //SE O VALOR FOR NEGATIVO ELE É IMPRESSO NORMALMENTE
            if($tabelaSimplex[($i+1)][$k] < 0)
            {
                echo " ".$tabelaSimplex[($i+1)][$k]."x<span class='variavel'>".$k."</span>";
            }

        }
        //IMPRIME EM TELA O FINAL DA RESTRIÇÃO COM UMA QUEBRA DE LINHA
        echo " )<br>";
    }
    echo "</div>";

    //CHAMADA DE FUNÇÃO PASSANDO OS ARRAYS PREENCHIDOS COMO PARAMETRO
    algoritmoSimplexMetodo1($tabelaSimplex, $VB, $VNB);
}

    //FUNÇÃO QUE IMPRIME AS TABELAS EM TELA
    function imprimeTabela ($tabela, $VB, $VNB)
    {
        echo "<table border='1' id='tabelaSimplex'>
            <thead>
                <tr>
                <th class='vnb'>VNB</th>    
                <th class='vnb' rowspan='2'>ML</th>
                ";

        for($i=0;$i < count($VNB); $i++)
        {
            echo "<th rowspan='2' class='vnb'>".$VNB[$i]."</th>";
        }

        echo "</tr>
                <tr>
                    <th class='vb'>VB</th>
                </tr>
            </thead>
                <tbody>
                    <tr>
                        <th class='vb'>f(x)</th>";

        for($i=0;$i < count($tabela[0]); $i++)
        {
            echo "<td>". round($tabela[0][$i], 4)."</td>";
        }

        echo "</tr>";

        for($i=1;$i<count($tabela);$i++)
        {
            echo "<tr>";
            echo "<th class='vb'>".$VB[($i-1)]."</th>";
            for($k=0;$k<count($tabela[$i]);$k++)
            {
                echo "<td>".round($tabela[$i][$k], 4)."</td>";
            }
            echo "</tr>";
        }
                        
        echo "</tbody></table>";
    }

    //FUNÇÃO QUE REALIZA A PRIMEIRA FASE DO METODO SIMPLEX
    function algoritmoSimplexMetodo1($tabelaSimplex, $VB, $VNB)
    {
        echo "Tabela da Função Objetiva:<br>";
        imprimeTabela ($tabelaSimplex, $VB, $VNB);

        //DECLARAÇÃO DE VARIAVEIS E AS SETANDO COMO NULL
        $linha = null;
        $colunaPermitida = null;
        $linhaPermitida = null;

        //LAÇO FOR QUE PERCORRE A COLUNA DOS MEMBROS LIVRES NA $TABELASIMPLEX 
        for($i=1;$i<count($tabelaSimplex);$i++)
        {
            //CONDICIONAL QUE VERIFICA SE O VALOR É NEGATIVO
            if($tabelaSimplex[$i][0] < 0)
            {
                //SE O VALOR FOR NEGATIVO SALVA A POSIÇÃO DA LINHA EM QUE VALOR FOI ENCONTRADA
                $linha = $i;
                echo "Valor negativo de membro livre encontrado: ".$tabelaSimplex[$i][0]."<br>";
                //COMANDO PARAR SAIR DO LAÇO FOR APÓS ENCONTRAR O VALOR NEGATIVO
                break;
            }
        }

        //VERIFICA SE LINHA TEVE SEU VALOR ALTERADO OU SEJA SE ALGUM VALOR NEGATIVO FOI ENCONTRADO
        if($linha != null)
        {
            //LAÇO FOR QUE IRÁ PERCORRER A LINHA DO MEMBRO LIVRE NEGATIVO
            for($i=1;$i<count($tabelaSimplex[$linha]);$i++)
            {
                //CONDICIONAL QUE VERIFICA SE O VALOR É NEGATIVO
                if($tabelaSimplex[$linha][$i] < 0)
                {
                    //SALVA A POSIÇÃO DA COLUNA EM QUE O VALOR NEGATIVO FOI ENCONTRADO                   
                    $colunaPermitida = $i;
                    echo "Valor negativo na mesma linha do membro livre encontrado: ".$tabelaSimplex[$linha][$i]."<br>";
                    //break;
                }
            }
            
            //VERIFICA SE ALGUM VALOR FOI ADICIONADO A VARIAVEL $colunaPermitida
            if($colunaPermitida != null)
            {
                //VARIAVEL RECEBE O MAIOR VALOR INTEIRO POSSIVEL
                $menorElemento = PHP_INT_MAX;

                //LAÇO FOR QUE PERCORRE A COLUNA DO MEMBRO LIVRE E A COLUNA PERMITIDA DA $TABELASIMPLEX
                for($i=1;$i<count($tabelaSimplex);$i++)
                {
                    //VERIFICA SE O SINAL DOS VALORES PARA NUMERADOR E DENOMINADOR SÃO IGUAIS
                    if(($tabelaSimplex[$i][0] >= 0 && $tabelaSimplex[$i][$colunaPermitida] > 0) || ($tabelaSimplex[$i][0] < 0 && $tabelaSimplex[$i][$colunaPermitida] < 0))
                    {
                        //SE O VALORES TIVEREM O MESMO SINAL ENTÃO É FEITA A DIVISAO DO MEMBRO LIVRE PELO VALOR DA COLUNA PERMITIDA QUE ESTEJA NA MESMA LINHA
                        $divisao = $tabelaSimplex[$i][0]/$tabelaSimplex[$i][$colunaPermitida];
                        echo $tabelaSimplex[$i][0]."/".$tabelaSimplex[$i][$colunaPermitida]." = ".$divisao."<br>";
                        //VERIFICA QUAL É O MENOR VALOR ENCONTRADO DAS DIVISÕES
                        if($divisao < $menorElemento)
                        {
                            $menorElemento = $divisao;
                            //SALVA O NUMERO DA LINHA EM QUE ESTÁ O MENOR VALOR ENCONTRADO
                            $linhaPermitida = $i;
                        }
                    }
                }

                echo "O menor valor de divisão encontrado foi ".$tabelaSimplex[$linhaPermitida][0]."/".$tabelaSimplex[$linhaPermitida][$colunaPermitida]."=".$menorElemento."<br>";
                echo "Linha Permitida: ".$VB[$linhaPermitida-1]."<br>";
                echo "Coluna Permitida: ".$VNB[$colunaPermitida-1]."<br>";
                
                //SE LINHA PERMITIDA TIVER RECEBIDO ALGUM VALOR ENTÃO ELE CHAMA A FUNÇÃO DO ALGORITMO DE TROCA PASSANDO OS PARAMENTROS NECESSARIOS
                if($linhaPermitida != null)
                {
                    algoritmoTroca($tabelaSimplex, $VB, $VNB, $linhaPermitida, $colunaPermitida);
                }
                else
                {
                    echo "NENHUM NUMERADOR/DEMONIMADOR POSSUI O MESMO SINAL";
                }
            }
            //SE $colunaPermitida NAO FOI ALTERADA ENTAO NENHUM VALOR NEGATIVO FOI ENCONTRADO
            else
            {
                //IMPRIME A MENSAGEM NA TELA
                echo "SOLUÇÃO PERMISSIVEL NÃO EXISTE";
            }
        }
        //SE TODOS OS VALORES SÃO POSITIVOS, ENTÃO É CHAMADO A SEGUNDA FASE DO METODO SIMPLEX
        else
        {  
            algoritmoSimplexMetodo2($tabelaSimplex, $VB, $VNB);
        }
    }

    //FUNÇÃO QUE REALIZA A SEGUNDA FASE DO METODO SIMPLEX
    function algoritmoSimplexMetodo2($tabelaSimplex, $VB, $VNB)
    {
        echo "Tabela da Função Objetiva:<br>";
        imprimeTabela ($tabelaSimplex, $VB, $VNB);
        //VARIAVEIS SÃO SETADAS COM VALOR NULL
        $colunaPermitida = null;
        $linhaPermitida = null;

        //LAÇO FOR QUE PERCORRE A LINHA DA F(X) DA $TABELASIMPLEX
        for($i=1;$i<count($tabelaSimplex);$i++)
        {
            //CONDICIONAL QUE VERIFICA SE O VALOR É POSITIVO
            if($tabelaSimplex[0][$i] > 0)
            {
                //VARIAVEL $colunaPermitida RECEBE O NUMERO DA COLUNA EM QUE O VALOR POSITIVO FOI ENCONTRADO
                $colunaPermitida = $i;
                echo "Valor Positivo da f(x): ".$tabelaSimplex[0][$i]."<br>";
                break;
            }
        }

        //VERIFICA SE VALOR DE $colunaPermitida FOI MODIFICADO, O QUE INDICA QUE UM VALOR POSITIVO NA F(X) FOI ENCONTRADO
        if($colunaPermitida != null)
        {
            //VARIAVEL DE CONTROLE É SETADA COMO FALSE
            $positivoExiste = false;

            //LAÇO FOR QUE IRA PERCORRER A COLUNA PERMITIDA DA $TABELASIMPLEX
            for($i=1;$i<count($tabelaSimplex);$i++)
            {
                //VERIFICA SE EXISTE ALGUM VALOR POSITIVO 
                if($tabelaSimplex[$i][$colunaPermitida] > 0)
                { 
                    echo "Valor positivo na coluna permitida fora da linha de f(x) encontrado: ".$tabelaSimplex[$i][$colunaPermitida]."<br>";
                    //VARIAVEL É SETADA COMO VERDADEIRO POIS VALOR POSITIVO FOI ENCONTRADO
                    $positivoExiste=true;
                    break;
                }
            }
            
            //SE VALOR DE $positivoExiste É VERDADEIRO ENTÃO VALOR POSITIVO FOI ENCONTRADO, SISTEMA DA PROSSEGUIMENTO AO METODO
            if($positivoExiste == true)
            {
                //VARIAVEL RECEBE MAIOR VALOR INTEIRO POSSIVEL 
                $menorElemento = PHP_INT_MAX;

                //LAÇO FOR QUE IRÁ PERCORRER A COLUNA DOS MEMBROS LIVRES E A COLUNA PERMITIDA DA $TABELASIMPLEX
                for($i=1;$i<count($tabelaSimplex);$i++)
                {
                    //VERIFICA SE O SINAL DOS VALORES PARA NUMERADOR E DENOMINADOR SÃO IGUAIS
                    if(($tabelaSimplex[$i][0] >= 0 && $tabelaSimplex[$i][$colunaPermitida] > 0)|| ($tabelaSimplex[$i][0] < 0 && $tabelaSimplex[$i][$colunaPermitida] < 0))
                    {
                        //SE O VALORES TIVEREM O MESMO SINAL ENTÃO É FEITA A DIVISAO DO MEMBRO LIVRE PELO VALOR DA COLUNA PERMITIDA QUE ESTEJA NA MESMA LINHA
                        $divisao = $tabelaSimplex[$i][0]/$tabelaSimplex[$i][$colunaPermitida];
                        echo $tabelaSimplex[$i][0]."/".$tabelaSimplex[$i][$colunaPermitida]." = ".$divisao."<br>";
                        //VERIFICA QUAL É O MENOR VALOR ENCONTRADO DAS DIVISÕES
                        if($divisao < $menorElemento)
                        {
                            $menorElemento = $divisao;
                            //SALVA O NUMERO DA LINHA EM QUE ESTÁ O MENOR VALOR ENCONTRADO
                            $linhaPermitida = $i;
                        }
                    }
                }

                echo "O menor valor de divisão encontrado foi ".$tabelaSimplex[$linhaPermitida][0]."/".$tabelaSimplex[$linhaPermitida][$colunaPermitida]."=".$menorElemento."<br>";
                echo "Linha Permitida: ".$VB[$linhaPermitida-1]."<br>";
                echo "Coluna Permitida: ".$VNB[$colunaPermitida-1]."<br>";

                //SE LINHA PERMITIDA TIVER RECEBIDO ALGUM VALOR ENTÃO ELE CHAMA A FUNÇÃO DO ALGORITMO DE TROCA PASSANDO OS PARAMENTROS NECESSARIOS
                if($linhaPermitida != null)
                {
                    algoritmoTroca($tabelaSimplex, $VB, $VNB, $linhaPermitida, $colunaPermitida);
                }
                else
                {
                    echo "NENHUM NUMERADOR/DEMONIMADOR POSSUI O MESMO SINAL";
                }  
                        
            }
            //SENAO, NENHUM VALOR POSITIVO FOI ENCONTRADO
            else
            {
                //IMPRIME MENSAGEM EM TELA
                echo "SOLUÇÃO ÓTIMA NAO EXISTE, A SOLUÇÃO É ILIMITADA";
            }
        }
        //SE NENHUM VAOR POSITIVO FOI ENCONTRADO NA LINHA DA F(X) ENTÃO O METODO CHEGOU AO FINAL
        else
        {
            
            echo "<div id='solucao'>
            SOLUÇÃO OTIMA ENCONTRADA";
            echo " </div>";
        }
    }
    
    //FUNÇÃO QUE REALIZA O ALGORITMO DE TROCA
    function algoritmoTroca($tabelaSimplex, $VB, $VNB, $linhaPermitida, $colunaPermitida)
    {
        //CRIANDO ARRAY QUE CONTERÁ A TABALA DAS SUB-CELULAS INFERIORES
        $tabelaTroca=array();

            //VARIAVEL RECEBE O VALOR DO ELEMENTO PERMITIDO
            $elementoPermitido = $tabelaSimplex[$linhaPermitida][$colunaPermitida];
            
            //VARIAVEL QUE RECEBE O VALOR INVERSO DO ELEMENTO PERMITIDO
            $inversoElemento = 1/$elementoPermitido;

            echo "Elemento Permitido: ".$elementoPermitido."<br>";
            echo "Elemento Permitido inverso: ".$inversoElemento."<br>";
            echo "Linha Permitida multiplicada pelo inverso do EP: <table border='1'><tr>";

            //LAÇO FOR QUE IRA PERCORRER TODA A LINHA PERMITIDA DA $TABELASIMPLEX
            for($i=0; $i < count($tabelaSimplex[$linhaPermitida]); $i++)
            {
                //VERIFICA SE O VALOR DE $i É O MESMO DA COLUNA PERMITIDA O QUE INDICA QUE ESSA É A POSIÇÃO DO ELEMENTO PERMITIDO
                if($i == $colunaPermitida)
                {
                    //A $TABELATROCA RECEBE O VALOR DO INVERSO DO ELEMENTO PERMITIDO NA MESMA POSIÇÃO QUE O ELEMENTO PERMITIDO ESTA NA $TABELASIMPLEX
                    $tabelaTroca[$linhaPermitida][$i] = $inversoElemento;

                    echo "<td>".$tabelaTroca[$linhaPermitida][$i]."</td>";
                }
                //SENDO O VALOR DIREFENTE É FEITO A MULTIPLICAÇÃO DO VALOR PELO ELEMENTO PERMITIDO INVERSO
                else
                {
                    //A $TABELATROCA RECEBE O RESULTADO DA OPERAÇÃO NA MESMA POSIÇÃO EM QUE O VALOR QUE FOI MULTIPLICADO PELO EP INVERTIDO SE ENCONTRA NA $TABELASIMPLEX
                    $tabelaTroca[$linhaPermitida][$i] = $tabelaSimplex[$linhaPermitida][$i]*$inversoElemento;

                    echo "<td>".$tabelaTroca[$linhaPermitida][$i]."</td>";
                } 
            }

            echo "</tr></table><br>";
            echo "Coluna Permitida multiplicada pelo negativo do EP inverso: <table border='1'>";

            //LAÇO FOR QUE IRA PERCORRER TODA A COLUNA PERMITIDA DA $TABELASIMPLEX
            for($i=0; $i < count($tabelaSimplex); $i++)
            {   
                //VERIFICA SE $i É DIFERENTE DE $linhaPermitida, POIS ESSA É A POSIÇÃO DO ELEMENTO PERMITIDO QUE JA FOI INSERIDO NO ULIMO LAÇO FOR
                if($i != $linhaPermitida)
                {   
                    //MULTIPLICA CADA VALOR DA COLUNA PERMITIDA PELO NEGATIVO DO EP INVERSO E SALVA O RESULTADO NA $TABELATROCA NA MESMA POSIÇÃO EM QUE O VALOR SE ENCONTRA NA $TABELASIMPLEX
                    $tabelaTroca[$i][$colunaPermitida] = ($tabelaSimplex[$i][$colunaPermitida])*(-($inversoElemento));

                    echo "<tr><td>".$tabelaTroca[$i][$colunaPermitida]."</td></tr> ";
                }
            }

            echo "<table><br>";
            echo "Multiplica a SCS da coluna pelo elemento da linha permitida da mesma coluna:<br>";

            //LAÇO FOR QUE IRA PERCORRER AS LINHAS DA $TABELASIMPLEX
            for($i=0; $i < count($tabelaSimplex); $i++)
            {
                //LAÇO FOR QUE IRA PERCORRER AS COLUNAS DA $TABELA SIMPLEX
                for($j=0; $j < count($tabelaSimplex[$i]); $j++)
                {
                    //VERIFICA SE A LINHA E COLUNA NÃO SÃO AS MESMAS DA QUE A LINHA E COLUNA PERMITIDA POIS ESSAS JA FORAM PREENCHIDAS
                    if($i != $linhaPermitida && $j != $colunaPermitida)
                    {
                        //CADA POSIÇÃO DA $TABELATROCA RECEBE O VALOR DA LINHA PERMITIDA MULTIPLICADO PELO VALOR DA COLUNA PERMITIDA QUE ESTEJA NA MESMA LINHA
                        $tabelaTroca[$i][$j] = ($tabelaSimplex[$linhaPermitida][$j])*($tabelaTroca[$i][$colunaPermitida]);

                        echo $tabelaSimplex[$linhaPermitida][$j]."*".$tabelaTroca[$i][$colunaPermitida]."=". $tabelaTroca[$i][$j]."<br>";
                    }
                }
                        
            }
            
            echo "Variavel não basica ".$VNB[$colunaPermitida-1]." troca com variavel basica: ".$VB[$linhaPermitida-1]."<br>";
            
            //CRIA UM ARRAY QUE SERA USADA PARA AUXILIAR NA CRIAÇÃO DA NOVA TABELA
            $tabelaSimplexAux = array();
            
            //INVERTE A POSIÇAO DA VARIAVEL BASICA COM A POSICAO DA VARIAVEL NAO BASICA
            $aux = $VNB[$colunaPermitida-1];
            $VNB[$colunaPermitida-1] = $VB[$linhaPermitida-1];
            $VB[$linhaPermitida-1] = $aux;

            echo "Soma-se as SCS com as SCI:<br>";
            //LAÇO FOR QUE IRA PERCORRER AS LINHAS DA $TABELASIMPLEX
            for($i=0; $i < count($tabelaSimplex); $i++)
            {
                //LAÇO FOR QUE IRA PERCORRER AS COLUNAS DA $TABELASIMPLEX
                for($j=0; $j < count($tabelaSimplex[$i]); $j++)
                {
                    //VERIFICA SE O VALOR ESTA NA LINHA E COLUNA PERMITIDA
                    if($i == $linhaPermitida || $j == $colunaPermitida)
                    {
                        //TABELA AUXILIAR RECEBE OS VALORES DA $TABELATROCA (SUB-CELULAS INFERIORES)
                        $tabelaSimplexAux[$i][$j] = $tabelaTroca[$i][$j];                                
                    }
                    else
                    {
                        //TABELA AUXILIAR RECEBE A SOMA DAS POSIÇÕES IGUAIS DA $TABELASIMPLEX E DA $TABELATROCA OU SEJA A SOMA DAS SUB-CELULAS SUPERIORES COM AS SUB-CELULAS INFERIORES
                        $tabelaSimplexAux[$i][$j] = $tabelaSimplex[$i][$j]+$tabelaTroca[$i][$j];
                        echo  $tabelaSimplex[$i][$j]." + ".$tabelaTroca[$i][$j]." = ".$tabelaSimplexAux[$i][$j]."<br>" ;
                    }
                }
                            
            }

            //LAÇO FOR QUE PERCORRE A LINHA DOS MEMBROS LIVRES DA NOVA TABELA CRIADA
            for($i=1;$i<count($tabelaSimplexAux);$i++)
            {
                
                //VERIFICA SE AINDA EXISTE ALGUM VALOR NEGATIVO 
                if($tabelaSimplexAux[$i][0] < 0)
                {
                    //HAVENDO VALOR NEGATIVO, VARIAVEL DE CONTROLE RECEBE TRUE
                    $negativo = true;
                }
            }

            //SE VARIAVEL FOR VERDADEIRA A PRIMEIRA FASE DO METODO É CHAMADA NOVAMENTE ATE QUE NENHUMA VARIAVEL NEGATIVA ESTEJA ENTRE OS MEMBROS LIVRES
            if($negativo)
            {   
                algoritmoSimplexMetodo1($tabelaSimplexAux, $VB, $VNB);
            }
            //SE NÃO A SEGUNDA FASE DO MÉTODO SIMPLEX É CHAMADA POIS NÃO HA MAIS VARIAVEIS NEGATIVAS ENTRES OS MEMBROS LIVRES;
            else
            {
                algoritmoSimplexMetodo2($tabelaSimplexAux, $VB, $VNB);
            }
    }

        ?>
    </div>
</section>
</body>
</html>

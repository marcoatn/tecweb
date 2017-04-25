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
    <div class="corpo">
<?php
if(isset($_POST['gerarTabela']))
{
    $tabelaSimplex=array();
    $VNB = array();
    $VB = array();
    $tabelaSimplex[0][0] = 0;
    $totalVariaveis = $_POST['totalVariaveis'];
    $totalRestricoes = $_POST['totalRestricoes'];

    ///////// GERA NOVA FUNÇAO OBJETIVA
    if($_POST['tipoFuncao'] == "min")
    {
        $tipoFuncao = "MAX";
    }
    else
    {
        $tipoFuncao = "MIN";
    }

    for($i=0; $i < $totalVariaveis; $i++)
    {
        $VNB[] = "x".($i+1); 
        $tabelaSimplex[0][($i+1)] = $_POST['v'.($i+1)];
    }

    echo "F.O(x) -> ".$tipoFuncao." Z = ".$tabelaSimplex[0][0]." - ( ";

    for($i=1;$i< count($tabelaSimplex[0]); $i++)
    {
        if($tabelaSimplex[0][$i] > 0)
        {
            echo " +".$tabelaSimplex[0][$i];
        }
        else
        {
            echo $tabelaSimplex[0][$i];
        } 
    }
    echo " )<br>";
////////////FIM FUNCAO OBJETIVA

////////LAÇO EXTERNO DE FOR PARA PEGAR TODAS AS RESTRIÇOES
    for($i=0; $i < $totalRestricoes; $i++)
    {
        $VB[] = "x".(($totalVariaveis)+($i+1)); 
        //RECEBE O VALOR DA IGUALDADE
        if($_POST['r'.($i+1)] == ">=" || $_POST['r'.($i+1)] == ">" )
        {                            
            $tabelaSimplex[($i+1)][0]  = ($_POST['r'.($i+1).'_total'])*(-1);                          
        }
        else
        {
            $tabelaSimplex[($i+1)][0] = $_POST['r'.($i+1).'_total'];
        }

        //LAÇO INTERNO DE FOR PARA PEGAR AS VARIAVEIS DE CADA RESTRIÇÃO
        for($j=0;$j < $totalVariaveis; $j++)
        {
            //RECEBE AS VARIAVEIS DA RESTRIÇAO ALTERANDO O SINAL
            if($_POST['r'.($i+1)] == ">=" || $_POST['r'.($i+1)] == ">" )
            { 
                $tabelaSimplex[($i+1)][($j+1)] = ($_POST['r'.($i+1).'_v'.($j+1)])*(-1);
            }
            else
            {
                $tabelaSimplex[($i+1)][($j+1)] = ($_POST['r'.($i+1).'_v'.($j+1)]);
            }
        }

        echo "x";
        echo $totalVariaveis+($i+1);
        echo " = ";
        echo $tabelaSimplex[$i+1][0];
        echo " - ( ";
                    
        for($k=1;$k < count($tabelaSimplex[($i+1)]);$k++ )
        {
            if($tabelaSimplex[($i+1)][$k] > 0)
            {
                echo " +".$tabelaSimplex[($i+1)][$k]."x<span style='font-size:0.8em'>".$k."</span>";
            }
            else
            if($tabelaSimplex[($i+1)][$k] < 0)
            {
                echo " ".$tabelaSimplex[($i+1)][$k]."x<span style='font-size:0.8em'>".$k."</span>";
            }

        }
        echo " )<br>";
    }

    echo "<br><br>";

    algoritmoSimplexMetodo1($tabelaSimplex, $VB, $VNB);
}

function imprimeTabela ($tabela, $VB, $VNB)
{
    echo "<table border='1'><thead><tr><th>VB/VNB</th><th>ML</th>";

    for($i=0;$i < count($VNB); $i++)
    {
        echo "<th>".$VNB[$i]."</th>";
    }

    echo "</tr></thead><tbody><tr><td><b>f(x)</b></td>";

    for($i=0;$i < count($tabela[0]); $i++)
    {
        echo "<th>".$tabela[0][$i]."</th>";
    }

    echo "</tr>";

    for($i=1;$i<count($tabela);$i++)
    {
        echo "<tr>";
        echo "<td>".$VB[($i-1)]."</td>";
        for($k=0;$k<count($tabela[$i]);$k++)
        {
            echo "<td>".$tabela[$i][$k]."</td>";
        }
        echo "</tr>";
    }
                    
    echo "</tbody></table>";
}

    function algoritmoSimplexMetodo1($tabelaSimplex, $VB, $VNB)
    {
        $linha = null;
        $colunaPermitida = null;

        //PERCORRE OS MEMBROS LIVRES PROCURANDO UM VALOR NEGATIVO
        for($i=1;$i<count($tabelaSimplex);$i++)
        {
            //SE ENCONTRA O VALOR NEGATIVO ELE SALVA O NUMERO DA LINHA
            if($tabelaSimplex[$i][0] < 0)
            {
                $linha = $i;
                echo "Valor negativo de membro livre encontrado: ".$tabelaSimplex[$i][0]."<br>";
                $i = count($tabelaSimplex);
            }
        }

        //SE O VALOR NEGATIVO ENTRE OS MEMBROS LIVRES É ENCONTRADO ENTAO ELE PROCURA OUTRO VALOR NEGATIVO
        // NA MESMA LINHA DO MENBRO LIVRE ESCOLHIDO
        if($linha != null)
        {
            for($i=1;$i<count($tabelaSimplex[$linha]);$i++)
            {
                if($tabelaSimplex[$linha][$i] < 0)
                {                   
                    $colunaPermitida = $i;
                    echo "Valor negativo na mesma linha do membro livre encontrado: ".$tabelaSimplex[$linha][$i]."<br>";
                    $i = count($tabelaSimplex[$linha]);
                }
            }
            
            //SE ENCONTRAR UM VALOR NEGATIVO NA MESMA LINHA DO MEMBRO LIVRE NEGATIVO ELE PROCURAR O MENOR VALOR
            //DE QUOCIENTE DIVIDINDO O VALOR DOS MEMBROS LIVRES PELOS VALORES DA COLUNA PERMITIDA
            if($colunaPermitida != null)
            {
                $menorElemento = PHP_INT_MAX;

                for($i=1;$i<count($tabelaSimplex);$i++)
                {
                    //VERIFICA SE O SINAL DE DENOMINADOR E NUMERADOR SAO IGUAIS
                    if(($tabelaSimplex[$i][0] > 0 && $tabelaSimplex[$i][$colunaPermitida] > 0) || ($tabelaSimplex[$i][0] < 0 && $tabelaSimplex[$i][$colunaPermitida] < 0))
                    {
                        $divisao = $tabelaSimplex[$i][0]/$tabelaSimplex[$i][$colunaPermitida];

                        if($divisao < $menorElemento)
                        {
                            $menorElemento = $divisao;
                            $linhaPermitida = $i;
                        }
                    }
                }

                echo "O menor valor de divisão encontrado foi ".$tabelaSimplex[$linhaPermitida][0]."/".$tabelaSimplex[$linhaPermitida][$colunaPermitida]."=".$menorElemento."<br>";
                echo "Linha Permitida: ".$VB[$linhaPermitida-1]."<br>";
                echo "Coluna Permitida: ".$VNB[$colunaPermitida-1]."<br>";
                
                //AO ENCONTRAR O MENOR QUOCIENTE ENTRE AS DIVISAO CALCULA-SE O INVERSO DO ELEMENTO PERMITIDO
                if(isset($linhaPermitida))
                {
                    algoritmoTroca($tabelaSimplex, $VB, $VNB, $linhaPermitida, $colunaPermitida);
                }
            }
            else
            {
                echo "NAO HA NADA A SER FEITO AQUI MEU CHAPA";
            }
        }
        else
        {   echo "<br> ****Inicia Segundo Método**** <br> ";
            algoritmoSimplexMetodo2($tabelaSimplex, $VB, $VNB);
        }
    }

    function algoritmoSimplexMetodo2($tabelaSimplex, $VB, $VNB)
    {
        $colunaPermitida = null;

        //PERCORRE A F(X) PROCURANDO UM VALOR POSITIVO 
        for($i=1;$i<count($tabelaSimplex);$i++)
        {
            $tabelaSimplex[0][$i];
            //SE ENCONTRA O VALOR POSITIVO ELE SALVA O NUMERO DA COLUNA
            if($tabelaSimplex[0][$i] > 0)
            {
                $colunaPermitida = $i;
                echo "Valor Positivo da f(x): ".$tabelaSimplex[0][$i]."<br>";
                $i = count($tabelaSimplex);
            }
        }

        //SE VALOR POSITIVO É ENCONTRADO ENTAO ELE PROCURA OUTRO VALOR POSITIVO 
        // NA MESMA COLUNA ONDE O VALOR POSITIVO ANTERIOR FOI ENCONTRADO
        if($colunaPermitida != null)
        {
            $positivoExiste = false;

            for($i=1;$i<count($tabelaSimplex);$i++)
            {
                if($tabelaSimplex[$i][$colunaPermitida] > 0)
                { 
                    echo "Valor positivo na mesma linha do membro livre encontrado: ".$tabelaSimplex[$i][$colunaPermitida]."<br>";
                    $positivoExiste=true;
                    $i = count($tabelaSimplex);
                }
            }
            
            //SE ENCONTRAR UM VALOR POSITVO NA MESMA COLUNA ELE PROCURA O MENOR VALOR
            //DE QUOCIENTE DIVIDINDO O VALOR DOS MEMBROS LIVRES PELOS VALORES DA COLUNA PERMITIDA
            if($positivoExiste == true)
            {
                $menorElemento = PHP_INT_MAX;

                for($i=1;$i<count($tabelaSimplex);$i++)
                {
                    //VERIFICA SE O SINAL DO DENOMINADOR E NUMERADOR SAO IGUAIS
                    if(($tabelaSimplex[$i][0] > 0 && $tabelaSimplex[$i][$colunaPermitida] > 0)|| ($tabelaSimplex[$i][0] < 0 && $tabelaSimplex[$i][$colunaPermitida] < 0))
                    {
                        $divisao = $tabelaSimplex[$i][0]/$tabelaSimplex[$i][$colunaPermitida];

                        if($divisao < $menorElemento)
                        {
                            $menorElemento = $divisao;
                            $linhaPermitida = $i;
                        }
                    }
                }

                echo "O menor valor de divisão encontrado foi ".$tabelaSimplex[$linhaPermitida][0]."/".$tabelaSimplex[$linhaPermitida][$colunaPermitida]."=".$menorElemento."<br>";
                echo "Linha Permitida: ".$VB[$linhaPermitida-1]."<br>";
                echo "Coluna Permitida: ".$VNB[$colunaPermitida-1]."<br>";
                algoritmoTroca($tabelaSimplex, $VB, $VNB, $linhaPermitida, $colunaPermitida);  
                        
            }
            else
            {
                echo "SOLUÇÃO ÓTIMA NAO EXISTE, A SOLUÇÃO É ILIMITADA";
            }
        }
        else
        {
            echo "SOLUÇÃO OTIMA ENCONTRADA";
        }
    }

    function algoritmoTroca($tabelaSimplex, $VB, $VNB, $linhaPermitida, $colunaPermitida)
    {
        $tabelaTroca=array();

        //AO ENCONTRAR O MENOR QUOCIENTE ENTRE AS DIVISOES CALCULA-SE O INVERSO DO ELEMENTO PERMITIDO
            $elementoPermitido = $tabelaSimplex[$linhaPermitida][$colunaPermitida];
            echo "Elemento Permitido: ".$elementoPermitido."<br>";
            $inversoElemento = 1/$elementoPermitido;
            echo "Elemento Permitido inverso: ".$inversoElemento."<br>";

            //multiplica a linha pelo inverso
            echo "Linha Permitida multiplicada pelo inverso do EP: <table border='1'><tr>";
            for($i=0; $i < count($tabelaSimplex[$linhaPermitida]); $i++)
            {
                if($i == $colunaPermitida)
                {
                    $tabelaTroca[$linhaPermitida][$i] = $inversoElemento;
                    echo "<td>".$tabelaTroca[$linhaPermitida][$i]."</td>";
                }
                else
                {
                    $tabelaTroca[$linhaPermitida][$i] = $tabelaSimplex[$linhaPermitida][$i]*$inversoElemento;
                    echo "<td>".$tabelaTroca[$linhaPermitida][$i]."</td>";
                } 
            }
            echo "</tr></table><br>";
            echo "Coluna Permitida multiplicada pelo negativo do EP inverso: <table border='1'>";
            //multiplica a coluna pelo negativo do inverso
            for($i=0; $i < count($tabelaSimplex); $i++)
            {
                if($i != $linhaPermitida)
                {
                    $tabelaTroca[$i][$colunaPermitida] = ($tabelaSimplex[$i][$colunaPermitida])*(-($inversoElemento));
                    echo "<tr><td>".$tabelaTroca[$i][$colunaPermitida]."</td></tr> ";
                }
            }
            echo "<table><br>";

            //MULTIPLICA A SCS DA COLUNA PELO ELEMENTO DA LINHA PERMITIDA DA MESMA COLUNA
            echo "Multiplica a SCS da coluna pelo elemento da linha permitida da mesma coluna:<br>";
            for($i=0; $i < count($tabelaSimplex); $i++)
            {
                for($j=0; $j < count($tabelaSimplex[$i]); $j++)
                {
                    if($i != $linhaPermitida && $j != $colunaPermitida)
                    {
                        $tabelaTroca[$i][$j] = ($tabelaSimplex[$linhaPermitida][$j])*($tabelaTroca[$i][$colunaPermitida]);
                        echo $tabelaSimplex[$linhaPermitida][$j]."*".$tabelaTroca[$i][$colunaPermitida]."=". $tabelaTroca[$i][$j]."<br>";
                    }
                }
                        
            }

            echo "Tabela SCS:";
            imprimeTabela($tabelaSimplex, $VB, $VNB);

            echo "Tabela SCI:";
            imprimeTabela($tabelaTroca, $VB, $VNB);
            echo "<br>";    

            $tabelaSimplexAux = array();

            //INVERTE A POSIÇAO DA VARIAVEL BASICA COM A POSICAO DA VARIAVEL NAO BASICA
            
            echo "Variavel não basica ".$VNB[$colunaPermitida-1]." troca com variavel basica: ".$VB[$linhaPermitida-1]."<br>";
            $aux = $VNB[$colunaPermitida-1];
            $VNB[$colunaPermitida-1] = $VB[$linhaPermitida-1];
            $VB[$linhaPermitida-1] = $aux;

            //INSERE A LINHA E COLUNA PERMITIDA NAS SCS DA NOVA TABELA
            for($i=0; $i < count($tabelaSimplex); $i++)
            {
                for($j=0; $j < count($tabelaSimplex[$i]); $j++)
                {
                    if($i == $linhaPermitida || $j == $colunaPermitida)
                    {
                        $tabelaSimplexAux[$i][$j] = $tabelaTroca[$i][$j];                                
                    }
                }
                            
            }

            //INSERE OS DEMAIS VALORES NA NOVA TABELA SOMANDO CADA SCS COM SUA RESPECTIVA SCI
            for($i=0; $i < count($tabelaSimplex); $i++)
            {
                for($j=0; $j < count($tabelaSimplex[$i]); $j++)
                {
                    if($i != $linhaPermitida && $j != $colunaPermitida)
                    {
                        $tabelaSimplexAux[$i][$j] = $tabelaSimplex[$i][$j]+$tabelaTroca[$i][$j];                        
                    }
                }
                            
            }

            echo "Nova tabela criada com a soma dos valores das SCS com as SCI: ";
            imprimeTabela($tabelaSimplexAux, $VB, $VNB);

            for($i=1;$i<count($tabelaSimplexAux);$i++)
            {
                if($tabelaSimplexAux[$i][0] < 0)
                {
                    $negativo = $tabelaSimplexAux[$i][0];
                }
            }

            if(isset($negativo))
            {   
                algoritmoSimplexMetodo1($tabelaSimplexAux, $VB, $VNB);
            }
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

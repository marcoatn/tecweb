$(document).ready(function () {
var num_variaveis = 0;
var num_restricoes = 0;
variaveis =  "";
restricoes = "";

    $('#addVariavelDecisao').click(function () {
        num_variaveis++;
        if(num_variaveis > 0)
        {
            $('#totalVariaveis').val(num_variaveis);
        }
        else
        {
            $('#totalVariaveis').val(0);
            num_variaveis = 0;
        }

        for(i = 0;i<num_variaveis;i++)
        {   
            var valor = $('#v'+(i+1)).val();

            if(valor != null)
            {
                variaveis = variaveis + "<input class='valores' type='text' id='v"+(i+1)+"' name='v"+(i+1)+"' value='"+valor+"'><span style='font-size:0.8em;'>x"+(i+1)+"</span> &nbsp;";
            }
            else
            {
                variaveis = variaveis + "<input class='valores' type='text' id='v"+(i+1)+"' name='v"+(i+1)+"'><span style='font-size:0.8em;'>x"+(i+1)+"</span> &nbsp;";
            }
            
        }
        exibeVariavelDecisao.innerHTML = variaveis;
        variaveis = "";
        return false;
    });

    $('#delVariavelDecisao').click(function () {
        num_variaveis--;
        if(num_variaveis > 0)
        {
            $('#totalVariaveis').val(num_variaveis);
        }
        else
        {
            $('#totalVariaveis').val(0);
            num_variaveis = 0;
        }

        for(i = 0;i<num_variaveis;i++)
        {   
            var valor = $('#v'+(i+1)).val();
            
            if(valor != null)
            {
                variaveis = variaveis + "<input class='valores' type='text' id='v"+(i+1)+"' name='v"+(i+1)+"' value='"+valor+"'><span style='font-size:0.8em;'>x"+(i+1)+"</span> &nbsp;";
            }
            else
            {
                variaveis = variaveis + "<input class='valores' type='text' id='v"+(i+1)+"' name='v"+(i+1)+"'><span style='font-size:0.8em;'>x"+(i+1)+"</span> &nbsp;";
            }
            
        }
        exibeVariavelDecisao.innerHTML = variaveis;
        variaveis = "";
        return false;
    });

    $('#addRestricao').click(function () {
        num_restricoes++;
        if(num_restricoes > 0)
        {
            $('#totalRestricoes').val(num_restricoes);
        }
        else
        {
            $('#totalRestricoes').val(0);
            num_restricoes=0;
        } 

        if(num_variaveis > 0)
        {
            for(j = 0; j< num_restricoes ;j++)
            {
                restricoes = restricoes + "Restrição "+(j+1)+": ";
                var valorTotal = $("#r"+(j+1)+"_total").val();
                var sinal = $("#r"+(j+1)).val();

                for(i = 0; i< num_variaveis ;i++)
                {
                    var valor = $('#r'+(j+1)+'_v'+(i+1)).val();
                    if(valor != null)
                    {
                        restricoes = restricoes + "<input class='valores' type='text' id='r"+(j+1)+"_v"+(i+1)+"' name='r"+(j+1)+"_v"+(i+1)+"' value='"+valor+"'><span style='font-size:0.8em;'>x"+(i+1)+"</span> &nbsp;";
                    }
                    else
                    {
                        restricoes = restricoes + "<input class='valores' type='text' id='r"+(j+1)+"_v"+(i+1)+"' name='r"+(j+1)+"_v"+(i+1)+"'><span style='font-size:0.8em;'>x"+(i+1)+"</span> &nbsp;";
                    }
                }

                restricoes = restricoes + "<select id='r"+(j+1)+"' name='r"+(j+1)+"'><option value=''></option>";

                if(sinal == '=')
                {
                    restricoes = restricoes + "<option value='=' selected>=</option>";
                }
                else
                {
                    restricoes = restricoes + "<option value='='>=</option>";
                }
                
                if(sinal == '>=')
                {
                    restricoes = restricoes + "<option value='>=' selected>>=</option>";
                }
                else
                {   
                    restricoes = restricoes + "<option value='>='>>=</option>";
                }
                
                if(sinal == "<=")
                {
                   restricoes = restricoes + "<option value='<=' selected><=</option>";
                }
                else
                {
                    restricoes = restricoes + "<option value='<='><=</option>";
                }

                if(valorTotal != null)
                {
                    restricoes = restricoes + "</select> &nbsp <input class='valores' type='text' id='r"+(j+1)+"_total' name='r"+(j+1)+"_total' value='"+valorTotal+"'><br><br>";
                }
                else
                {
                    restricoes = restricoes + "</select> &nbsp <input class='valores' type='text' id='r"+(j+1)+"_total' name='r"+(j+1)+"_total'><br><br>";
                }
                
            }
            exibeRestricoes.innerHTML = restricoes;
            restricoes = "";
        }
        else
        {
            alert('Informe primeiramente as variaveis de decisão.');
        }
        return false;
    });

    $('#delRestricao').click(function () {
        num_restricoes--;

        if(num_restricoes > 0)
        {
            $('#totalRestricoes').val(num_restricoes);
        }
        else
        {
            $('#totalRestricoes').val(0);
            num_restricoes=0;
        } 

        if( num_restricoes <= 0)
        {
            exibeRestricoes.innerHTML ="";
        }
        else
        {
            if(num_restricoes > 0)
            {
                for(j = 0; j< num_restricoes ;j++)
                {
                    restricoes = restricoes + "Restrição "+(j+1)+": ";
                    var sinal = $("#r"+(j+1)).val();
                    var valorTotal = $("#r"+(j+1)+"_total").val();
                    
                    for(i = 0; i< num_variaveis ;i++)
                    {
                        var valor = $('#r'+(j+1)+'_v'+(i+1)).val();
                        if(valor != null)
                        {
                            restricoes = restricoes + "<input class='valores' type='text' id='r"+(j+1)+"_v"+(i+1)+"' name='r"+(j+1)+"_v"+(i+1)+"' value='"+valor+"'><span style='font-size:0.8em;'>x"+(i+1)+"</span> &nbsp;";
                        }
                        else
                        {
                            restricoes = restricoes + "<input class='valores' type='text' id='r"+(j+1)+"_v"+(i+1)+"' name='r"+(j+1)+"_v"+(i+1)+"'><span style='font-size:0.8em;'>x"+(i+1)+"</span> &nbsp;";
                        }
                    }
                    
                    restricoes = restricoes + "<select id='r"+(j+1)+"' name='r"+(j+1)+"'><option value=''></option>";
                
                    if(sinal == '=')
                    {
                        restricoes = restricoes + "<option value='=' selected>=</option>";
                    }
                    else
                    {
                        restricoes = restricoes + "<option value='='>=</option>";
                    }
                    
                    if(sinal == '>=')
                    {
                        restricoes = restricoes + "<option value='>=' selected>>=</option>";
                    }
                    else
                    {   
                        restricoes = restricoes + "<option value='>='>>=</option>";
                    }
                    
                    if(sinal == "<=")
                    {
                    restricoes = restricoes + "<option value='<=' selected><=</option>";
                    }
                    else
                    {
                        restricoes = restricoes + "<option value='<='><=</option>";
                    }

                    if(valorTotal != null)
                    {
                        restricoes = restricoes + "</select> &nbsp <input class='valores' type='text' id='r"+(j+1)+"_total' name='r"+(j+1)+"_total' value='"+valorTotal+"'><br><br>";
                    }
                    else
                    {
                        restricoes = restricoes + "</select> &nbsp <input class='valores' type='text' id='r"+(j+1)+"_total' name='r"+(j+1)+"_total'><br><br>";
                    }
                }

                exibeRestricoes.innerHTML = restricoes;
                restricoes = "";                         
            }
        }

        return false;
        
    });

});

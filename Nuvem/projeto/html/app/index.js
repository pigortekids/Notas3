document.getElementById('butaumLivros').addEventListener('click', function(){
    var colunas = ['Nome', 'Autor', 'Genero'];
    geraTabela('livro', colunas);
});


function geraTabela(elemento, colunas)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        //if (this.readyState == 4 && this.status == 200) {
		if (xhttp.responseText != ''){
            var jaison = JSON.parse(xhttp.responseText);
            var tabela = document.getElementById('tabela');

            //limpa linhas e colunas da tabela
            while (tabela.rows.length > 0){
                tabela.deleteRow(-1);
            }

            //adiciona primeira linha
            var tr = document.createElement('tr');
            tabela.appendChild(tr);

            //adiciona e edita todos os valores da tabela
            for(i = 0; i < colunas.length; i++){
                var td = document.createElement('td');
                tr.appendChild(td);
                tabela.getElementsByTagName('td')[i].innerHTML = colunas[i].toUpperCase();
                tabela.getElementsByTagName('td')[i].style.textAlign = 'center';
                tabela.getElementsByTagName('td')[i].style.width = '148px';
                tabela.getElementsByTagName('td')[i].style.height = '24px';
                tabela.getElementsByTagName('td')[i].style.font = 'normal normal 14px Special Elite,display';
            }

            for (i in jaison){
                var linha = tabela.insertRow(-1);
                for(j = 0; j < colunas.length; j++){
                    var celula = linha.insertCell(j);
                    celula.style.textAlign = 'center';
                    celula.style.height = '30px';
                    celula.style.font = 'normal normal 12px Special Elite,display';
                    var key = colunas[j].toLowerCase().replace(' ', '_');
                    var texto  = document.createTextNode(jaison[i][key]);
                    celula.appendChild(texto);
                }
            }
        }
    };

    var senha = document.getElementById('senha').value;
    xhttp.open('GET', 'http://localhost:8081/public/index.php/v1/livro/' + senha);
    //xhttp.setRequestHeader('Content-Type', 'application/json');
    xhttp.send();
}
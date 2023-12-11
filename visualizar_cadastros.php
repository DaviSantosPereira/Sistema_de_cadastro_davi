<?php
// Configuração das variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aposta_php";

// Cria uma nova conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve algum erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se um pedido de DELETE foi recebido via GET
if (isset($_GET['delete'])) {
    $id = $_GET['delete']; // Pega o ID do registro a ser deletado
    $conn->query("DELETE FROM usuarios WHERE id = $id"); // Executa a query de DELETE
    header("Location: visualizar_cadastros.php"); // Redireciona para a página de visualização
}

// Processa as atualizações de dados enviadas via POST 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // ID do registro a ser atualizado
    $column = $_POST['column']; // Coluna a ser atualizada
    $value = $_POST['value']; // Novo valor para a coluna

    // Prepara e executa a query de UPDATE
    $sql = "UPDATE usuarios SET ".$column."='".$conn->real_escape_string($value)."' WHERE id=".$id;
    if ($conn->query($sql) === TRUE) {
        echo "Registro atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar o registro: " . $conn->error;
    }
    exit; // Encerra a execução para evitar carregamento adicional do HTML abaixo
}

// Consulta para obter os registros de usuários
$sql = "SELECT id, sexo, cpf, nome, sobrenome, DATE_FORMAT(nascimento, '%d/%m/%Y') as nascimento, nomeusuario, senha, email, telefone, cod FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Visualizar Cadastros</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
    // Funções JavaScript para habilitar edição in-place e enviar atualizações 

    // Habilita a edição de conteúdo das células da tabela
    function enableEditing(id) {
        var idCell = document.getElementById('id-' + id);
        var nomeCell = document.getElementById('nome-' + id);
        var sobrenomeCell = document.getElementById('sobrenome-' + id);
        var nomeusuarioCell = document.getElementById('nomeusuario-' + id);
        var cpfCell = document.getElementById('cpf-' + id);
        var sexoCell = document.getElementById('sexo-' + id);
        var nascimentoCell = document.getElementById('nascimento-' + id);
        var telefoneCell = document.getElementById('telefone-' + id);
        var emailCell = document.getElementById('email-' + id);
        var senhaCell = document.getElementById('senha-' + id);
        var codCell = document.getElementById('cod-' + id);
        idCell.contentEditable = false;
        nomeCell.contentEditable = true;
        sobrenomeCell.contentEditable = true;
        nomeusuarioCell.contentEditable = true;
        cpfCell.contentEditable = false;
        sexoCell.contentEditable = true;
        nascimentoCell.contentEditable = false;
        telefoneCell.contentEditable = true;
        emailCell.contentEditable = true;
        senhaCell.contentEditable = false;
        codCell.contentEditable = false;
        nameCell.focus();
    }

    // Envia os dados atualizados para o servidor 
    function updateData(element, column, id) {
        var value = element.innerText;
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "visualizar_cadastros.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("value=" + value + "&column=" + column + "&id=" + id);
    }

    // Função para solicitar a exclusão de um registro
    function deleteRow(id) {
        var confirmDelete = confirm("Tem certeza que deseja excluir este registro?");
        if (confirmDelete) {
            window.location.href = 'visualizar_cadastros.php?delete=' + id;
        }
    }
    </script>
</head>
<body>
<div id="card">
    <img src="img/cartinha.png" alt="Tigrinho">
    <h1>Visualizar Cadastros</h1>

    <?php
    // Exibe os registros em uma tabela HTML
    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>Nome</th><th>Sobrenome</th><th>Nome de Usúario</th><th>CPF</th><th>Sexo</th><th>Data de Nascimento</th><th>Telefone</th><th>Email</th><th>Senha</th><th>Código de Indicação</th><th>Ações</th></tr>";
        // Itera por cada registro retornado
        while($row = $result->fetch_assoc()) {
            // Exibe cada linha com os dados e botões de ação
            echo "<tr><td id='id-" . $row["id"] . "' onBlur='updateData(this, \"id\", ".$row["id"].")'>" . $row["id"]. "</td>
            <td id='nome-" . $row["id"] . "' onBlur='updateData(this, \"nome\", ".$row["id"].")'>" . $row["nome"]. "</td>
            <td id='sobrenome-" . $row["id"] . "' onBlur='updateData(this, \"sobrenome\", ".$row["id"].")'>" . $row["sobrenome"]. "</td>
            <td id='nomeusuario-" . $row["id"] . "' onBlur='updateData(this, \"nomeusuario\", ".$row["id"].")'>" . $row["nomeusuario"]. "</td>
            <td id='cpf-" . $row["id"] . "' onBlur='updateData(this, \"cpf\", ".$row["id"].")'>" . $row["cpf"]. "</td>
            <td id='sexo-" . $row["id"] . "' onBlur='updateData(this, \"sexo\", ".$row["id"].")'>" . $row["sexo"]. "</td>
            <td id='nascimento-" . $row["id"] . "' onBlur='updateData(this, \"nascimento\", ".$row["id"].")'>" . $row["nascimento"]. "</td>
            <td id='telefone-" . $row["id"] . "' onBlur='updateData(this, \"telefone\", ".$row["id"].")'>" . $row["telefone"]. "</td>
            <td id='email-" . $row["id"] . "' onBlur='updateData(this, \"email\", ".$row["id"].")'>" . $row["email"]. "</td>
            <td id='senha-" . $row["id"] . "' onBlur='updateData(this, \"senha\", ".$row["id"].")'>" . $row["senha"]. "</td>
            <td id='cod-" . $row["id"] . "' onBlur='updateData(this, \"cod\", ".$row["id"].")'>" . $row["cod"]. "</td> <td>";
            echo "<button onClick='enableEditing(".$row["id"].")'>✏️</button> ";
            echo "<button onClick='deleteRow(".$row["id"].")'>❌</button>";
            echo "</td></tr>";

        }
        echo "</table> <br/> <tr> <th> Ao clicar no ✏️, ele habilita o edite nás aréas (Nome, Sobrenome, Nome do Usuário, Sexo, Telefone e Email). </th> </tr> <br/>
        <tr> <th> Ao clicar no ❌, você exclui aquele registro. </th> </tr> <br/> <br/>  ";
    } else {
        echo "Ainda não há cadastro... <br/> <br/>";
        
    }
    ?>

    <a href="cadastro.php" class="btn-retorno"> Ir ao Cadastro</a>
    <br/>
    <a href="index.php" class="btn-retorno"> Voltar </a> 
</div>
</body>
</html>

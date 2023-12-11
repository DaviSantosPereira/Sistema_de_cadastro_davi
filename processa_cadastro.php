<?php
session_start(); // Inicia a sessão

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar com o banco de dados
    $servername = "localhost"; // ou o endereço do seu servidor de banco de dados
    $username = "root";    // seu nome de usuário do banco de dados
    $password = "";    // sua senha do banco de dados
    $dbname = "aposta_php"; // nome do banco de dados

    // Criar conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        $mensagem = "Conexão falhou: " . $conn->connect_error;
    }


    // Coletar dados do formulário
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $cpf = $conn->real_escape_string($_POST['cpf']);
    $nome = $conn->real_escape_string($_POST['nome']); 
    $sobrenome = $conn->real_escape_string($_POST['sobrenome']); 
    $nascimento = $conn->real_escape_string($_POST['nascimento']); 
    $nomeusuario = $conn->real_escape_string($_POST['nomeusuario']); 
    $senha = $conn->real_escape_string($_POST['senha']); 
    $email = $conn->real_escape_string($_POST['mail']); 
    $telefone = $conn->real_escape_string($_POST['telefone']); 
    $cod = $conn->real_escape_string($_POST['cod']); 

    
    // Criar o comando SQL para inserir os dados
    $sql = "INSERT INTO usuarios (sexo, cpf, nome, sobrenome, nascimento, nomeusuario, senha, email, telefone, cod) VALUES ('$sexo', '$cpf', '$nome', '$sobrenome', '$nascimento', '$nomeusuario', '$senha', '$email', '$telefone', '$cod')";

    // Executar o comando SQL
    if ($conn->query($sql) === TRUE) {
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao realizar cadastro: " . $conn->error;
    }
    // Fechar conexão
    $conn->close();

    // Redireciona para a página do formulário
    header("Location: cadastro.php");
    exit;
}
?>

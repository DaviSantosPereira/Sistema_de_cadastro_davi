<?php
session_start(); // Inicia a sessão PHP, o que é necessário para utilizar variáveis de sessão.

$erro = ""; // Inicializa a variável de erro como uma string vazia.

// Verifica se o método de requisição é POST, o que normalmente indica que o formulário foi enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se as senhas conferem.
     if ($_POST['senha'] !== $_POST['senha_confirmacao']) {
        $erro = "As senhas não coincidem. Por favor, tente novamente."; // Define a mensagem de senhas não coincidem
    } else {
        require_once "processa_cadastro.php"; // Inclui o arquivo que processa o cadastro se todos os campos estiverem preenchidos.
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="estilos.css"> <!-- Link para o arquivo CSS externo -->
    <title>Cadastro</title>

    <script>
        function validarFormulario() {
            // Obter valores das senhas
            var senha = document.getElementById('senha').value;
            var senhaConfirmacao = document.getElementById('senha_confirmacao').value;

            // Verificar se as senhas coincidem
            if (senha !== senhaConfirmacao) {
                // Exibir alerta
                alert("As senhas não coincidem. Por favor, verifique.");

                // Impedir o envio do formulário
                return false;
            }

            // Continuar com o envio do formulário se as senhas coincidirem
            return true;
        }
    </script>

</head>

<body>

<div id="card">
   
    <img src="img/cartinha.png" alt="Tigrinho">
    <h1>Cadastro de Usuário</h1>
   
    
    <!-- Formulário de cadastro. O action está configurado para enviar os dados para a mesma página. -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validarFormulario();">
        <!-- Campos de nome, e-mail e senha -->

            <label> Sexo: </label>
            <label> <input type="radio" id="sexo" name="sexo" value="M" required /> Masculino </label>
            <label> <input type="radio" id="sexo" name="sexo" value="F" required /> Feminino </label>
     
            <br/>
            <label> CPF: </label>
            <input type="text" name="cpf" id="cpf" required placeholder="Ex: xxxxxxxxx-xx" maxlength="12" />

            <label> Nome: </label>
            <input type="text" name="nome" id="nome" placeholder="Ex: Exemplo" required />

            <label> Sobrenome: </label>
            <input type="text" name="sobrenome" id="sobrenome" placeholder="Ex: Da Exemplagem" required />
            
            <label> Data De Nascimento: </label>
            <input type="date" name="nascimento" id="nascimento"  required />
       
            <label> Nome do Usuario: </label>
            <input type="text" name="nomeusuario" id="nomeusuario" placeholder="Ex: Exemplo123" required />

            <label> Senha: </label>
            <input type="password" name="senha" id="senha" placeholder="Ex: xxx" required />

            <label> Confirme a Senha: </label>
            <input type="password" name="senha_confirmacao" id="senha_confirmacao" placeholder="Ex: xxx" required />

            <label> Email: </label>
            <input type="email" name="mail" id="mail" placeholder="Ex: Exempllo@gmail.com" required />
           
            <label> Telefone: </label>
            <input type="text" name="telefone" id="telefone" placeholder="Ex: (xx) xxxxxxxxx" required />
           
            <label> Codigo De Indicação: </label>
            <input type="text" name="cod" id="cod" placeholder="Ex: IndicadoPorExemplo" />
        <input type="submit" value="Cadastrar"> <!-- Botão de envio do formulário -->
    </form>
    <!-- Link para visualizar cadastros -->
    <a href="visualizar_cadastros.php" class="btn">Visualizar Cadastros</a>
    <a href="index.php" class="btn"> Voltar </a> 
  
    
    <?php 
        // Verifica se há uma mensagem de erro para exibir.
        if (!empty($erro)): ?>
            <div class="mensagem">
                <?php echo $erro; // Exibe a mensagem de erro ?>
            </div>
        <?php 
        // Verifica se existe uma mensagem na sessão e se ela não está vazia.
        elseif (isset($_SESSION['mensagem']) && !empty($_SESSION['mensagem'])): ?>
            <div class="mensagem">
                <?php 
                echo $_SESSION['mensagem']; // Exibe a mensagem da sessão.
                unset($_SESSION['mensagem']); // Limpa a mensagem da sessão.
                ?>
            </div>

<?php endif; ?>

</body>
</html>

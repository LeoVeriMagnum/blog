<html>

<head>
    <title>Usuário | Projeto para Web com PHP</title>
    <link rel="stylesheet" href="lib/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include 'includes/topo.php'; ?>
            </div>
        </div>
        <div class="row" style="min-height: 500px;">
            <div class="col-md-12">
                <?php include 'includes/menu.php'; ?>
            </div>
            <div class="col-md-12" style="padding-top: 50px;">
                <?php
                require_once 'includes/funcoes.php';
                require_once 'core/conexao_mysql.php';
                require_once 'core/sql.php';
                require_once 'core/mysql.php';

                if (isset($_SESSION['login'])) {
                    // verifica se está logado
                    $id = (int) $_SESSION['login']['usuario']['id'];

                    $criterio = [
                        ['id', '=', $id]
                    ];

                    $retorno = buscar(
                        // busca dados do usuário 
                        'usuario',
                        ['id', 'nome', 'email'],
                        $criterio
                    );

                    $entidade = $retorno[0];
                }
                ?>
                <h2>Usuário</h2>
                <form action="core/usuario_repositorio.php" method="post">
                    <input type="hidden" name="acao" value="<?php echo empty($id) ? 'insert' : 'update' ?>">
                    <!-- se usuário estiver logado, ele altera dados. Caso não, ele pode criar uma conta -->
                    <input type="hidden" name="id" value="<?php echo $entidade['id'] ?? '' ?>">
                    <!-- ?? é um if binário -->
                    <!-- Como uma ?, se a primeira condição for verdadeira, executa a primeira. Caso falso, executa a segunda -->
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" class="form-control" required value="<?php echo $entidade['nome'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" id="email" class="form-control" required value="<?php echo $entidade['email'] ?? '' ?>">
                    </div>
                    <?php if (!isset($_SESSION['login'])) : ?>
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" id="senha" class="form-control" required>
                        </div>
                    <?php endif; ?>
                    <div class="text-right">
                        <button type="submit" class="btn btn-sucess">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                include 'includes/rodape.php'
                ?>
            </div>
        </div>
    </div>
    <script src="lib/js/bootstrap.min.js"></script>
</body>

</html>
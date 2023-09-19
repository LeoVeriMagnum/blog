<!DOCTYPE html>
<html>

<head>
    <title> Página inicial | Projeto para Web com PHP</title>
    <link rel="stylesheet" href="lib/css/bootstrap.min.css">
</head>

<body >
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                include 'includes/topo.php';
                ?>
                <!-- Topo -->
            </div>
        </div>
        <div class="row" style="min-height: 500px;">
            <div class="col-md-12">
                <?php
                include 'includes/menu.php';
                ?>
                <!-- Menu -->
            </div>
            <div class="col-md-12" style="padding-top: 50px;">
                <h2>Página Inicial</h2>
                <?php
                include 'includes/busca.php';
                ?>
                <!-- Busca -->

                <?php
                date_default_timezone_set('America/Sao_Paulo');
                require_once 'includes/funcoes.php';
                require_once 'core/conexao_mysql.php';
                require_once 'core/sql.php';
                require_once 'core/mysql.php';

                foreach ($_GET as $indice => $dado) {
                    $$indice = limparDados($dado);
                }

                $data_atual = date('Y-m-d H:i:s');
                // é a forma mais fácil de ordenar uma data, pois em caso de ordenação, 
                // o ano é o primeiro parametro a ser verificado, assim, ano>mes>dia 

                // busca o horário do servidor

                $criterio = [
                    ['data_postagem', '<=', $data_atual]
                ];

                if (!empty($busca)) {
                    $criterio[] = [
                        'AND',
                        'titulo',
                        'like',
                        // like é para buscar em qualquer parte do post.
                        "%{$busca}%"
                        // refere-se ao campo de nome busca, para ver se ele está preenchido
                    ];
                }

                $posts = buscar(
                    'post',
                    [
                        'titulo',
                        'data_postagem',
                        'id',
                        ' (select nome 
                                from usuario
                                where usuario.id = post.usuario_id) as nome'
                    ],
                    $criterio,
                    'data_postagem DESC'
                );
                ?>

                <div>
                    <div class="list-group">
                        <?php
                        foreach ($posts as $post) :
                            $data = date_create($post['data_postagem']);
                            $data = date_format($data, 'd/m/Y H:i:s');
                        ?>
                            <a class="list-group-item list-group-item-action" href="post_detalhe.php?post=<?php echo $post['id'] ?>">
                                <strong><?php echo $post['titulo'] ?></strong>
                                [<?php echo $post['nome'] ?>]
                                <span class="badge badge-dark"><?php echo $data ?></span>
                            </a>

                            <?php if ((isset($_SESSION['login'])) //se retirar o &&, pode-se adicionar opções só para quem está logado;
                                && ($_SESSION['login']['usuario']['adm'] === 1)
                            ) : ?>
                                <!-- ops de admin -->
                                <a href="core/post_repositorio.php?acao=delete&id=<?php echo $post['id'] ?>" class="bg-danger text-white text-center"> Deletar</a>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                include 'includes/rodape.php';
                ?>
            </div>
        </div>
    </div>
    <script src="lib/js/bootstrap.min.js"></script>
</body>

</html>
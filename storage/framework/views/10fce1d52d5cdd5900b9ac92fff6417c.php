<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Ciência</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .timbre {
            width: 60%; /* Redimensiona a imagem para 60% do tamanho original */
            margin: 20px auto; /* Centraliza a imagem e adiciona margem em cima e embaixo */
        }

        .timbre img {
            width: 100%;
            height: auto;
        }

        h2 {
            text-align: center;
            margin-top: 20px; /* Ajusta o espaçamento entre o timbre e o título */
            margin-bottom: 20px;
        }

        .container {
            width: 100%;
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Ajusta o espaçamento entre o título e a tabela */
        }

        .table td,
        .table th {
            padding: 10px;
            border: 1px solid #000;
            text-align: center;
            text-transform: uppercase; /* Transforma as letras em maiúsculas */
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table td:first-child {
            text-align: left; /* Alinha a coluna "Nome" à esquerda */
        }

        .signature {
            width: 300px;
            border-top: 1px solid #000;
            margin-top: 10px;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Timbre (imagem) -->
    <div class="timbre">
        <img src="<?php echo e(public_path('images/timbre.png')); ?>" alt="Timbre">
    </div>

    <!-- Título -->
    <h2>Informativo referente a <?php echo e($referente); ?></h2>

    <!-- Tabela de Funcionários -->
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Matrícula</th>
                    <th>Assinatura</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $funcionarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcionario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($funcionario->nome); ?></td>
                        <td><?php echo e($funcionario->matricula); ?></td>
                        <td class="signature"></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\sisedu\resources\views/gerar_ciencia.blade.php ENDPATH**/ ?>
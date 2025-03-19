<?php $__env->startSection('title', 'Cadastrar Funcionário'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Cadastrar Funcionário</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('funcionarios.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" value="<?php echo e(old('nome')); ?>" required>
        </div>

        <div class="form-group">
            <label for="matricula">Matrícula</label>
            <input type="text" name="matricula" class="form-control" value="<?php echo e(old('matricula')); ?>" required>
        </div>

        <div class="form-group">
    <label for="cargo">Cargo</label>
    <select id="cargo" name="cargo_id" class="form-control" required>
        <?php $__currentLoopData = $cargos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cargo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cargo->id); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $cargo->nome))); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

        <div class="form-group">
            <label for="tipo_funcionario">Tipo de Funcionário</label>
            <select id="tipo_funcionario" name="tipo_funcionario" class="form-control" required>
                <option value="0">Concursado</option>
                <option value="1">Terceirizado</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <strong>Feito por Alex Messias  <a href="https://adminlte.io">SisEdu</a>.</strong>
    
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sisedu\resources\views/funcionarios/create.blade.php ENDPATH**/ ?>
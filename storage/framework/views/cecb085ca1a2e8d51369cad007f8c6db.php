<?php $__env->startSection('title', isset($funcionario) ? 'Editar Funcionário' : 'Cadastrar Funcionário'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><?php echo e(isset($funcionario) ? 'Editar Funcionário' : 'Cadastrar Funcionário'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(isset($funcionario) ? route('funcionarios.update', $funcionario->id) : route('funcionarios.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if(isset($funcionario)): ?>
            <?php echo method_field('PUT'); ?> <!-- Necessário para atualização -->
        <?php endif; ?>
        
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" value="<?php echo e(old('nome', $funcionario->nome ?? '')); ?>" required>
        </div>

        <div class="form-group">
            <label for="matricula">Matrícula</label>
            <input type="text" name="matricula" class="form-control" value="<?php echo e(old('matricula', $funcionario->matricula ?? '')); ?>" required>
        </div>

        <div class="form-group">
            <label for="cargo_id">Cargo</label>
            <select id="cargo_id" name="cargo_id" class="form-control" required>
                <?php $__currentLoopData = $cargos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cargo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cargo->id); ?>"
                        <?php if(old('cargo_id', $funcionario->cargo_id ?? '') == $cargo->id): ?> selected <?php endif; ?>
                        data-nome="<?php echo e($cargo->nome); ?>">
                        <?php echo e($cargo->nome); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="form-group" id="turno-group">
            <label for="turno">Turno</label>
            <select id="turno" name="turno_id" class="form-control" required>
                <option value="1" <?php if(old('turno_id', $funcionario->turno_id ?? 3) == 3): ?> selected <?php endif; ?>>Integral</option>
                <option value="2" <?php if(old('turno_id', $funcionario->turno_id ?? '') == 1): ?> selected <?php endif; ?>>Manhã</option>
                <option value="3" <?php if(old('turno_id', $funcionario->turno_id ?? '') == 2): ?> selected <?php endif; ?>>Tarde</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_funcionario">Tipo de Funcionário</label>
            <select id="tipo_funcionario" name="tipo_funcionario" class="form-control" required>
                <option value="0" <?php echo e(old('tipo_funcionario', $funcionario->tipo_funcionario ?? '') == 0 ? 'selected' : ''); ?>>Concursado</option>
                <option value="1" <?php echo e(old('tipo_funcionario', $funcionario->tipo_funcionario ?? '') == 1 ? 'selected' : ''); ?>>Terceirizado</option>
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

<?php $__env->startSection('js'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var cargoSelect = document.getElementById('cargo_id');
    var turnoGroup = document.getElementById('turno-group');
    var turnoSelect = document.getElementById('turno');

    function toggleTurnoField() {
        var selectedCargoId = cargoSelect.options[cargoSelect.selectedIndex].value;
        
        if (selectedCargoId === '8') { // Professor 20h
            turnoGroup.style.display = 'block'; 
            turnoSelect.innerHTML = ` 
                <option value="1">Manhã</option>
                <option value="2">Tarde</option>
            `;

            // Se o turno atual não for válido, define um padrão
            if (![1, 2].includes(parseInt(turnoSelect.value))) {
                turnoSelect.value = "1"; // Manhã como padrão
            }
        } else {
            turnoGroup.style.display = 'none';
            
            // Garante que o turno seja enviado corretamente
            turnoSelect.innerHTML = `
                <option value="3" selected>Integral</option>
            `;
        }
    }

    toggleTurnoField();
    cargoSelect.addEventListener('change', toggleTurnoField);
});

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sisedu\resources\views/funcionarios/create.blade.php ENDPATH**/ ?>
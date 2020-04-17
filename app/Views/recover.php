<h3>Criar nova senha</h3>

<form action="<?php echo base_url('user/recover') ?>" method="post">
    <div class="input-field">
        <input type="password" id="regPassword" name="password" minlength="8" class="validate" required />
        <label for="regPassword">Senha</label>
        <span class="helper-text" data-error="A senha deve conter no mínimo 8 caracteres" data-success="Para sua segurança, use uma senha complexa">Digite uma senha segura</span>
    </div>
    <div class="input-field">
        <input type="password" id="confirm" name="confirm" required />
        <label for="confirm">Confirmar senha</label>
        <span id="confirmHelper" class="helper-text" data-error="As senhas não conferem" data-success="Senhas conferem">Confirme a sua senha</span>
    </div>
    <div class="input-field">
        <button type="submit" class="waves-effect waves-light btn">Enviar</button>
        <a href="<?php echo base_url(); ?>" class="waves-effect waves-light red btn right">Voltar</a>
    </div>
</form>
<?php require 'head.php'; ?>

<header>
    <nav>
        <div class="nav-wrapper">
            <a href="<?php echo base_url(); ?>" class="brand-logo">ForumLog</a>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>

            <ul id="nav-desktop" class="right hide-on-med-and-down">
                <li><a href="<?php echo base_url('home/forum'); ?>">Forum</a></li>
                <li><a href="<?php echo base_url('home/blog'); ?>">Blog</a></li>
                <li><a href="<?php echo base_url('home/about'); ?>">Sobre</a></li>
                <li class="teal darken-2"><a href="#modalLogin" class="waves-effect waves-light white-text modal-trigger">Login</a></li>
            </ul>
        </div>
    </nav>
    
    <ul id="nav-mobile" class="sidenav">
        <li><a href="<?php echo base_url('home/forum'); ?>">Forum</a></li>
        <li><a href="<?php echo base_url('home/blog'); ?>">Blog</a></li>
        <li><a href="<?php echo base_url('home/about'); ?>">Sobre</a></li>
        <li class="teal darken-2"><a href="#modalLogin" class="white-text">Login</a></li>
    </ul>

    <div id="modalLogin" class="modal">
        <div class="modal-content">
            <h4>Login</h4>
            <form action="<?php echo base_url('user/login'); ?>" method="post">
                <div class="input-field">
                    <input type="text" id="login" name="login" class="validate" required />
                    <label for="login">Login</label>
                </div>
                <div class="input-field">
                    <input type="password" id="password" name="password" class="validate" required />
                    <label for="password">Senha</label>
                </div>
                <div class="input-field">
                    <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                    <a href="<?php echo base_url('user/register'); ?>" class="waves-effect waves-light btn">Cadastre-se</a>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn red">Cancelar</a>
        </div>
    </div>
</header>

<div class="container">
    <main>
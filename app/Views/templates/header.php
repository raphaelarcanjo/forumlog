<?php require 'head.php'; ?>

<header>
    <nav>
        <div class="nav-wrapper">
            <a href="<?php echo base_url(); ?>" class="brand-logo">
                <img src="<?php echo base_url(); ?>/assets/img/logo-rgba.png" alt="ForumLog">
            </a>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>

            <ul id="nav-desktop" class="right hide-on-med-and-down">
                <li class="<?php echo($title == 'Home') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="<?php echo($title == 'Forum') ? 'active' : ''; ?>"><a href="<?php echo base_url('home/forum'); ?>">Forum</a></li>
                <li class="<?php echo($title == 'Blog') ? 'active' : ''; ?>"><a href="<?php echo base_url('home/blog'); ?>">Blog</a></li>
                <li class="<?php echo($title == 'Sobre') ? 'active' : ''; ?>"><a href="<?php echo base_url('home/about'); ?>">Sobre</a></li>
                <li>
                    <a href="#modalLogin" class="modal-trigger">
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <ul id="nav-mobile" class="sidenav">
        <li class="<?php echo($title == 'Home') ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>">Home</a></li>
        <li class="<?php echo($title == 'Forum') ? 'active' : ''; ?>"><a href="<?php echo base_url('home/forum'); ?>">Forum</a></li>
        <li class="<?php echo($title == 'Blog') ? 'active' : ''; ?>"><a href="<?php echo base_url('home/blog'); ?>">Blog</a></li>
        <li class="<?php echo($title == 'Sobre') ? 'active' : ''; ?>"><a href="<?php echo base_url('home/about'); ?>">Sobre</a></li>
        <li>
            <a href="#!" class="dropdown-trigger" data-target="dropdownLogin">
                Login<i class="material-icons right">arrow_drop_down</i>
            </a>
        </li>
    </ul>

    <ul id="dropdownLogin" class="dropdown-content">
        <li>
            <h4>Login</h4>
        </li>
        <li>
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
                <a href="<?php echo base_url('user/recover'); ?>" class="waves-effect btn-flat">Esqueci a senha</a>
            </form>
        </li>
    </ul>

    <div id="modalLogin" class="modal">
        <div class="modal-content">
            <h4>Login</h4>
            <form action="<?php echo base_url('user/login'); ?>" method="post">
                <div class="input-field">
                    <label for="loginM">Login</label>
                    <input type="text" name="login" id="loginM" class="validate" required />
                </div>
                <div class="input-field">
                    <label for="passwordM">Senha</label>
                    <input type="password" name="password" id="passwordM" class="validate" required />
                </div>
                <div class="input-field">
                    <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                    <a href="<?php echo base_url('user/register'); ?>" class="waves-effect waves-light btn">Cadastre-se</a>
                </div>
                <a href="<?php echo base_url('user/recover'); ?>" class="waves-effect btn-flat">Esqueci a senha</a>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-light red btn">Cancelar</a>
        </div>
    </div>
</header>

<div class="container">
    <main>
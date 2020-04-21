</main>
</div>

<footer class="page-footer">
    @yield('footer')
    
    <div class="row">
        <div class="col s12 m4">
            <h4>LINKS</h4>
            <ul>
                <li><a href="{{url('forumlog/forum')}}" class="grey-text text-lighten-1">Forum</a></li>
                <li><a href="{{url('forumlog/blog')}}" class="grey-text text-lighten-1">Blog</a></li>
                <li><a href="{{url('forumlog/about')}}" class="grey-text text-lighten-1">Sobre</a></li>
                <li><a href="{{url('forumlog/user/register')}}" class="grey-text text-lighten-1">Cadastre-se</a></li>
            </ul>
        </div>
        <div class="col s12 m8">
            <h4>CONTATO</h4>
            <form action="{{url('forumlog/contact')}}" method="post">
                <div class="input-field">
                    <input type="text" id="name" name="name" class="validate" value="<?php echo (isset($name)) ? $name : ''; ?>" required />
                    <label for="name" class="grey-text text-lighten-1 <?php echo (isset($name)) ? 'active' : ''; ?>">Nome completo</label>
                </div>
                <div class="input-field">
                    <input type="email" id="email" name="email" class="validate" value="<?php echo (isset($email)) ? $email : ''; ?>" required />
                    <label for="email" class="grey-text text-lighten-1 <?php echo (isset($email)) ? 'active' : ''; ?>">Seu e-mail</label>
                </div>
                <div class="input-field">
                    <input type="text" id="subject" name="subject" class="validate" value="<?php echo (isset($subject)) ? $subject : ''; ?>" required />
                    <label for="subject" class="grey-text text-lighten-1 <?php echo (isset($subject)) ? 'active' : ''; ?>">Assunto da mensagem</label>
                </div>
                <div class="input-field">
                    <textarea id="message" name="message" class="materialize-textarea" required><?php echo (isset($message)) ? $message : ''; ?></textarea>
                    <label for="message" class="grey-text text-lighten-1 <?php echo (isset($message)) ? 'active' : ''; ?>">Deixe sua mensagem</label>
                </div>
                <div class="input-field">
                    <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="footer-copyright">
        <div class="container">
            &copy; 2020 Copyright <a href="https://github.com/raphaelarcanjo" class="grey-text text-lighten-2 right">Raphael Arcanjo</a>
        </div>
    </div>

    <!-- Polyfill script -->
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=es2015"></script>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script src="{{asset('js/script.js')}}"></script>
</footer>

</body>

</html>
</main>
</div>

<footer class="page-footer">
    @yield('footer')
    
    <div class="row">
        <div class="col s12 m4">
            <h4>LINKS</h4>

            <ul>
                <li><a href="{{url('forum')}}" class="grey-text text-lighten-1">Forum</a></li>
                <li><a href="{{url('blog')}}" class="grey-text text-lighten-1">Blog</a></li>
                <li><a href="{{url('about')}}" class="grey-text text-lighten-1">Sobre</a></li>
                <li><a href="{{url('user/register')}}" class="grey-text text-lighten-1">Cadastre-se</a></li>
            </ul>

            <div class="white red-text center-align col sm6">
                <h4>POWERED BY</h4>
                
                <img src="https://materializecss.com/res/materialize.svg" alt="" /><h5>Materialize</h5>
                <img src="https://laravel.com/img/logomark.min.svg" alt="" /><h5>Laravel</h5>
            </div>
        </div>
        <div class="col s12 m8">
            <h4>CONTATO</h4>
            <form action="{{url('contact')}}" method="post">
                @csrf
                <div class="input-field">
                    <input type="text" id="name" name="name" class="validate" required />
                    <label for="name" class="grey-text text-lighten-1">Nome completo</label>
                </div>
                <div class="input-field">
                    <input type="email" id="email" name="email" class="validate" required />
                    <label for="email" class="grey-text text-lighten-1">Seu e-mail</label>
                </div>
                <div class="input-field">
                    <input type="text" id="subject" name="subject" class="validate" required />
                    <label for="subject" class="grey-text text-lighten-1">Assunto da mensagem</label>
                </div>
                <div class="input-field">
                    <textarea id="message" name="message" class="materialize-textarea" required></textarea>
                    <label for="message" class="grey-text text-lighten-1">Deixe sua mensagem</label>
                </div>
                <div class="input-field">
                    <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="footer-copyright">
        <div class="container">
            &copy; 2020 Copyright <a href="https://github.com/raphaelarcanjo" target="_blank"class="grey-text text-lighten-2 right">Raphael Arcanjo</a>
        </div>
    </div>
</footer>
</div>

<script src="https://unpkg.com/jquery"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script src="{{asset('js/script.js?v=1.2')}}"></script>

</body>

</html>
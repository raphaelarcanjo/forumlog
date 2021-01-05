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

<script src="{{asset('js/script.js?v=1.5')}}"></script>

@auth
    <script type="text/javascript">
        $(document).ready(()=> {
            $('input.autocomplete').autocomplete({
                data: {
                    "{{Auth::user()->tagname}}": "{{url('public/users/'.Auth::user()->photo)}}",
                },
                onAutocomplete: function(tag) {
                    window.location.href = "{{url('blog')}}/" + tag
                }
            })

            $('input.autocomplete').keyup(function() {
                if ($('input.autocomplete').val().length >= 2) {
                    $.ajax({
                        type: 'get',
                        data: {
                            _token: "{{csrf_token()}}",
                            tag: $("input.autocomplete").val()
                        },
                        url: "{{url('user/getusers')}}",
                        success: function (data) {
                            $('input.autocomplete').autocomplete('updateData',JSON.parse(data));
                        }
                    })
                }
            })

            $("#search").keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault()
                return false
                }
            })
        })
    </script>
@endauth

</body>

</html>

</main>
</div>

<footer class="page-footer teal white-text darken-2">
    <div class="row">
        <div class="col s12 m4">
            <h4>LINKS</h4>
            <ul>
                <li><a href="forum" class="grey-text">Forum</a></li>
                <li><a href="blog" class="grey-text">Blog</a></li>
                <li><a href="about" class="grey-text">Sobre</a></li>
            </ul>
        </div>
        <div class="col s12 m8">
            <h4>CONTATO</h4>
            <form action="contact" method="post">
                <div class="input-field">
                    <input type="text" id="name" name="name" class="validate" value="<?php echo (isset($name)) ? $name : ''; ?>" required />
                    <label for="name" class="<?php echo (isset($name)) ? 'active' : ''; ?>">Nome completo</label>
                </div>
                <div class="input-field">
                    <input type="email" id="email" name="email" class="validate" value="<?php echo (isset($email)) ? $email : ''; ?>" required />
                    <label for="email" class="<?php echo (isset($email)) ? 'active' : ''; ?>">Seu e-mail</label>
                </div>
                <div class="input-field">
                    <input type="text" id="subject" name="subject" class="validate" value="<?php echo (isset($subject)) ? $subject : ''; ?>" required />
                    <label for="subject" class="<?php echo (isset($subject)) ? 'active' : ''; ?>">Assunto da mensagem</label>
                </div>
                <div class="input-field">
                    <textarea id="message" name="message" class="materialize-textarea" required><?php echo (isset($message)) ? $message : ''; ?></textarea>
                    <label for="message" class="<?php echo (isset($message)) ? 'active' : ''; ?>">Deixe sua mensagem</label>
                </div>
            </form>
        </div>
    </div>
    <script src="assets/js/script.js"></script>
</footer>

</body>

</html>
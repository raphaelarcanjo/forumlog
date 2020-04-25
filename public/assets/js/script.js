const app = new Vue({
    el: "#app",
    data: {
        tag: "",
        cep: "",
        wait: false,
        error: "",
        country: "Brasil",
        address: {
            logradouro: "",
            complemento: "",
            bairro: "",
            localidade: "",
            uf: ""
        }
    },
    methods: {
        getAddress: function() {
            this.address = {
                logradouro: "",
                complemento: "",
                bairro: "",
                localidade: "",
                uf: ""
            }

            if (document.querySelector("#cep").checkValidity()) {
                this.wait = true

                fetch('https://viacep.com.br/ws/' + this.cep + '/json/')
                    .then(response => response.json())
                    .then(data => {
                        if (data.erro) this.error = "CEP não encontrado"
                        else {
                            this.address = data
                            this.wait = false
                        }
                    })
            }
        }
    }
})

M.AutoInit()

var options = { closeOnClick: false }
var elems = document.querySelectorAll('.dropdown-trigger')
var instances = M.Dropdown.init(elems, options)

const confirmPass = () => {
    let pass = document.querySelector("#regPassword")
    let confirm = document.querySelector("#confirm")

    if (pass.value !== confirm.value) {
        confirm.classList.add("invalid")
        confirm.setCustomValidity("A senha deve conferir com o campo 'Confirmar senha'.")
    } else {
        confirm.classList.add("valid")
        confirm.classList.remove("invalid")
        confirm.setCustomValidity("")
    }
}
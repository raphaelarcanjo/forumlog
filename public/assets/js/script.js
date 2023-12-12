M.AutoInit()

var dropOptions = { closeOnClick: false }
$('.dropdown-trigger').dropdown(dropOptions)

var maxDate = new Date()
var dateOptions = {
    format: 'dd/mm/yyyy',
    yearRange: [1920, maxDate.getFullYear()],
    i18n: {
        months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Júlho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        weekdays: ["Domingo","Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
        weekdaysShort: ["Dom","Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
        weekdaysAbbrev: ["D","S", "T", "Q", "Q", "S", "S"],
        cancel: 'Cancelar',
        clear: 'Limpar',
        done: 'Ok'
    }
}
$('.datepicker').datepicker(dateOptions)

var celOptions =  {
    onKeyPress: function(phone, e, field, options) {
        var masks = ['(00) 00000-0000', '(00) 0000-00000'];
        var mask = (phone.length>14) ? masks[0] : masks[1];
        $(field).mask(mask, celOptions);
}};

$(".phone").mask('(00) 00000-0000', celOptions)
$(".cep").mask('00.000-000')
$(".date").mask('00/00/0000')

const getAddress = ()=> {
    $("#cepMsg").attr('data-error', "Digite apenas números")

    if (document.querySelector("#cep").checkValidity()) {
        $("#wait").show()
        $("#cep").removeClass("valid invalid")
        let cep = $("#cep").val().replace(/\D/g, "")

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                $("#wait").hide()
                $("#address").val(data.logradouro)
                $("#address~label").addClass("active")
                $("#complement").val(data.complemento)
                $("#complement~label").addClass("active")
                $("#suburb").val(data.bairro)
                $("#suburb~label").addClass("active")
                $("#city").val(data.localidade)
                $("#city~label").addClass("active")
                $("#province").val(data.uf)
                $("#province~label").addClass("active")
                $("#country").val("Brasil")
                $("#country~label").addClass("active")
            })
            .catch(error => {
                console.error(error)
                $("#wait").hide()
                $("#cepMsg").attr('data-error', "CEP não encontrado")
                $("#cep").removeClass("valid")
                $("#cep").addClass("invalid")
            })
    }
}

const tagAddress = ()=> {
    $("#tagUrl").attr('data-success', 'http://forumlog/blog/' + $("#username").val())
}

const confirmPass = () => {

    if ($("#regPassword").val() !== $("#confirm").val()) {
        $("#confirm").addClass("invalid")
    } else {
        $("#confirm").addClass("valid")
        $("#confirm").removeClass("invalid")
    }
}

const goToTop = ()=> {
    $('html, body').animate({ scrollTop: 0 }, 'slow')
}

$(window).scroll(()=> {
    if ($(window).scrollTop() > 100) $("#btnTop").fadeIn()
    else $("#btnTop").fadeOut()
})

function preview_photo(event) {
    var reader = new FileReader()
    reader.onload = ()=> $("#previewPhoto").attr('src', reader.result)
    reader.readAsDataURL(event.target.files[0])
}

$(document).ready(() => {
    const date = new Date()
    $('#copyright').text(date.getFullYear())
})

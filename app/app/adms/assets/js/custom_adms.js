// Permitir retorno no navegador no formulario apos o erro
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

/* Inicio Dropdown Navbar */
//let notification = document.querySelector(".notification");
let avatar = document.querySelector(".avatar");

dropMenu(avatar);
//dropMenu(notification);

function dropMenu(selector) {
    //console.log(selector);
    selector.addEventListener("click", () => {
        let dropdownMenu = selector.querySelector(".dropdown-menu");
        dropdownMenu.classList.contains("active") ? dropdownMenu.classList.remove("active") : dropdownMenu.classList.add("active");
    });
}
/* Fim Dropdown Navbar */

/* Inicio Sidebar Toggle / bars */
let sidebar = document.querySelector(".sidebar");
let bars = document.querySelector(".bars");

bars.addEventListener("click", () => {
    sidebar.classList.contains("active") ? sidebar.classList.remove("active") : sidebar.classList.add("active");
});

window.matchMedia("(max-width: 768px)").matches ? sidebar.classList.remove("active") : sidebar.classList.add("active");
/* Fim Sidebar Toggle / bars */

/* Inicio botao dropdown do listar */

function actionDropdown(id) {
    closeDropdownAction();
    document.getElementById("actionDropdown" + id).classList.toggle("show-dropdown-action");
}

window.onclick = function (event) {
    if (!event.target.matches(".dropdown-btn-action")) {
        /*document.getElementById("actionDropdown").classList.remove("show-dropdown-action");*/
        closeDropdownAction();
    }
}

function closeDropdownAction() {
    var dropdowns = document.getElementsByClassName("dropdown-action-item");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i]
        if (openDropdown.classList.contains("show-dropdown-action")) {
            openDropdown.classList.remove("show-dropdown-action");
        }
    }
}
/* Fim botao dropdown do listar */



// Calcular a forca da senha
function passwordStrength() {
    var password = document.getElementById("password").value;
    var strength = 0;

    if ((password.length >= 6) && (password.length <= 7)) {
        strength += 10;
    } else if (password.length > 7) {
        strength += 25;
    }

    if ((password.length >= 6) && (password.match(/[a-z]+/))) {
        strength += 10;
    }

    if ((password.length >= 7) && (password.match(/[A-Z]+/))) {
        strength += 20;
    }

    if ((password.length >= 8) && (password.match(/[@#$%;*]+/))) {
        strength += 25;
    }

    if (password.match(/([1-9]+)\1{1,}/)) {
        strength -= 25;
    }
    viewStrength(strength);
}

function viewStrength(strength) {
    // Imprimir a força da senha
    if (strength < 30) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-danger'>Senha Fraca</p>";
    } else if ((strength >= 30) && (strength < 50)) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-warning'>Senha Média</p>";
    } else if ((strength >= 50) && (strength < 69)) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-primary'>Senha Boa</p>";
    } else if (strength >= 70) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-success'>Senha Forte</p>";
    } else {
        document.getElementById("msgViewStrength").innerHTML = "";
    }
}


const formAddUser = document.getElementById("form-add-user");
if (formAddUser) {
    formAddUser.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }


        //Receber o valor do campo
        var empresa_id = document.querySelector("#empresa_id").value;
        // Verificar se o campo esta vazio
        if (empresa_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }
        //Receber o valor do campo
        var empresa_id = document.querySelector("#contr_id").value;
        // Verificar se o campo esta vazio
        if (empresa_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo contrato!</p>";
            return;
        }

        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
        //Receber o valor do campo
        var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
        // Verificar se o campo esta vazio
        if (adms_sits_user_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo situação!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_access_level_id = document.querySelector("#adms_access_level_id").value;
        // Verificar se o campo esta vazio
        if (adms_access_level_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nível de acesso!</p>";
            return;
        }

        // Verificar se o campo senha possui 6 caracteres
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }
        // Verificar se o campo senha não possui números repetidos
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }
        // Verificar se o campo senha possui letras
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }


    });
}

const formEditUser = document.getElementById("form-edit-user");
if (formEditUser) {
    formEditUser.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
        // Verificar se o campo esta vazio
        if (adms_sits_user_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo situação!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditUserPass = document.getElementById("form-edit-user-pass");
if (formEditUserPass) {
    formEditUserPass.addEventListener("submit", async (e) => {

        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
        // Verificar se o campo senha possui 6 caracteres
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }
        // Verificar se o campo senha não possui números repetidos
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }
        // Verificar se o campo senha possui letras
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditProfile = document.getElementById("form-edit-profile");
if (formEditProfile) {
    formEditProfile.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditProfPass = document.getElementById("form-edit-prof-pass");
if (formEditProfPass) {
    formEditProfPass.addEventListener("submit", async (e) => {

        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
        // Verificar se o campo senha possui 6 caracteres
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }
        // Verificar se o campo senha não possui números repetidos
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }
        // Verificar se o campo senha possui letras
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditUserImg = document.getElementById("form-edit-user-img");
if (formEditUserImg) {
    formEditUserImg.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var new_image = document.querySelector("#new_image").value;
        // Verificar se o campo esta vazio
        if (new_image === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditProfImg = document.getElementById("form-edit-prof-img");
if (formEditProfImg) {
    formEditProfImg.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var new_image = document.querySelector("#new_image").value;
        // Verificar se o campo esta vazio
        if (new_image === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditProfImgCham = document.getElementById("form-edit-prof-img-cham");
if (formEditProfImgCham) {
    formEditProfImgCham.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var new_image_cham = document.querySelector("#new_image_cham").value;
        // Verificar se o campo esta vazio
        if (new_image_cham === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

const formEditProfImgClieFin = document.getElementById("form-edit-user-img-clie-fin");

if (formEditProfImgClieFin) {
    formEditProfImgClieFin.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var new_image_clie_fin = document.querySelector("#new_image_clie_fin").value;
        // Verificar se o campo esta vazio
        if (new_image_clie_fin === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

function inputFileValImgClieFin() {
    //Receber o valor do campo
    var new_image_clie_fin = document.querySelector("#new_image_clie_fin");

    var filePath = new_image_clie_fin.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image_clie_fin.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageAvatarClieFin(new_image_clie_fin);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}

function previewImageAvatarClieFin(new_image_clie_fin) {
    if ((new_image_clie_fin.files) && (new_image_clie_fin.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img-avatar-clie-fin').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 100px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image_clie_fin.files[0]);
}

function inputFileValImg() {
    //Receber o valor do campo
    var new_image = document.querySelector("#new_image");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageAvatar(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}

function previewImageAvatar(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img-avatar').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 100px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputFileValLogo() {
    //Receber o valor do campo
    var new_image = document.querySelector("#new_image");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewLogo(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}

function previewLogo(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 200px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}


function inputFileValImgCham() {
    //Receber o valor do campo
    var new_image_cham = document.querySelector("#new_image_cham");

    var filePath = new_image_cham.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image_cham.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageCham(new_image_cham);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}

function previewImageCham(new_image_cham) {
    if ((new_image_cham.files) && (new_image_cham.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var readerCham = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        readerCham.onload = function (e) {
            document.getElementById('preview-img-cham').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 500px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    readerCham.readAsDataURL(new_image_cham.files[0]);
}

const formEditSitUser = document.getElementById("form-add-sit-user");
if (formEditSitUser) {
    formEditSitUser.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_color_id = document.querySelector("#adms_color_id").value;
        // Verificar se o campo esta vazio
        if (adms_color_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Cor!</p>";
            return;
        }
    });
}

const formAddColors = document.getElementById("form-add-color");
if (formAddColors) {
    formAddColors.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var color = document.querySelector("#color").value;
        // Verificar se o campo esta vazio
        if (color === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo cor!</p>";
            return;
        }
    });
}

const formAddConfEmails = document.getElementById("form-add-conf-emails");
if (formAddConfEmails) {
    formAddConfEmails.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var title = document.querySelector("#title").value;
        // Verificar se o campo esta vazio
        if (title === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo titulo!</p>";
            return;
        }

        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo email!</p>";
            return;
        }

        var host = document.querySelector("#host").value;
        // Verificar se o campo esta vazio
        if (host === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo host!</p>";
            return;
        }

        var username = document.querySelector("#username").value;
        // Verificar se o campo esta vazio
        if (username === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

        var smtpsecure = document.querySelector("#smtpsecure").value;
        // Verificar se o campo esta vazio
        if (smtpsecure === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo smtp!</p>";
            return;
        }

        var port = document.querySelector("#port").value;
        // Verificar se o campo esta vazio
        if (port === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo porta!</p>";
            return;
        }
    });
}

const formEditConfEmails = document.getElementById("form-edit-conf-emails");
if (formEditConfEmails) {
    formEditConfEmails.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var title = document.querySelector("#title").value;
        // Verificar se o campo esta vazio
        if (title === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo titulo!</p>";
            return;
        }

        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo email!</p>";
            return;
        }

        var host = document.querySelector("#host").value;
        // Verificar se o campo esta vazio
        if (host === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo host!</p>";
            return;
        }

        var username = document.querySelector("#username").value;
        // Verificar se o campo esta vazio
        if (username === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        var smtpsecure = document.querySelector("#smtpsecure").value;
        // Verificar se o campo esta vazio
        if (smtpsecure === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo smtp!</p>";
            return;
        }

        var port = document.querySelector("#port").value;
        // Verificar se o campo esta vazio
        if (port === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo porta!</p>";
            return;
        }
    });
}

const formEditConfEmailsPass = document.getElementById("form-edit-conf-emails-pass");
if (formEditConfEmailsPass) {
    formEditConfEmailsPass.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
    });
}

const formAddAccessLeves = document.getElementById("form-add-access-levels");
if (formAddAccessLeves) {
    formAddAccessLeves.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }
    });
}

const formAddSitPages = document.getElementById("form-add-sit-pages");
if (formAddSitPages) {
    formAddSitPages.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_color_id = document.querySelector("#adms_color_id").value;
        // Verificar se o campo esta vazio
        if (adms_color_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Cor!</p>";
            return;
        }
    });
}

const formEditSitPages = document.getElementById("form-edit-sit-pages");
if (formEditSitPages) {
    formEditSitPages.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_color_id = document.querySelector("#adms_color_id").value;
        // Verificar se o campo esta vazio
        if (adms_color_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Cor!</p>";
            return;
        }
    });
}

const formAddGroupsPages = document.getElementById("form-add-groups-pages");
if (formAddGroupsPages) {
    formAddGroupsPages.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }
    });
}

const formEditGroupsPages = document.getElementById("form-edit-groups-pages");
if (formEditGroupsPages) {
    formEditGroupsPages.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }
    });
}

const formAddTypesPages = document.getElementById("form-add-types-pages");
if (formAddTypesPages) {
    formAddTypesPages.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var type = document.querySelector("#type").value;
        // Verificar se o campo esta vazio
        if (type === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo tipo!</p>";
            return;
        }

        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }
    });
}

const formEditTypesPages = document.getElementById("form-edit-types-pages");
if (formEditTypesPages) {
    formEditTypesPages.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var type = document.querySelector("#type").value;
        // Verificar se o campo esta vazio
        if (type === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo tipo!</p>";
            return;
        }

        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }
    });
}

const formAddPages = document.getElementById("form-add-pages");
if (formAddPages) {
    formAddPages.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var controller = document.querySelector("#controller").value;
        // Verificar se o campo esta vazio
        if (controller === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Classe!</p>";
            return;
        }

        //Receber o valor do campo
        var metodo = document.querySelector("#metodo").value;
        // Verificar se o campo esta vazio
        if (metodo === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Método!</p>";
            return;
        }

        //Receber o valor do campo
        var menu_controller = document.querySelector("#menu_controller").value;
        // Verificar se o campo esta vazio
        if (menu_controller === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Classe no menu!</p>";
            return;
        }

        //Receber o valor do campo
        var menu_metodo = document.querySelector("#menu_metodo").value;
        // Verificar se o campo esta vazio
        if (menu_metodo === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Método no menu!</p>";
            return;
        }

        //Receber o valor do campo
        var name_page = document.querySelector("#name_page").value;
        // Verificar se o campo esta vazio
        if (name_page === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Nome da Página!</p>";
            return;
        }

        //Receber o valor do campo
        var publish = document.querySelector("#publish").value;
        // Verificar se o campo esta vazio
        if (publish === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Página Pública!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_sits_pgs_id = document.querySelector("#adms_sits_pgs_id").value;
        // Verificar se o campo esta vazio
        if (adms_sits_pgs_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Situação da Página!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_groups_pgs_id = document.querySelector("#adms_groups_pgs_id").value;
        // Verificar se o campo esta vazio
        if (adms_groups_pgs_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Grupo da Página!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_types_pgs_id = document.querySelector("#adms_types_pgs_id").value;
        // Verificar se o campo esta vazio
        if (adms_types_pgs_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Tipo da Página!</p>";
            return;
        }
    });
}

const formAddEmpresas = document.getElementById("form-add-empresas");
if (formAddEmpresas) {
    formAddEmpresas.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var razao_social = document.querySelector("#razao_social").value;
        // Verificar se o campo esta vazio
        if (razao_social === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o Razão Social!</p>";
            return;
        }

        //Receber o valor do campo
        var nome_fantasia = document.querySelector("#nome_fantasia").value;
        // Verificar se o campo esta vazio
        if (nome_fantasia === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Nome de Fantasia!</p>";
            return;
        }

        //Receber o valor do campo
        var cnpj = document.querySelector("#cnpj").value;
        // Verificar se o campo esta vazio
        if (cnpj === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Cnpj!</p>";
            return;
        }

        //Receber o valor do campo
        var cep = document.querySelector("#cep").value;
        // Verificar se o campo esta vazio
        if (cep === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Cep!</p>";
            return;
        }

        //Receber o valor do campo
        var logradouro = document.querySelector("#logradouro").value;
        // Verificar se o campo esta vazio
        if (logradouro === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Logradouro!</p>";
            return;
        }

        //Receber o valor do campo
        var bairro = document.querySelector("#bairro").value;
        // Verificar se o campo esta vazio
        if (bairro === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Bairro!</p>";
            return;
        }

        //Receber o valor do campo
        var cidade = document.querySelector("#cidade").value;
        // Verificar se o campo esta vazio
        if (cidade === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Cidade!</p>";
            return;
        }

        //Receber o valor do campo
        var uf = document.querySelector("#uf").value;
        // Verificar se o campo esta vazio
        if (uf === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Uf!</p>";
            return;
        }

        //Receber o valor do campo
        var situacao = document.querySelector("#situacao ").value;
        // Verificar se o campo esta vazio
        if (situacao === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher a Situação!</p>";
            return;
        }
    });
}

const formEditEmpresas = document.getElementById("form-edit-empresas");
if (formEditEmpresas) {
    formEditEmpresas.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var razao_social = document.querySelector("#razao_social").value;
        // Verificar se o campo esta vazio
        if (razao_social === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o Razão Social!</p>";
            return;
        }

        //Receber o valor do campo
        var nome_fantasia = document.querySelector("#nome_fantasia").value;
        // Verificar se o campo esta vazio
        if (nome_fantasia === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Nome de Fantasia!</p>";
            return;
        }

        //Receber o valor do campo
        var cnpj = document.querySelector("#cnpj").value;
        // Verificar se o campo esta vazio
        if (cnpj === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Cnpj!</p>";
            return;
        }

        //Receber o valor do campo
        var cep = document.querySelector("#cep").value;
        // Verificar se o campo esta vazio
        if (cep === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Cep!</p>";
            return;
        }

        //Receber o valor do campo
        var logradouro = document.querySelector("#logradouro").value;
        // Verificar se o campo esta vazio
        if (logradouro === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Logradouro!</p>";
            return;
        }

        //Receber o valor do campo
        var bairro = document.querySelector("#bairro").value;
        // Verificar se o campo esta vazio
        if (bairro === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Bairro!</p>";
            return;
        }

        //Receber o valor do campo
        var cidade = document.querySelector("#cidade").value;
        // Verificar se o campo esta vazio
        if (cidade === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Cidade!</p>";
            return;
        }

        //Receber o valor do campo
        var uf = document.querySelector("#uf").value;
        // Verificar se o campo esta vazio
        if (uf === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Uf!</p>";
            return;
        }

        //Receber o valor do campo
        var situacao = document.querySelector("#situacao ").value;
        // Verificar se o campo esta vazio
        if (situacao === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher a Situação!</p>";
            return;
        }
    });
}


const formAddSetor = document.getElementById("form-add-setor");
if (formAddEmpresas) {
    formAddEmpresas.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var empresa_id = document.querySelector("#empresa_id").value;
        // Verificar se o campo esta vazio
        if (empresa_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo empresa do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var localizacao = document.querySelector("#localizacao").value;
        // Verificar se o campo esta vazio
        if (localizacao === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo localização do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var contato = document.querySelector("#contato").value;
        // Verificar se o campo esta vazio
        if (contato === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo contato do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var tel = document.querySelector("#tel").value;
        // Verificar se o campo esta vazio
        if (tel === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo telefone do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var situacao = document.querySelector("#situacao ").value;
        // Verificar se o campo esta vazio
        if (situacao === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo situação do setor!</p>";
            return;
        }
    });
}


const formEditSetor = document.getElementById("form-edit-setor");
if (formEditSetor) {
    formEditSetor.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var empresa_id = document.querySelector("#empresa_id").value;
        // Verificar se o campo esta vazio
        if (empresa_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo empresa do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var localizacao = document.querySelector("#localizacao").value;
        // Verificar se o campo esta vazio
        if (localizacao === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo localização do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var contato = document.querySelector("#contato").value;
        // Verificar se o campo esta vazio
        if (contato === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo contato do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var tel = document.querySelector("#tel").value;
        // Verificar se o campo esta vazio
        if (tel === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo telefone do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail do setor!</p>";
            return;
        }

        //Receber o valor do campo
        var situacao = document.querySelector("#situacao ").value;
        // Verificar se o campo esta vazio
        if (situacao === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo situação do setor!</p>";
            return;
        }
    });
}



const formEditPages = document.getElementById("form-edit-pages");
if (formEditPages) {
    formEditPages.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var controller = document.querySelector("#controller").value;
        // Verificar se o campo esta vazio
        if (controller === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Classe!</p>";
            return;
        }

        //Receber o valor do campo
        var metodo = document.querySelector("#metodo").value;
        // Verificar se o campo esta vazio
        if (metodo === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Método!</p>";
            return;
        }

        //Receber o valor do campo
        var menu_controller = document.querySelector("#menu_controller").value;
        // Verificar se o campo esta vazio
        if (menu_controller === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Classe no menu!</p>";
            return;
        }

        //Receber o valor do campo
        var menu_metodo = document.querySelector("#menu_metodo").value;
        // Verificar se o campo esta vazio
        if (menu_metodo === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Método no menu!</p>";
            return;
        }

        //Receber o valor do campo
        var name_page = document.querySelector("#name_page").value;
        // Verificar se o campo esta vazio
        if (name_page === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Nome da Página!</p>";
            return;
        }

        //Receber o valor do campo
        var publish = document.querySelector("#publish").value;
        // Verificar se o campo esta vazio
        if (publish === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Página Pública!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_sits_pgs_id = document.querySelector("#adms_sits_pgs_id").value;
        // Verificar se o campo esta vazio
        if (adms_sits_pgs_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Situação da Página!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_groups_pgs_id = document.querySelector("#adms_groups_pgs_id").value;
        // Verificar se o campo esta vazio
        if (adms_groups_pgs_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Grupo da Página!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_types_pgs_id = document.querySelector("#adms_types_pgs_id").value;
        // Verificar se o campo esta vazio
        if (adms_types_pgs_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo Tipo da Página!</p>";
            return;
        }
    });
}

const formEditLavelForm = document.getElementById("form-edit-level-form");
if (formEditLavelForm) {
    formEditLavelForm.addEventListener("submit", async (e) => {

        //Receber o valor do campo
        var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
        // Verificar se o campo esta vazio
        if (adms_sits_user_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo situação!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_access_level_id = document.querySelector("#adms_access_level_id").value;
        // Verificar se o campo esta vazio
        if (adms_access_level_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nível de acesso!</p>";
            return;
        }
    });
}

const formAddItemMenu = document.getElementById("form-add-item-menu");
if (formAddItemMenu) {
    formAddItemMenu.addEventListener("submit", async (e) => {

        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var icon = document.querySelector("#icon").value;
        // Verificar se o campo esta vazio
        if (icon === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo ícone!</p>";
            return;
        }
    });
}

const formEditPageMenu = document.getElementById("form-edit-page-menu");
if (formEditPageMenu) {
    formEditPageMenu.addEventListener("submit", async (e) => {

        //Receber o valor do campo
        var adms_items_menu_id = document.querySelector("#adms_items_menu_id").value;
        // Verificar se o campo esta vazio
        if (adms_items_menu_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo item de menu!</p>";
            return;
        }
    });
}

/* Inicio dropdown sidebar */

var dropdownSidebar = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdownSidebar.length; i++) {
    dropdownSidebar[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    });
}
/* Inicio dropdown sidebar ativo */

var sidebarNav = document.getElementsByClassName("sidebar-nav");

for (var i = 0; i < sidebarNav.length; i++) {
    if (sidebarNav[i].classList.contains("active")) {
        document.querySelector(".btn-" + sidebarNav[i].classList[1]).classList.add("active");
        document.querySelector(".cont-" + sidebarNav[i].classList[1]).classList.add("active");
    }
}

/* Fim dropdown sidebar ativo */

/* Fim dropdown sidebar */


/* Verificar se o chamado foi concluido*/

function pausar_chamados(id_chamado, id_estagio) {

    $estagio = id_estagio;

    if ($estagio == 'Atendimento Concluido') {
        alert('Este atendimento ja se encontra CONCLUIDO !');

    } else if ($estagio == 'Aguardando Atendimento') {
        alert('Este atendimento ainda não foi INICIADO');

    } else if ($estagio == 'Atendimento Pausado') {
        alert('Este atendimento voltara ao estagio de EM ATENDIMENTO !');
        location.href = 'grava.php?tela=inserir_atendimento&cod_cha=' + id_chamado;

    } else if ($estagio == 'Aguardando Fornecedor') {
        alert('Este atendimento não pode ser Pausado pois se encontra AGUARDANDO FORNECEDOR !');

    } else {
        location.href = 'index.php?tela=pausar_atendimento&cod_cha=' + id_chamado;
    };

}


/* Verificar  o status do chamado*/

function VisualizarChamados(status_cham) {

    if (status_cham == '2') {
        alert('Aberto');
    } else if (status_cham == '3') {
        alert('Em Atendimento');
    } else {
        alert('Nenhum');
    }
}


// Validação das imagens do Carroussel do Home do site Repbrasil

// Validação slide 1 do carroussel do Home do site Repbrasil
function inputFileValImgSlideUm() {
    //Receber o valor do campo
    var image_1 = document.querySelector("#image_1");

    var filePath = image_1.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_1.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageUm(image_1);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageUm(image_1) {
    if ((image_1.files) && (image_1.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img_1').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_1.files[0]);
}

// Validação slide 2 do carroussel do Home do site Repbrasil
function inputFileValImgSlideDois() {
    //Receber o valor do campo
    var image_2 = document.querySelector("#image_2");

    var filePath = image_2.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_2.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageDois(image_2);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageDois(image_2) {
    if ((image_2.files) && (image_2.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img_2').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_2.files[0]);
}
// Validação slide 3 do carroussel do Home do site Repbrasil

function inputFileValImgSlideTres() {
    //Receber o valor do campo
    var image_3 = document.querySelector("#image_3");

    var filePath = image_3.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_3.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageTres(image_3);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageTres(image_3) {
    if ((image_3.files) && (image_3.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img_3').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_3.files[0]);
}

// Validação slide 4 do carroussel do Home do site Repbrasil
function inputFileValImgSlideQuatro() {
    //Receber o valor do campo
    var image_4 = document.querySelector("#image_4");

    var filePath = image_4.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_4.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageQuatro(image_4);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageQuatro(image_4) {
    if ((image_4.files) && (image_4.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img_4').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_4.files[0]);
}

// Validação sile 5 do carroussel do Home do site Repbrasil
function inputFileValImgSlideCinco() {
    //Receber o valor do campo
    var image_5 = document.querySelector("#image_5");

    var filePath = image_5.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_5.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageCinco(image_5);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageCinco(image_5) {
    if ((image_5.files) && (image_5.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img_5').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_5.files[0]);
}

// Validação slide 6 do carroussel do Home do site Repbrasil
function inputFileValImgSlideSeis() {
    //Receber o valor do campo
    var image_6 = document.querySelector("#image_6");

    var filePath = image_6.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_6.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageSeis(image_6);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageSeis(image_6) {
    if ((image_6.files) && (image_6.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img_6').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_6.files[0]);
}

// Validação imagem 1 da divulgação  do Home do site Repbrasil
function inputFileValImgInstUm() {
    //Receber o valor do campo
    var image_1 = document.querySelector("#image_1");

    var filePath = image_1.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_1.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageInstUm(image_1);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageInstUm(image_1) {
    if ((image_1.files) && (image_1.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-div-img-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_1.files[0]);
}

// Validação imagem dois da divulgação  do Home do site Repbrasil
function inputFileValImgInstDois() {
    //Receber o valor do campo
    var image_2 = document.querySelector("#image_2");

    var filePath = image_2.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_2.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageInstDois(image_2);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageInstDois(image_2) {
    if ((image_2.files) && (image_2.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-div-img-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_2.files[0]);
}

// Validação imagem tres da divulgação  do Home do site Repbrasil
function inputFileValImgInstTres() {
    //Receber o valor do campo
    var image_3 = document.querySelector("#image_3");

    var filePath = image_3.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_3.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageInstTres(image_3);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageInstTres(image_3) {
    if ((image_3.files) && (image_3.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-div-img-tres').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_3.files[0]);
}

// Validação imagem quatro da divulgação  do Home do site Repbrasil
function inputFileValImgInstQuatro() {
    //Receber o valor do campo
    var image_4 = document.querySelector("#image_4");

    var filePath = image_4.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_4.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageInstQuatro(image_4);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageInstQuatro(image_4) {
    if ((image_4.files) && (image_4.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-div-img-quatro').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_4.files[0]);
}

// Validação imagem cinco da divulgação  do Home do site Repbrasil
function inputFileValImgInstCinco() {
    //Receber o valor do campo
    var image_5 = document.querySelector("#image_5");

    var filePath = image_5.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_5.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageInstCinco(image_5);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageInstCinco(image_5) {
    if ((image_5.files) && (image_5.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-div-img-cinco').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_5.files[0]);
}

// Validação imagem seis da divulgação  do Home do site Repbrasil
function inputFileValImgInstSeis() {
    //Receber o valor do campo
    var image_6 = document.querySelector("#image_6");

    var filePath = image_6.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_6.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageInstSeis(image_6);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageInstSeis(image_6) {
    if ((image_6.files) && (image_6.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-div-img-seis').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_6.files[0]);
}





function inputFileValImgUm() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_1");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageRepUm(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}

function previewImageRepUm(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img-rep-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 25%;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}


function inputFileValImgDois() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_2");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageRepDois(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}

function previewImageRepDois(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-img-rep-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 25%;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem pagina catracas do site 



function inputFileValCatImg() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImagesCat(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}

function previewImagesCat(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-cat-img').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 25%;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem pagina suprimentos do site 
function inputFileValSupImg() {
    //Receber o valor do campo
    var image_1 = document.querySelector("#imageI");

    var filePath = image_1.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        image_1.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageSupUm(image_1);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageSupUm(image_1) {
    if ((image_1.files) && (image_1.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-sup-img').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(image_1.files[0]);
}

// Validação imagem dois da pagina suprimentos do site 
function inputFileValSupImgII() {
    //Receber o valor do campo
    var new_image = document.querySelector("#imageII");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageSupDois(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageSupDois(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-sup-img-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}


// Validação imagem dois da pagina suprimentos do site 
function inputFileValSupImgIII() {
    //Receber o valor do campo
    var new_image = document.querySelector("#imageIII");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageSupTres(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageSupTres(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-sup-img-tres').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem topo da pagina Soluções do Ponto do site 
function inputFileValPontoImgTopo() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_top");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImageTop(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImageTop(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-ponto-img-top').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}
// Validação imagem Centro da pagina Soluções do Ponto do site 
function inputFileValPontoImgCentro() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_center");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImage(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImage(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-ponto-img-centro').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem Centro da pagina Soluções do Acesso do site 
function inputFileValAcessoImgUm() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_top");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewAceImgTop(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewAceImgTop(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-acesso-img-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputFileValAcessoImgDois() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_center");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewAceImgCenter(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewAceImgCenter(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-acesso-img-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem Centro da pagina Soluções do checkin do site 
function inputFileValCheckImgUm() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_top");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewChekImgTop(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewChekImgTop(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-checkin-img-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputFileValCheckImgDois() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_center");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewChekImgCenter(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewChekImgCenter(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-checkin-img-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}


// Validação imagem Centro da pagina Soluções do Clube do site 
function inputFileValClubeImgUm() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_top");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewClubImgTop(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewClubImgTop(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-clube-img-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputFileValClubeImgDois() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_center");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewClubImgCenter(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewClubImgCenter(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-clube-img-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem Centro da pagina Soluções da escola do site 
function inputFileValEscolaImgUm() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_top");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewEscImgTop(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewEscImgTop(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-escola-img-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputFileValEscolaImgDois() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_center");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewEscolaImgCenter(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewEscolaImgCenter(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-escola-img-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem Centro da pagina Soluções da Estacionamento do site 
function inputFileValEstacImgUm() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_top");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewEstacImgTop(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewEstacImgTop(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-estac-img-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputFileValEstacImgDois() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_center");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewEstacImgCenter(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewEstacImgCenter(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-estac-img-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem Centro da pagina Soluções da Academia do site 
function inputFileValAcadImgUm() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_top");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewAcadImgTop(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewAcadImgTop(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-acad-img-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputFileValAcadImgDois() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_center");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewAcadImgCenter(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewAcadImgCenter(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-acad-img-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}


// Validação imagem da pagina Soluções da Miniaturas do site 
function inputFileValMinAcadUm() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_1");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewAcadMinUm(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewAcadMinUm(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-min-img-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputFileValMinAcadDois() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_2");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewAcadMinDois(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewAcadMinDois(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-min-img-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem Centro da pagina Soluções da Academia do site 
function inputFileValMinAcadTres() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_3");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewAcadMinTres(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewAcadMinTres(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-min-img-tres').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputFileValMinAcadQuatro() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_4");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewAcadMinQuatro(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewAcadMinQuatro(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-min-img-quatro').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}
// Validação imagem topo da pagina serviço suporte tecnico do site 
function inputFileValServTec() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_top");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerTec(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerTec(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-serv-tec').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}
// Validação imagem Carroussel da pagina serviço suporte tecnico do site 
function inputServSupUnderUm() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_1");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerTecUnderum(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerTecUnderum(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-under-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputServSupUnderDois() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_2");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerTecUnderdois(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerTecUnderdois(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-under-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputServSupUnderTres() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_3");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerTecUndertres(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerTecUndertres(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-under-tres').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputServSupUnderQuatro() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_4");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerTecUnderquatro(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerTecUnderquatro(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-under-quatro').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputServSupUnderCinco() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_5");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerTecUndercinco(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerTecUndercinco(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-under-cinco').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputServSupUnderSeis() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_6");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerTecUnderseis(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerTecUnderseis(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-under-seis').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);

}




    
// Validação imagem do topo da pagina serviço assistencia tecnica do site 

function inputFileValAssTec() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_top");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewAssTec(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewAssTec(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-ass-tec').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem Carroussel da pagina serviço assistencia tecnica do site 
function inputServAssUnderUm() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_1");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerAssUnderum(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerAssUnderum(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-ass-under-um').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputServAssUnderDois() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_2");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerAssUnderdois(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerAssUnderdois(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-ass-under-dois').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputServAssUnderTres() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_3");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerAssUndertres(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerAssUndertres(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-ass-under-tres').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputServAssUnderQuatro() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_4");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerAssUnderquatro(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerAssUnderquatro(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-ass-under-quatro').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputServAssUnderCinco() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_5");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerAssUndercinco(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerAssUndercinco(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-ass-under-cinco').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

function inputServAssUnderSeis() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image_under_6");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSerAssUnderseis(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSerAssUnderseis(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-ass-under-seis').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem do topo da pagina sobre empresa do site 
function inputValImgSobreEmp() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewSobreEmp(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewSobreEmp(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-sobre-emp').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

// Validação imagem do topo da pagina contato do site 
function inputFileValImgContato() {
    //Receber o valor do campo
    var new_image = document.querySelector("#image");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewContato(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewContato(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function (e) {
            document.getElementById('preview-contato-emp').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 250px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}


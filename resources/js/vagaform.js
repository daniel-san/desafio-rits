function validate_empty(selector) {
    return function() {
        value = $(selector).val();
        if (value.trim() === "") {
            $(selector).removeClass("is-valid");
            $(selector).addClass("is-invalid");
            return false;
        }

        $(selector).removeClass("is-invalid");
        $(selector).addClass("is-valid");
        return true;
    };
}

function is_email(value) {
    email_regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return email_regex.test(value);
}

$("input#name").on("focusout", () => {
    valid = validate_empty("input#name")();

    if (!valid) {
        $("#name-error").text("Por favor digite seu nome");
        return false;
    }

    $("#name-error").text("");
});

$("input#email").on("focusout", () => {
    email = $("input#email").val();
    valid = is_email(email);
    if (!valid) {
        $("#email-error").text("Digite um e-mail válido");
        $("input#email").removeClass("is-valid");
        $("input#email").addClass("is-invalid");
        return false;
    }

    $("input#email").removeClass("is-invalid");
    $("input#email").addClass("is-valid");
    $("#email-error").text("");
});

$("input#telephone").on("focusout", () => {
    valid = validate_empty("input#telephone")();

    if (!valid) {
        $("#telephone-error").text("Por favor digite seu telefone");
        return false;
    }

    $("#telephone-error").text("");
});

$("input#linkedinUrl").on("focusout", () => {
    valid = validate_empty("input#linkedinUrl")();

    if (!valid) {
        $("#linkedin-error").text(
            "Por favor digite o endereço do seu LinkedIn"
        );
        return false;
    }

    $("#linkedin-error").text("");
});

$("input#githubUrl").on("focusout", () => {
    valid = validate_empty("input#githubUrl")();

    if (!valid) {
        $("#github-error").text("Por favor digite o endereço do seu Github");
        return false;
    }

    $("#github-error").text("");
});

$("input#githubUrl").on("focusout", () => {
    valid = validate_empty("input#githubUrl")();

    if (!valid) {
        $("#github-error").text("Por favor digite o endereço do seu Github");
        return false;
    }

    $("#github-error").text("");
});

$("input#salary").on("focusout", () => {
    valid = validate_empty("input#salary")();

    if (!valid) {
        $("#salary-error").text("Por favor digite a sua pretenção salarial");
        return false;
    }

    $("#salary-error").text("");
});

$("input#resume").on("change", () => {
    filename = $("input#resume").val();

    if (filename.trim() === "") {
        return;
    }
    filename = filename.replace(/.*[\/\\]/, "");
    $("span#upload-filename").text(filename);
});

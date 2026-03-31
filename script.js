document.getElementById("form").addEventListener("submit", function(e) {
    const senha = document.querySelector("input[name='senha']").value;

    if (senha.length < 6) {
        alert("Senha deve ter no mínimo 6 caracteres!");
        e.preventDefault();
    }
});
function resetForm() {
    document.getElementById('search-form').reset(); // Limpar o formulário
    window.location.href = window.location.pathname; // Limpar todos os parametros de filtragem passados no URL
}
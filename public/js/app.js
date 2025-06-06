// Caso queira um alerta customizado para exclusão (já tem confirm inline no botão)
document.querySelectorAll('form.delete-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        if (!confirm('Deseja realmente excluir esta tarefa?')) {
            e.preventDefault();
        }
    });
});

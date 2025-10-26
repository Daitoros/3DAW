// Função para verificar se o usuário tem a permissão correta
function protegerPagina(funcaoExigida) {
    const funcaoLogada = sessionStorage.getItem('funcao');

    if (funcaoLogada !== funcaoExigida) {
        // Se não tiver a permissão, manda de volta para o login
        window.location.href = 'index.html';
    }
}

// Função de Logoff
function logoff() {
    sessionStorage.removeItem('funcao');
    window.location.href = 'index.html';
}

// Função auxiliar para verificar se é o primeiro usuário
function ehPrimeiroCadastro() {
    const usuarios = JSON.parse(localStorage.getItem('usuarios') || '[]');
    return usuarios.length === 0;
}
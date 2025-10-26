/* === GERENCIAMENTO DE USUÁRIOS === */

// Função auxiliar para pegar todos os usuários
function getUsuarios() {
    // Pega os dados do localStorage. Se não existir, retorna um array vazio.
    const usuarios = localStorage.getItem('usuarios');
    return usuarios ? JSON.parse(usuarios) : [];
}

// Função auxiliar para salvar os usuários
function saveUsuarios(usuarios) {
    localStorage.setItem('usuarios', JSON.stringify(usuarios));
}

// Função para adicionar um novo usuário
function addUsuario(usuario) {
    const usuarios = getUsuarios();
    usuarios.push(usuario);
    saveUsuarios(usuarios);
}

// Função para pegar um usuário pelo seu índice (ID)
function getUsuarioById(id) {
    const usuarios = getUsuarios();
    return usuarios[id];
}

// Função para atualizar um usuário
function updateUsuario(id, usuarioAtualizado) {
    const usuarios = getUsuarios();
    usuarios[id] = usuarioAtualizado;
    saveUsuarios(usuarios);
}

// Função para deletar um usuário
function deleteUsuario(id) {
    let usuarios = getUsuarios();
    // Filtra o array, removendo o usuário com o índice (id) correspondente
    usuarios = usuarios.filter((_, index) => index != id);
    saveUsuarios(usuarios);
}

/* === GERENCIAMENTO DE PERGUNTAS === */

// Função auxiliar para pegar todas as perguntas
function getPerguntas() {
    const perguntas = localStorage.getItem('perguntas');
    return perguntas ? JSON.parse(perguntas) : [];
}

// Função auxiliar para salvar as perguntas
function savePerguntas(perguntas) {
    localStorage.setItem('perguntas', JSON.stringify(perguntas));
}

// Função para adicionar uma nova pergunta
function addPergunta(pergunta) {
    const perguntas = getPerguntas();
    perguntas.push(pergunta);
    savePerguntas(perguntas);
}

// Função para pegar uma pergunta pelo seu índice (ID)
function getPerguntaById(id) {
    const perguntas = getPerguntas();
    return perguntas[id];
}

// Função para atualizar uma pergunta
function updatePergunta(id, perguntaAtualizada) {
    const perguntas = getPerguntas();
    perguntas[id] = perguntaAtualizada;
    savePerguntas(perguntas);
}

// Função para deletar uma pergunta
function deletePergunta(id) {
    let perguntas = getPerguntas();
    perguntas = perguntas.filter((_, index) => index != id);
    savePerguntas(perguntas);
}
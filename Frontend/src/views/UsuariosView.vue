<script setup lang="ts">
import { ref } from "vue";
import api from "../services/api";

interface UsuarioForm {
  nome: string;
  data_nascimento: string;
  emails: string[];
  telefones: string[];
}

const usuario = ref<UsuarioForm>({
  nome: "",
  data_nascimento: "",
  emails: [""],
  telefones: [""],
});

const success = ref("");
const error = ref("");

function addEmail() {
  usuario.value.emails.push("");
}
function removeEmail(index: number) {
  usuario.value.emails.splice(index, 1);
}
function addTelefone() {
  usuario.value.telefones.push("");
}
function removeTelefone(index: number) {
  usuario.value.telefones.splice(index, 1);
}

async function salvarUsuario() {
  success.value = "";
  error.value = "";

  try {
    const response = await api.post("/usuarios", usuario.value);
    success.value = "Usuário cadastrado com sucesso!";
    console.log("Usuário criado:", response.data);

    usuario.value = {
      nome: "",
      data_nascimento: "",
      emails: [""],
      telefones: [""],
    };
  } catch (err) {
    console.error(err);
    error.value = "Erro ao cadastrar usuário.";
  }
}
</script>

<template>
  <section class="cadastro">
    <h1>Cadastrar Usuário</h1>

    <form @submit.prevent="salvarUsuario">
      <div class="campo">
        <label>Nome:</label>
        <input v-model="usuario.nome" required />
      </div>

      <div class="campo">
        <label>Data de Nascimento:</label>
        <input type="date" v-model="usuario.data_nascimento" required />
      </div>

      <div class="campo">
        <label>Emails:</label>
        <div v-for="(email, i) in usuario.emails" :key="i" class="subcampo">
          <input v-model="usuario.emails[i]" type="email" />
          <button type="button" @click="removeEmail(i)" v-if="usuario.emails.length > 1">–</button>
        </div>
        <button type="button" @click="addEmail">+ Adicionar Email</button>
      </div>

      <div class="campo">
        <label>Telefones:</label>
        <div v-for="(tel, i) in usuario.telefones" :key="i" class="subcampo">
          <input v-model="usuario.telefones[i]" maxlength="11" placeholder="DDD + número" />
          <button type="button" @click="removeTelefone(i)" v-if="usuario.telefones.length > 1">
            –
          </button>
        </div>
        <button type="button" @click="addTelefone">+ Adicionar Telefone</button>
      </div>

      <button type="submit">Salvar</button>
    </form>

    <p v-if="success" class="success">{{ success }}</p>
    <p v-if="error" class="error">{{ error }}</p>
  </section>
</template>

<style scoped>
.cadastro {
  max-width: 600px;
  margin: 2rem auto;
  padding: 1rem;
}

.campo {
  margin-bottom: 1rem;
}

.subcampo {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.5rem;
}

button {
  margin-top: 0.3rem;
}

.success {
  color: green;
  margin-top: 1rem;
}

.error {
  color: red;
  margin-top: 1rem;
}
</style>

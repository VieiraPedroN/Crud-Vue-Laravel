<script setup lang="ts">
import { ref } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

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

const router = useRouter();

const success = ref("");
const error = ref("");

function cadEmail() {
  usuario.value.emails.push("");
}
function cadTelefone() {
  usuario.value.telefones.push("");
}

function delEmail(index: number) {
  usuario.value.emails.splice(index, 1);
}
function delTelefone(index: number) {
  usuario.value.telefones.splice(index, 1);
}

function goToHome() {
  router.push("/");
}

async function saveUsuario() {
  success.value = "";
  error.value = "";

  try {
    const response = await api.post("/usuarios", usuario.value);
    success.value = "Usuario cadastrado com sucesso";
    console.log("Usuario criado: ", response.data);

    usuario.value = {
      nome: "",
      data_nascimento: "",
      emails: [""],
      telefones: [""],
    };
  } catch (err) {
    console.error("Erro ao cadastrar usuario: ", err);
  }
}
</script>

<template>
  <section class="cadastro">
    <h1>Cadastrar Usuario</h1>

    <form @submit.prevent="saveUsuario">
      <div class="campo">
        <label>Nome: </label>
        <input
          type="text"
          class="form-control"
          placeholder="Insira o Nome"
          v-model="usuario.nome"
          required
        />
      </div>

      <div class="campo">
        <label>Data de Nascimento: </label>
        <input type="date" class="form-control" v-model="usuario.data_nascimento" required />
      </div>

      <div class="campo">
        <label>Emails: </label>
        <div v-for="(email, i) in usuario.emails" :key="i" class="subcampo">
          <div class="incrementar">
            <input
              type="email"
              class="form-control"
              placeholder="Insira o Email"
              v-model="usuario.emails[i]"
            />
            <button
              class="btn btn-danger remover"
              type="button"
              @click="delEmail(i)"
              v-if="usuario.emails.length > 1"
            >
              –
            </button>
          </div>
        </div>
        <button class="btn btn-sm btn-success adicionar" type="button" @click="cadEmail">
          + Adicionar Email
        </button>
      </div>

      <div class="campo">
        <label>Telefones: </label>
        <div v-for="(tel, i) in usuario.telefones" :key="i" class="subcampo">
          <div class="incrementar">
            <input
              type="tel"
              class="form-control"
              maxlength="11"
              placeholder="(xx) xxxxx-xxxx"
              v-model="usuario.telefones[i]"
            />
            <button
              class="btn btn-danger remover"
              type="button"
              @click="delTelefone(i)"
              v-if="usuario.telefones.length > 1"
            >
              –
            </button>
          </div>
        </div>
        <button class="btn btn-sm btn-success adicionar" type="button" @click="cadTelefone">
          + Adicionar Telefone
        </button>
      </div>

      <div class="acoes">
        <button class="btn btn-danger voltar" type="button" @click="goToHome()">Voltar</button>
        <button class="btn btn-success salvar" type="submit">Salvar</button>
      </div>
    </form>

    <p v-if="success" class="success">{{ success }}</p>
    <p v-if="error" class="error">{{ error }}</p>
  </section>
</template>

<style scoped>
form {
  display: flex;
  flex-direction: column;
}

.cadastro {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-top: 3rem;
}

.campo {
  display: flex;
  flex-direction: column;
  padding: 0.5rem;
  width: 20rem;
}

.adicionar {
  margin-top: 1rem;
}

.acoes {
  display: flex;
  justify-content: space-around;
  margin-top: 2rem;
}

.acoes button {
  width: 8rem;
}

.incrementar {
  display: flex;
  flex-direction: row;
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

<script setup lang="ts">
import { ref, onMounted } from "vue";
import api from "../services/api";
import { useRouter } from "vue-router";

interface Email {
  id: number;
  email: string;
}

interface Telefone {
  id: number;
  telefone: string;
}

interface Usuario {
  id: number;
  nome: string;
  data_nascimento: string;
  emails: Email[];
  telefones: Telefone[];
}

const usuarios = ref<Usuario[]>([]);
const router = useRouter();

onMounted(async () => {
  try {
    const response = await api.get("/usuarios");
    usuarios.value = response.data;
  } catch (err) {
    console.error("Erro ao buscar usuarios: ", err);
  }
});

async function delUsuario(usuario: Usuario) {
  const confirmar = confirm(`Tem certeza que deseja excluir o usuário: ${usuario.nome}?`);

  if (confirmar) {
    try {
      await api.delete(`/usuarios/${usuario.id}`);
    } catch (err) {
      console.error("Erro ao excluir usuario:  ", err);
    }
  }
}

function cadUsuario() {
  router.push("/usuarios");
}
</script>

<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Usuarios Cadastrados</h2>
      <button class="btn btn-success" @click="cadUsuario">+ Cadastro de Usuario</button>
    </div>

    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Data de Nascimento</th>
          <th>Emails</th>
          <th>Telefones</th>
          <th class="text-center" style="width: 180px">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="usuario in usuarios" :key="usuario.id">
          <td>{{ usuario.id }}</td>
          <td>{{ usuario.nome }}</td>
          <td>{{ new Date(usuario.data_nascimento).toLocaleDateString() }}</td>
          <td>
            <ul class="mb-0">
              <li v-for="email in usuario.emails" :key="email.id">{{ email.email }}</li>
            </ul>
          </td>
          <td>
            <ul class="mb-0">
              <li v-for="tel in usuario.telefones" :key="tel.id">{{ tel.telefone }}</li>
            </ul>
          </td>
          <td class="text-center">
            <button class="btn btn-sm btn-danger" @click="delUsuario(usuario)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.table {
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
}

ul {
  padding-left: 1rem;
}
</style>

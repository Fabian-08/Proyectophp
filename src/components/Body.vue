<template>
  <main>
    <form @submit.prevent="submitForm">
      <div id="Inputs">
        <div>
        <label for="name">Nombre:</label>
        <input type="text" id="name" v-model="name" />
      </div>
      <div>
        <label for="number">Número:</label>
        <input type="text" id="number" v-model="number" />
      </div>
      <div>
        <label for="email">Correo:</label>
        <input type="email" id="email" v-model="email" />
      </div>
      </div>
      <button type="submit">Añadir</button>
    </form>
    <div class="entries">
      <h2>Entradas:</h2>
      <ul>
        <li v-for="(entry, index) in entries" :key="index">
          {{ entry.name }} - {{ entry.number }} - {{ entry.email }}
        </li>
      </ul>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      number: "",
      email: "",
      entries: []
    };
  },
  methods: {
    submitForm() {
      if (this.name.trim() && this.number.trim() && this.email.trim()) {
        this.entries.push({
          name: this.name.trim(),
          number: this.number.trim(),
          email: this.email.trim()
        });
        this.name = "";
        this.number = "";
        this.email = "";
      }
    }
  }
};
</script>

<style scoped>

</style>

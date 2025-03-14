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
    <!-- Botón con animación de confeti -->
    <button @click="showImageAndConfetti" class="confetti-button">
      !Si mi Definitiva Es 5!
    </button>
    <button @click="pop" class="botton">
  !Si mi Definitiva Es 0!
</button>
<div v-if="showImage" class="image-container">
  <img src="../images/7a0cdcb657b299ea1ef491250138e4e6.gif" alt="Imagen confeti" />
</div>
<div v-if="showSadImage" class="image-container">
  <img src="../images/triste.gif" alt="Imagen triste" />
</div>

  </main>
</template>

<script>
import "../style.css"; 
export default {
  data() {
    return {
      name: "",
      number: "",
      email: "",
      entries: [],
      showImage: false, // Imagen de confeti
      showSadImage: false // Imagen triste
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
    },
    showImageAndConfetti() {
      this.showImage = true;  // Mostrar imagen de confeti
      this.showSadImage = false; // Asegurarse de que la otra imagen está oculta
      this.launchConfetti();
    },
    launchConfetti() {
      for (let i = 0; i < 100; i++) {
        const confettiPiece = document.createElement("div");
        confettiPiece.classList.add("confetti-piece");

        confettiPiece.style.left = Math.random() * 100 + "vw";
        confettiPiece.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;

        document.body.appendChild(confettiPiece);

        setTimeout(() => {
          confettiPiece.remove();
        }, 2000);
      }
    },
    pop() {
      this.showImage = false; // Asegurarse de que la imagen de confeti está oculta
      this.showSadImage = true; // Mostrar imagen triste
      const container = document.createElement("div");
      container.style.position = "fixed";
      container.style.top = "0";
      container.style.left = "0";
      container.style.width = "100%";
      container.style.height = "100%";
      container.style.pointerEvents = "none";
      document.body.appendChild(container);

      for (let i = 0; i < 50; i++) {
        const poop = document.createElement("div");
        poop.textContent = "💩";
        poop.style.position = "absolute";
        poop.style.fontSize = `${Math.random() * 30 + 20}px`;
        poop.style.left = `${Math.random() * 100}vw`;
        poop.style.animation = "fall 3s linear";
        container.appendChild(poop);

        poop.addEventListener("animationend", () => poop.remove());
      }

      setTimeout(() => container.remove(), 3000);
    }
  }
};

</script>

<style scoped>
.image-container img {
  max-width: 100%;
  margin-top: 20px;
}

.confetti-button {
  margin-top: 20px;
  padding: 10px 20px;
  font-size: 16px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.confetti-button:hover {
  background-color: #45a049;
}
</style>



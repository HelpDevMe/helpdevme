<template>
  <div v-if="formActive" class="card-footer">
    <form @submit.prevent="sendMessage">
      <div class="input-group">
        <textarea
          class="form-control"
          placeholder="Digite uma mensagem..."
          v-model="body"
          @keydown="onTyping"
          @keydown.enter="sendMessage"
          required
        ></textarea>
        <div class="input-group-append">
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  props: ["formActive", "channel", "talk"],
  data() {
    return {
      body: null
    };
  },
  methods: {
    onTyping() {
      if (!this.body) return;

      this.$emit("onTyping");
    },
    sendMessage() {
      if (!this.body) return;

      axios
        .post("/api/posts", {
          body: this.body,
          talk_id: this.talk.id,
          question_id: this.talk.question.id
        })
        .then(response => {
          this.body = null;
          this.$emit("submit", response.data.post);
        });
    }
  }
};
</script>


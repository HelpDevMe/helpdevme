<template>
  <div class="card-footer">
    <form @submit.prevent="addComments">
      <div class="form-row">
        <div class="col-lg">
          <input
            name="body"
            placeholder="Escreva uma mensagem..."
            v-model="body"
            class="form-control"
            @keydown="onTyping"
            required
          />
        </div>
        <div class="col-lg-2">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">R$</span>
            </div>
            <input
              type="number"
              class="form-control"
              v-model="budget"
              name="budget"
              @keydown="onTyping"
              placeholder="Orçamento"
            />
          </div>
        </div>
        <div class="col flex-grow-0">
          <button type="submit" class="btn btn-primary btn-block">
            <i v-if="!loading" class="fas fa-paper-plane"></i>
            <span v-else class="ellipsis"></span>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
export default {
	props: ['question'],
	data() {
		return {
            channel: `comments.${this.question.id}`,
			loading: false,
			body: undefined,
			budget: undefined,
		};
	},
	methods: {
		onTyping() {
			const privateChannel = Echo.private(this.channel + '.private');

			setTimeout(() => {
				privateChannel.whisper('typing', {
					typing: true
				});
			}, 300);
		},
		resetForm() {
			this.body = undefined;
			this.budget = undefined;
		},
		addComments() {
			this.loading = true;

			axios
				.post('/api/comments', {
					type: 1, // comment
					body: this.body,
					budget: this.budget,
					question_id: this.question.id,
					receiver_id: this.question.user_id
				})
				.then(response => {
                    const { post } = response.data;

					this.loading = false;
                    this.resetForm();

                    this.$emit('create', post);

					this.$bvToast.toast('Comentário enviado!', {
						title: 'Sucesso!',
						variant: 'success',
						solid: true
					});
				})
				.catch(() => {
					this.loading = false;

					this.$bvToast.toast('Tente novamente de uma forma diferente!', {
						title: 'Algo deu errado!',
						variant: 'danger',
						solid: true
					});
				});
		}
	}
};
</script>

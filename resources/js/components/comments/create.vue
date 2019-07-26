<template>
  <form @submit.prevent="addComments">
    <b-input-group>
      <b-form-input
        @keydown="onTyping"
        placeholder="Escreva uma mensagem..."
        v-model="body"
        required
      ></b-form-input>

      <b-input-group-append>
        <b-dropdown variant="outline-primary" v-b-tooltip.hover title="Adicionar Orçamento" right slot="append">
          <template slot="button-content">
            <i class="fas fa-hand-holding-usd"></i>
          </template>
          <b-dropdown-form>
            <b-form-group label="Orçamento" label-for="dropdown-form-budget" @submit.stop.prevent>
              <b-input-group prepend="R$">
                <b-form-input
                  id="dropdown-form-budget"
                  v-model="budget"
                  @keydown="onTyping"
                  placeholder="2,50"
                ></b-form-input>
              </b-input-group>
            </b-form-group>
          </b-dropdown-form>
        </b-dropdown>
        <b-button variant="primary" type="submit" v-b-tooltip.hover title="Enviar">
          <i v-if="!loading" class="fas fa-paper-plane"></i>
          <span v-else class="ellipsis"></span>
        </b-button>
      </b-input-group-append>
    </b-input-group>
  </form>
</template>
<script>
export default {
	props: ['question'],
	data() {
		return {
			channel: `comments.${this.question.id}`,
			loading: false,
			body: undefined,
			budget: undefined
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

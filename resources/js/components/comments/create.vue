<template>
  <form @submit.prevent="onSubmit">
    <b-input-group>
      <b-form-input
        @keydown="onTyping"
        placeholder="Escreva uma mensagem..."
        v-model="body"
        required
      ></b-form-input>

      <b-input-group-append>
        <b-dropdown
          variant="outline-primary"
          v-b-tooltip.hover
          title="Adicionar Orçamento"
          right
          slot="append"
        >
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
import { mapActions } from 'vuex';

export default {
	props: ['question'],
	data() {
		return {
			loading: false,
			body: undefined,
			budget: undefined
		};
	},
	methods: {
		onTyping() {
			const privateChannel = Echo.private(
				`comments.${this.question.id}.private`
			);

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
		onSubmit() {
			this.loading = true;

			this.addComment({
				type: 1, // comment
				body: this.body,
				budget: this.budget,
				question_id: this.question.id,
				receiver_id: this.question.user_id
			})
				.then(response => {
					this.loading = false;
					this.resetForm();

					this.$bvToast.toast('Comentário enviado!', {
						title: 'Sucesso!',
						variant: 'success',
						solid: true
					});
				})
				.catch(error => {
					this.loading = false;

					this.$bvToast.toast('Tente novamente de uma forma diferente!', {
						title: 'Algo deu errado!',
						variant: 'danger',
						solid: true
					});
				});
		},
		...mapActions('questions', ['addComment'])
	}
};
</script>

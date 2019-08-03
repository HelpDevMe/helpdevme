<template>
  <section class="create-question">
    <b-button
      @click="$bvModal.show('modal-create-question')"
      variant="link"
      class="btn-block card card-body card mb-5"
    >
      <div class="d-flex">
        <div class="pr-3">
          <img
            v-if="user.avatar"
            class="img-fluid avatar"
            :src="'/storage/img/avatars/' + user.avatar"
            v-bind:alt="user.name"
            v-bind:title="user.name"
          />
          <i v-else class="fas fa-user-circle fa-4x"></i>
        </div>
        <div class="flex-grow-1">
          <div class="placeholder text-muted py-3">Qual sua dúvida sobre programação?</div>
        </div>
      </div>
    </b-button>

    <b-modal id="modal-create-question" size="lg">
      <template slot="modal-header" slot-scope="{ close }">
        <span>Criar Pergunta</span>
        <a href="javascript:void(0)" class="close" @click="close()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </template>

      <template slot="default">
        <div class="d-flex">
          <div class="pr-3">
            <img
              v-if="user.avatar"
              class="img-fluid avatar"
              :src="'/storage/img/avatars/' + user.avatar"
              v-bind:alt="user.name"
              v-bind:title="user.name"
            />
            <i v-else class="fas fa-user-circle fa-4x"></i>
          </div>
          <div class="flex-grow-1">
            <form @submit.prevent="onSubmit">
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="title"
                  v-model="title"
                  placeholder="Qual sua dúvida sobre programação?"
                  @keydown="onTyping"
                  required
                />
              </div>
              <div class="form-group">
                <!-- <textarea
                  @keydown="onTyping"
                  name="body"
                  class="form-control"
                  v-model="body"
                  placeholder="Pergunta"
                  required
                ></textarea> -->
                <vue-editor v-model="body" />
              </div>
              <div class="form-group">
                <multiselect
                  v-model="tags"
                  tag-placeholder="Adicione isto como nova tag"
                  placeholder="Pesquise ou adicione uma tag"
                  label="title"
                  track-by="id"
                  :options="options"
                  :multiple="true"
                  :taggable="true"
                  @tag="addTag"
                ></multiselect>
              </div>
              <div class="form-row justify-content-end">
                <div class="col-lg-3">
                  <button type="submit" class="d-none" id="submit-modal-create-question"></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </template>

      <template slot="modal-footer">
        <label for="submit-modal-create-question" class="btn btn-success px-5">
          <span v-if="!loading">Enviar</span>
          <span v-else class="ellipsis"></span>
        </label>
      </template>
    </b-modal>
  </section>
</template>

<script>
import { mapActions } from 'vuex';
import Multiselect from 'vue-multiselect';
import { VueEditor } from 'vue2-editor';

export default {
	props: ['user'],
	components: {
        Multiselect,
        VueEditor
	},
	data() {
		return {
			focus: false,
			title: undefined,
			body: undefined,
			loading: false,
			tags: [],
			options: []
		};
	},
	methods: {
		...mapActions('questions', ['addQuestion']),
		onTyping() {
			const privateChannel = Echo.private('newquestions');

			setTimeout(() => {
				privateChannel.whisper('typing', {
					typing: true
				});
			}, 300);
		},
		resetForm() {
			this.focus = false;

			this.title = undefined;
			this.body = undefined;
			this.tags = [];
		},
		addTag(newTag) {
			axios
				.post('/api/tags', {
					title: newTag
				})
				.then(response => {
					let tag = response.data.tag;

					this.options.push(tag);
					this.tags.push(tag);
				});
		},
		listTags() {
			axios.get('/api/tags').then(response => {
				this.options = response.data.tags;
			});
		},
		onSubmit() {
			this.loading = true;

			this.addQuestion({
				title: this.title,
				body: this.body,
				tags: this.tags.map(tag => tag.id)
			})
				.then(() => {
					this.loading = false;
					this.resetForm();

					this.$bvToast.toast('Sua pergunta foi criada!', {
						title: 'Sucesso!',
						variant: 'success',
						solid: true
					});
				})
				.catch(() => {
					this.loading = false;

					this.$bvToast.toast(
						'Tente novamente de uma forma diferente!',
						{
							title: 'Algo deu errado!',
							variant: 'danger',
							solid: true
						}
					);
				});
		}
	},
	mounted() {
		this.listTags();
	}
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

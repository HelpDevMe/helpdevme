<template>
  <section>
    <p class="lead">
      <span>Conversa com</span>
      <a :href="'/users/' + opposite.id" class="badge badge-secondary">
        <span :class="(onlineFriends.find(user=>user.id===opposite.id))?'text-success':''">&bull;</span>
        <span>{{ opposite.name }}</span>
      </a>
    </p>
    <!-- Finalização da Questão -->
    <div class="form-group" v-if="!finished && talk.question.status == 2">
      <a :href="'/' + talk.question.slug + '/finalize'" class="btn btn-warning">Finalizar Questão</a>
    </div>
    {{ finished }}
    <div v-if="finished">
      <div class="card text-white bg-warning mb-3">
        <div class="card-body">
          <h5 class="card-title">Você finalizou essa questão!</h5>
          <p
            class="card-text"
          >Esperamos que tudo esteja bem e {{ opposite.name }} também finalize. Caso contrário ambos poderão solicitiar o processo de arbitragem.</p>
        </div>
        <div class="card-footer">
          <button type="button" class="btn btn-sm btn-outline-light">Solicitar Arbitragem</button>
          <button type="button" class="btn btn-sm btn-success">Continuar Trabalhando</button>
        </div>
      </div>
    </div>
    <!-- Fim da Finalização da Questão -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <div id="privateMessageBox">
              <div class="d-flex flex-column p-3">
                <div v-for="(post, index) in allPosts" :key="index" class="h5">
                  <!-- Proposta Recusada -->
                  <div v-if="post.type==2 && post.status==1" class="text-center">
                    <span class="badge badge-pill py-2 px-5 badge-danger">{{ post.body }}</span>
                  </div>
                  <!-- Proposta Aceita -->
                  <div v-if="post.type==2 && post.status==2" class="text-center">
                    <span class="badge badge-pill py-2 px-5 badge-info">{{ post.body }}</span>
                  </div>
                  <!-- Pagamento Efetuado -->
                  <div v-if="post.type==2 && post.status==3" class="text-center">
                    <span class="badge badge-pill py-2 px-5 badge-success">{{ post.body }}</span>
                  </div>
                  <!-- Questão Finalizada -->
                  <div v-if="post.type==2 && post.status==4" class="text-center">
                    <span class="badge badge-pill py-2 px-5 badge-warning">{{ post.body }}</span>
                  </div>
                  <!-- Proposta -->
                  <div v-if="post.type!=2 && post.budget" class="card bg-light mb-5">
                    <div class="card-body">
                      <p class="card-text">
                        {{ post.body }}
                        <span class="text-success">R$ {{ formatPrice(post.budget) }}</span>
                      </p>
                    </div>
                    <!-- Não exibir se for quem enviou a proposta -->
                    <!-- Só mostrar se o usuario for quem recebeu a proposta, quem efetuou essa proposta não verá -->
                    <div class="card-footer" v-if="user.id==talk.receiver_id && post.status!=3">
                      <!-- Proposta NÃO aceita ainda -->
                      <a
                        v-if="post.status==0 || post.status==1"
                        :href="'/posts/accept/' + post.id"
                        class="btn btn-success"
                      >Aceitar</a>
                      <!-- Proposta aceita -->
                      <a
                        v-if="post.status==2"
                        :href="'/payments/' + post.id"
                        class="btn btn-success"
                      >Pagar</a>
                      <!-- Proposta aceita OU proposta em analise -->
                      <a
                        v-if="post.status!=1"
                        :href="'/posts/refused/' + post.id"
                        class="btn btn-link btn-sm text-secondary"
                      >Recusar</a>
                    </div>
                  </div>
                  <!-- Post -->
                  <div
                    v-if="post.type!=2 && !post.budget"
                    :class="user.id==post.user_id ? 'text-right' : ''"
                  >
                    <span v-if="user.id!=post.user_id">
                      <img
                        v-if="opposite.avatar"
                        width="25"
                        class="img-fluid"
                        :src="'/storage/img/avatars/' + opposite.avatar"
                        v-bind:alt="opposite.name"
                        v-bind:title="opposite.name"
                      />
                      <i v-else class="fas fa-user-circle fa-lg"></i>
                    </span>
                    <span
                      class="badge badge-pill py-2 px-3"
                      :class="(user.id!==post.user_id)?'badge-secondary':'badge-primary'"
                    >{{ post.body }}</span>
                  </div>
                </div>
              </div>
              <small v-if="typing" class="text-muted ellipsis">{{ opposite.name }} está digitando</small>
            </div>
          </div>
        </div>
      </div>
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
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
export default {
	props: ['user', 'talk', 'opposite', 'posts'],

	data() {
		return {
			channel: `privatechat.${this.talk.id}`,
			body: null,
			timeOut: undefined,
			formActive: true,
			typing: false,
			onlineFriends: [],
			allPosts: []
		};
	},

	computed: {
		finished: function() {
			const { question } = this.talk;

			return (
				(question.user_id == this.user.id && question.user_ended == 1) ||
				(question.user_id != this.user.id && question.freelancer_ended == 1)
			);
		}
	},

	methods: {
		formatPrice(value) {
			let val = (value / 1).toFixed(2).replace('.', ',');
			return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
		},
		onTyping() {
			const privateChannel = Echo.private(this.channel + '.private');

			setTimeout(() => {
				privateChannel.whisper('typing', {
					typing: true
				});
			}, 300);
		},
		sendMessage() {
			axios
				.post('/api/posts', {
					type: 0, // message
					body: this.body,
					talk_id: this.talk.id,
					question_id: this.talk.question.id,
					receiver_id: this.talk.question.user_id
				})
				.then(response => {
					this.body = null;
					this.allPosts.push(response.data.post);
				});
		},
		fetchMessages() {
			this.allPosts = this.posts;
			this.talkStatus(this.talk);
		},
		talkStatus(talk) {
			this.formActive = talk.status == 1 ? false : true;
		}
	},

	created() {
		this.fetchMessages();

		Echo.join(this.channel + '.join')
			.here(users => {
				this.onlineFriends = users;
			})
			.joining(user => {
				this.onlineFriends.push(user);
			})
			.leaving(user => {
				this.onlineFriends.splice(this.onlineFriends.indexOf(user), 1);
			});

		Echo.private(`${this.channel}.private`)
			.listen('PrivatePostSent', response => {
				const { post } = response;

				this.talkStatus(post.talk);
				this.allPosts.push(post);
			})
			.listenForWhisper('typing', e => {
				this.typing = e.typing;

				clearTimeout(this.timeOut);

				this.timeOut = setTimeout(() => {
					this.typing = false;
				}, 900);
			});
	}
};
</script>

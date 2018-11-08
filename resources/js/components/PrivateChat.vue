<template>
   <section>
      <p class="lead">
        <span>Conversa com</span>
        <a href="#" class="badge badge-secondary">
          <span :class="(onlineFriends.find(user=>user.id===opposite.id))?'text-success':''">&bull;</span>
          <span>{{ opposite.name }}</span>
        </a>
      </p>
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col">
                  <div id="privateMessageBox">
                     <div class="d-flex flex-column p-3">
                        <div v-for="(post, index) in allPosts" :key="index" class="h5">
                            <!-- Proposta Aceita -->
                            <div v-if="post.type==2" class="text-center">
                              <span class="badge badge-pill py-2 px-3 badge-info">{{ post.body }}</span>
                            </div>
                            <!-- Pagamento Efetuado -->
                            <div v-if="post.type==3" class="text-center">
                              <span class="badge badge-pill py-2 px-3 badge-success">{{ post.body }}</span>
                            </div>
                            <!-- Proposta -->
                            <div v-if="post.budget" class="card bg-light mb-5">
                              <div class="card-body">
                                <p class="card-text">
                                  {{ post.body }}
                                  <span class="text-success">R$ {{ formatPrice(post.budget) }}</span>
                                </p>
                              </div>
                              <div class="card-footer" v-if="user.id==talk.receiver_id">
                                <!-- Não exibir se for quem enviou a proposta -->
                                <a :href="'/payments/' + post.id" class="btn btn-success">Pagar</a>
                                <button type="button" class="btn btn-link text-secondary">Recusar</button>
                              </div>
                            </div>
                            <!-- Post -->
                            <div v-if="(post.type==0 || post.type==1) && !post.budget" :class="user.id==post.user_id ? 'text-right' : ''">
                              <img v-if="user.id!=post.user_id" width="25" class="img-fluid" :src="'/storage/img/avatars/' + opposite.avatar" v-bind:alt="opposite.name" v-bind:title="opposite.name">
                              <span class="badge badge-pill py-2 px-3" :class="(user.id!==post.user_id)?'badge-secondary':'badge-primary'">{{ post.body }}</span>
                            </div>
                        </div>
                     </div>
                     <p v-if="typing">{{ opposite.name }} está digitando</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="card-footer">
           <form @submit.prevent="sendMessage">
              <div class="input-group">
                <textarea class="form-control" placeholder="Digite uma mensagem..." v-model="body" @keydown="onTyping" @keydown.enter="sendMessage" required></textarea>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary">Enviar</button>
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
      channel: `privatechat.${this.talk.user_id}.${this.talk.receiver_id}`,
      body: null,
      typing: false,
      onlineFriends: [],
      allPosts: []
    };
  },

  methods: {
    formatPrice(value) {
      let val = (value/1).toFixed(2).replace('.', ',')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },
    onTyping() {
      Echo.private(this.channel + '.private').whisper('typing');
    },
    sendMessage() {
      axios
        .post('/api/posts', {
          body: this.body,
          talk_id: this.talk.id
        })
        .then(response => {
          this.body = null;
          this.allPosts.push(response.data.post);
        });
    },
    fetchMessages() {
      this.allPosts = this.posts;
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

    Echo.private(this.channel + '.private')
      .listen('PrivatePostSent', e => {        
        this.allPosts.push(e.post);
      })
      .listenForWhisper('typing', e => {
        this.typing = true;

        setTimeout(() => {
          this.typing = false;
        }, 1000);
      });
  }
};
</script>
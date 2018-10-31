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
                        <div class="h5" v-for="(post, index) in allPosts" :key="index" :class="user.id==post.user_id ? 'text-right' : ''">
                           <img v-if="user.id!=post.user_id" width="25" class="img-fluid" :src="'/storage/img/avatars/' + opposite.avatar" v-bind:alt="opposite.name" v-bind:title="opposite.name">
                           <span class="badge badge-pill py-2 px-3" :class="(user.id!==post.user_id)?'badge-secondary':'badge-primary'">{{ post.body }}</span>
                        </div>
                     </div>
                     <p v-if="typing">{{ opposite.name }} está digitando</p>
                  </div>
                  <!-- Form -->
                  <div class="input-group">
                     <textarea class="form-control" placeholder="Digite uma mensagem..." v-model="body" @keydown="onTyping" @keydown.enter="sendMessage"></textarea>
                     <div class="input-group-append">
                        <button @click="sendMessage" class="btn btn-primary">Enviar</button>
                     </div>
                  </div>
               </div>
            </div>
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
        console.log('leaving', user);
        this.onlineFriends.splice(this.onlineFriends.indexOf(user), 1);
      });

    Echo.private(this.channel + '.private')
      .listen('PrivatePostSent', e => {
        console.log('PrivatePostSent', e);
        this.allPosts.push(e.post);
      })
      .listenForWhisper('typing', e => {
        console.log('listenForWhisper');
        this.typing = true;

        setTimeout(() => {
          console.log('setTimeout');
          this.typing = false;
        }, 1000);
      });
  }
};
</script>
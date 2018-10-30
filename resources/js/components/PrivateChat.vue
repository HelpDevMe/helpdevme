<template>
   <div>
     <div class="row">
        <div class="col">
          <div id="privateMessageBox">
              <div class="d-flex flex-column p-3">
                  <div class="h5" v-for="(post, index) in allPosts" :key="index" :class="user.id==post.user.id ? 'text-right' : ''">
                      <!-- <pre class="my-5">
                        {{ post }}
                      </pre> -->
                      <img width="25" class="img-fluid" :src="'/storage/img/avatars/' + post.user.avatar" v-bind:alt="post.user.name" v-bind:title="post.user.name">
                      <span class="badge badge-pill py-2 px-3" :class="(user.id!==post.user.id)?'badge-secondary':'badge-primary'">{{ post.body }}</span>
                  </div>
              </div>
              <p v-if="typingFriend.name">{{ typingFriend.name }} está digitando</p>
          </div>
          <!-- Form -->
          <div class="input-group">
            <textarea class="form-control" placeholder="Digite uma mensagem..." v-model="body" @keydown="onTyping" @keyup.enter="sendMessage"></textarea>
            <div class="input-group-append">
                <button @click="sendMessage" class="btn btn-primary">Enviar</button>
            </div>
          </div>
        </div>
      </div>
   </div>
</template>

<script>
export default {
  props: ['user', 'question', 'opposite'],

  data() {
    return {
      body: null,
      typingFriend: {},
      onlineFriends: [],
      allPosts: [],
      typingClock: null
    };
  },

  computed: {
  },

  watch: {
  },

  methods: {
    onTyping() {
      Echo.private('privatechat.' + this.question.id).whisper('typing', {
        user: this.user
      });
    },
    sendMessage() {
      axios
        .post('/api/posts', {
          body: this.body,
          receiver_id: this.opposite.id,
          question_id: this.question.id
        })
        .then(response => {
          this.body = null;
          this.allPosts.push(response.data.post);
        });
    },
    fetchMessages() {
      axios.get('/api/posts/' + this.question.id).then(response => {
        this.allPosts = response.data;
      });
    }
  },

  mounted() {},

  created() {

    this.fetchMessages();

    Echo.join('privatechat')
      .here(users => {
        this.onlineFriends = users;
      })
      .joining(user => {
        this.onlineFriends.push(user);
      })
      .leaving(user => {
        this.onlineFriends.splice(this.onlineFriends.indexOf(user), 1);
      });

    Echo.private('privatechat.' + this.question.id)
      .listen('PrivatePostSent', e => {
        this.opposite.id = e.post.user_id;
        this.allPosts.push(e.post);
      })
      .listenForWhisper('typing', e => {

        if (e.user.id == this.opposite.id) {
          this.typingFriend = e.user;

          if (this.typingClock) clearTimeout();

          this.typingClock = setTimeout(() => {
            this.typingFriend = {};
          }, 9000);
        }
      });
  }
};
</script>
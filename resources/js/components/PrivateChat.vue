<template>
   <div>
     <div class="row" v-show="!loading">
        <div class="col-lg-3">
          <nav class="nav nav-pills nav-justified" role="tablist" aria-orientation="vertical">
              <a href="javascript:void(0)" v-for="friend in friends" :class="(friend.id==activeFriend)?'active':''" :key="friend.id" @click="activeFriend=friend.id" class="nav-link w-100" role="tab">
              <span class="mr-2" :class="(onlineFriends.find(user=>user.id===friend.id))?'text-success':'text-muted'">&#9679;</span>
              <span>{{ friend.name }}</span>
              </a>
          </nav>
        </div>
        <div class="col-lg-9">
          <div id="privateMessageBox" v-show="!loadingMessage">
              <div class="d-flex flex-column p-3">
                  <div class="h5" v-for="(message, index) in allMessages" :key="index" :class="user.id==message.user.id ? 'text-right' : ''">
                      <img width="25" class="img-fluid" :src="'/storage/img/avatars/' + message.user.avatar" v-bind:alt="message.user.name" v-bind:title="message.user.name">
                      <span class="badge badge-pill py-2 px-3" :class="(user.id!==message.user.id)?'badge-secondary':'badge-primary'">{{ message.body }}</span>
                  </div>
              </div>
              <p v-if="typingFriend.name">{{ typingFriend.name }} está digitando</p>
          </div>
          <div v-show="loadingMessage">carregando mensagens</div>
          <!-- Form -->
          <div class="input-group">
            <textarea class="form-control" placeholder="Digite uma mensagem..." v-model="body" @keydown="onTyping" @keyup.enter="sendMessage"></textarea>
            <div class="input-group-append">
                <button @click="sendMessage" class="btn btn-primary">Enviar</button>
            </div>
          </div>
        </div>
      </div>
      <div v-show="loading">carregando</div>
   </div>
</template>

<script>
export default {
  props: ["user"],

  data() {
    return {
      loading: true,
      loadingMessage: true,
      body: null,
      activeFriend: null,
      typingFriend: {},
      onlineFriends: [],
      allMessages: [],
      typingClock: null,
      users: []
    };
  },

  computed: {
    friends() {
      return this.users.filter(user => {
        return user.id !== this.user.id;
      });
    }
  },

  watch: {
    activeFriend(val) {
      this.loadingMessage = true;
      this.fetchMessages();
    }
  },

  methods: {
    onTyping() {
      console.log("onTyping");
      Echo.private("privatechat." + this.activeFriend).whisper("typing", {
        user: this.user
      });
    },
    sendMessage() {
      //check if there message
      if (!this.body) {
        return alert("Please enter message");
      }
      if (!this.activeFriend) {
        return alert("Please select friend");
      }

      axios
        .post("/api/posts", {
          body: this.body,
          receiver_id: this.activeFriend
        })
        .then(response => {
          this.body = null;
          this.allMessages.push(response.data.message);
          setTimeout(this.scrollToEnd, 100);
        });
    },
    fetchMessages() {
      if (!this.activeFriend) {
        return alert("Please select friend");
      }
      axios.get("/api/posts/" + this.activeFriend).then(response => {
        this.allMessages = response.data;
        this.loading = false;
        this.loadingMessage = false;
      });
    },
    fetchUsers() {
      axios.get("/api/users").then(response => {
        this.users = response.data;
        if (this.friends.length > 0) {
          this.activeFriend = this.friends[0].id;
        }
      });
    },

    scrollToEnd() {
      document.getElementById("privateMessageBox").scrollTo(0, 99999);
    }
  },

  mounted() {},

  created() {
    this.fetchUsers();

    Echo.join("privatechat")
      .here(users => {
        console.log("online", users);
        this.onlineFriends = users;
      })
      .joining(user => {
        this.onlineFriends.push(user);
        console.log("joining", user.name);
      })
      .leaving(user => {
        this.onlineFriends.splice(this.onlineFriends.indexOf(user), 1);
        console.log("leaving", user.name);
      });

    Echo.private("privatechat." + this.user.id)
      .listen("PrivatePostSent", e => {
        console.log("pmessage sent");
        this.activeFriend = e.message.user_id;
        this.allMessages.push(e.message);
        setTimeout(this.scrollToEnd, 100);
      })
      .listenForWhisper("typing", e => {
        console.log("listenForWhisper typing");
        if (e.user.id == this.activeFriend) {
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
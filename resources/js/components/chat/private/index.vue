<template>
  <section>
    <header-chat :user="user" :opposite="opposite" :channel="channel"></header-chat>
    <btn-finalize :talk="talk" :iFinished="iFinished"></btn-finalize>
    <alert-finalize :iFinished="iFinished" :opposite="opposite"></alert-finalize>
    <div id="privateMessageBox" class="card card-body">
      <div class="d-flex flex-column p-3" v-for="(post, index) in allPosts" :key="index">
        <alerts :post="post"></alerts>
        <proposal :post="post" :user="user" :talk="talk"></proposal>
        <message :post="post" :user="user" :opposite="opposite"></message>
      </div>
      <small v-if="typing" class="typing text-center text-muted">
        <span>digitando</span>
      </small>
    </div>
    <form-chat
      :talk="talk"
      :channel="channel"
      :formActive="formActive"
      @submit="onSubmitForm"
      @onTyping="onTyping"
    ></form-chat>
  </section>
</template>

<script>
Vue.component("alert-finalize", require("./_finalize"));
Vue.component("form-chat", require("./_form"));
Vue.component("alerts", require("./_alerts"));
Vue.component("header-chat", require("./_header"));
Vue.component("message", require("./_post"));
Vue.component("btn-finalize", require("./_btnFinalize"));
Vue.component("proposal", require("./_proposal"));

export default {
  props: ["user", "talk", "opposite", "posts"],

  data() {
    return {
      timeOut: undefined,
      formActive: true,
      typing: false,
      allPosts: [],
      channel: `privatechat.${this.talk.user_id}.${this.talk.receiver_id}`,
      iFinished:
        (this.talk.question.user_id == this.user.id &&
          this.talk.question.user_ended == 1) ||
        (this.talk.question.user_id != this.user.id &&
          this.talk.question.freelancer_ended == 1)
    };
  },

  methods: {
    onTyping() {
      const privateChannel = Echo.private(this.channel + ".private");

      setTimeout(() => {
        privateChannel.whisper("typing", {
          typing: true
        });
      }, 300);
    },
    talkStatus(talk) {
      this.formActive = talk.status == 1 ? false : true;
    },
    onSubmitForm(post) {
      this.allPosts.push(post);
    }
  },

  created() {
    this.allPosts = this.posts;
    this.talkStatus(this.talk);

    Echo.private(this.channel + ".private")
      .listen("PrivatePostSent", response => {
        const { post, question } = response;

        this.talkStatus(post.talk);
        this.allPosts.push(post);

        /**
         * Atualiza status da questão para aparecer o botão de finalizar
         */
        this.talk.question.status = question.status;
      })
      .listenForWhisper("typing", e => {
        this.typing = e.typing;

        clearTimeout(this.timeOut);

        this.timeOut = setTimeout(() => {
          this.typing = false;
        }, 900);
      });
  }
};
</script>

<style scoped>
.typing:after {
  overflow: hidden;
  display: inline-block;
  vertical-align: bottom;
  -webkit-animation: ellipsis steps(4, end) 900ms infinite;
  animation: ellipsis steps(4, end) 900ms infinite;
  content: "\2026"; /* ascii code for the ellipsis character */
  width: 0px;
}

@keyframes ellipsis {
  to {
    width: 1.25em;
  }
}

@-webkit-keyframes ellipsis {
  to {
    width: 1.25em;
  }
}
</style>

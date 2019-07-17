<template>
  <p class="lead">
    <span>Conversa com</span>
    <a :href="'/users/' + opposite.id" class="badge badge-secondary">
      <span :class="(onlineFriends.find(user=>user.id===opposite.id))?'text-success':''">&bull;</span>
      <span>{{ opposite.name }}</span>
    </a>
  </p>
</template>

<script>
export default {
  props: ["opposite", "user", "channel"],
  data() {
    return {
      onlineFriends: []
    };
  },
  created() {
    Echo.join(this.channel + ".join")
      .here(users => {
        this.onlineFriends = users;
      })
      .joining(user => {
        this.onlineFriends.push(user);
      })
      .leaving(user => {
        this.onlineFriends.splice(this.onlineFriends.indexOf(user), 1);
      });
  }
};
</script>

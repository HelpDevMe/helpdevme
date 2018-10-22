<template>
  <div>
    <div class="online-users">
      <div>
          <div
            v-for="friend in friends"
            :color="(friend.id==activeFriend)?'green':''"
            :key="friend.id"
            @click="activeFriend=friend.id"
          >
            <div>
              <div :color="(onlineFriends.find(user=>user.id===friend.id))?'green':'red'">account_circle</div>
            </div>

            <div>
              <div>{{friend.name}}</div>
            </div>

          </div>


        </div>

    </div>
    
    <div id="privateMessageBox" class="messages mb-5">
       <div>
            <div
              class="p-3"
              v-for="(message, index) in allMessages" 
              :key="index"
            >

           <div
           :align-end="(user.id!==message.user.id)" 
            column
           >
             <div>
               <div>
                  <div>
                    <span class="small font-italic">{{message.user.name}}</span>
                  </div>

                  <div>
                    <div
                      :color="(user.id!==message.user.id)?'red':'green'"
                      text-color="white"
                    >

                      <div>
                        {{message.message}}
                      </div>
                    </div>
                  </div>

                  <div class="caption font-italic">
                    {{message.created_at}}
                  </div>
               </div>
             </div>
           </div>


            </div>

            <p v-if="typingFriend.name">{{typingFriend.name}} is typing</p>

        </div>

    
      <div
      
      height="auto"
      fixed
      color="grey"
      >
      <div>
        <div>
            <textarea
              rows=2
              v-model="message"
              label="Enter Message"
              single-line
              @keydown="onTyping"
              @keyup.enter="sendMessage"
            ></textarea>
        </div>

        <div> 
            <button
              @click="sendMessage" class="mt-3 ml-2" color="green">send</button>
        </div>
      </div>
      
          
    </div>
    
    
    </div>

  </div>
</template>

<script>
  export default {
    props:['user'],
    
    data () {
      return {
        message:null,
        activeFriend:null,
        typingFriend:{},
        onlineFriends:[],
        allMessages:[],
        typingClock:null,
        users:[],
      }
    },

    computed:{
      friends(){
        return this.users.filter((user)=>{
          return user.id !==this.user.id;
        })
      }
    },

    watch:{
      activeFriend(val){
        this.fetchMessages();
      }
    },

    methods:{
      onTyping(){
        Echo.private('privatechat.'+this.activeFriend).whisper('typing',{
          user:this.user

        });
      },
      sendMessage(){

        //check if there message
        if(!this.message){
          return alert('Please enter message');
        }
        if(!this.activeFriend){
          return alert('Please select friend');
        }

          axios.post('/api/private-messages/'+this.activeFriend, {message: this.message}).then(response => {
                    this.message=null;
                    this.allMessages.push(response.data.message)
                    setTimeout(this.scrollToEnd,100);
          });
      },
      fetchMessages() {
         if(!this.activeFriend){
          return alert('Please select friend');
        }
            axios.get('/api/private-messages/'+this.activeFriend).then(response => {
                this.allMessages = response.data;

            });
        },
      fetchUsers() {
            axios.get('/api/users').then(response => {
                this.users = response.data;
                if(this.friends.length>0){
                  this.activeFriend=this.friends[0].id;
                }
            });
        },


      scrollToEnd(){
        document.getElementById('privateMessageBox').scrollTo(0,99999);
      }

    
    },

    mounted(){
    },

    created(){
              this.fetchUsers();

              Echo.join('plchat')
              .here((users) => {
                   console.log('online',users);
                   this.onlineFriends=users;
              })
              .joining((user) => {
                  this.onlineFriends.push(user);
                  console.log('joining',user.name);
              })
              .leaving((user) => {
                  this.onlineFriends.splice(this.onlineFriends.indexOf(user),1);
                  console.log('leaving',user.name);
              });
             
              Echo.private('privatechat.'+this.user.id)
                .listen('PrivateMessageSent',(e)=>{
                  console.log('pmessage sent')
                  this.activeFriend=e.message.user_id;
                  this.allMessages.push(e.message)
                  setTimeout(this.scrollToEnd,100);

              })
              .listenForWhisper('typing', (e) => {

                  if(e.user.id==this.activeFriend){

                      this.typingFriend=e.user;
                      
                    if(this.typingClock) clearTimeout();

                      this.typingClock=setTimeout(()=>{
                                            this.typingFriend={};
                                        },9000);
                  }


                 
            });

    }
    
  }
</script>

<style scoped>

.online-users,.messages{
  overflow-y:scroll;
  height:100vh;
}

</style>

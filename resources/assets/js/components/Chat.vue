<script>
    import MessageService from '../Services/MessageService'
    import UserService from '../Services/UserService'

    export default {
        data() {
            return {
                testvar : '(=^.^=)',
                message : '',
                messageBuffer : [],
                userData : [],
                messageService: new MessageService(),
                userService: new UserService()
            }
        },
        
        methods: {
            sendMessage() {
                var self = this;
                
                var message = {
                    Msg : self.message
                };
                
                this.messageService.SaveMessage(message).then(function() {
                    self.message = '';
                })
                .catch(function(error) {
                    alert(error);
                })
                    
            },
            
            addUserName(mb) {
                var self = this;
                var userArray = self.userData;
                var messages = mb;
                
                userArray.forEach(function(u) {
                   messages.forEach(function(msg) {
                       if (msg.user_id == u.id) {
                           msg.userName = u.name;
                       }
                   }) ;
                });
                
                self.messageBuffer = messages;
                
                self.$nextTick(function() {
                    // Now scroll that buffer to the bottom
                    var chatDiv = $('#chatText');
                    chatDiv.scrollTop(chatDiv.prop("scrollHeight"));
                });
            },
            
            getUserData(mb) {
                var self = this;
                
                if (self.userData.length == 0) {
                    this.userService.GetAllUsers().then(function(result) {
                        self.userData = result;
                        self.addUserName(mb);
                    })
                    .catch(function(error) {
                        alert("Could not get user info"); 
                    });
                }
                else {
                    self.addUserName(mb);
                }
            },
            
            sendUserNotification(from, message) {
                if (!("Notification") in window) {
                    return;
                }
                
                var msgOptions = {
                    body: message
                };
                
                // Do we already have permission?
                if (Notification.permission === 'granted') {
                    var notification = new Notification(from, msgOptions);
                    return;
                }
                
                // User permission
                if (Notification.permission !== 'denied') {
                    Notification.requestPermission(function (permission) {
                      // If the user accepts, let's create a notification
                      if (permission === "granted") {
                        var notification = new Notification(from, msgOptions);
                      }
                    });
                }
            }
        },
        
        created() {
            var self = this;

            this.messageService.GetLastMessages().then(function(result) {
                self.getUserData(result);
            })
            .catch(function(error) {
                alert(error); 
            });
            
            // Set up echo / pusher listener
            Echo.channel('message')
                .listen('MessageEvent', (e) => {
                    console.log('Received: ' + e.msg.text);
                    self.messageBuffer.push(e.msg);
                    self.getUserData(self.messageBuffer);
                    
                    // Send browser notification
                    if (document.hidden)
                        self.sendUserNotification(e.msg.userName, e.msg.text);
                }
            );
            

            
        },
        
    }
</script>



<template>
    <div>
        <p>Type a chat message below. Press enter to send.</p>
        <div id="chatText">
            <div v-for="m in messageBuffer"><p>{{ m.created_at }} [{{ m.userName }}] : {{ m.text }}</p></div>
        </div>
        <span class="blinking-cursor">
        <input v-on:keyup.enter="sendMessage" v-model="message" type="text" name="message" id="message" />
        </span>
    </div>
</template>


<style>
    #message {
        background-color: white;
        width: 100%;
    }
    #chatText {
        height: 400px;
        right: 100%;
        background-color: black;
        color: #66FF00;
        overflow:auto;
    }
    
</style>
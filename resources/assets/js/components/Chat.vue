<script>
    export default {
        data() {
            return {
                testvar : '(=^.^=)',
                message : '',
                messageBuffer : [],
                userData : []
            }
        },
        
        methods: {
            sendMessage() {
                var self = this;
                
                var message = {
                    Msg : self.message
                };
                
                $.ajax(
                    {
                        type: 'POST',
                        cache: false,
                        url: '/service/v1/message',
                        data: message,
                        success: function(result) {
                            console.log('Res: ' + result);
                            self.message = '';
                        }
                    }
                );
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
                    // We need to retrieve user data from the server
                    // Lets fill the userdata
                    $.ajax({
                        type: 'GET',
                        cache: false,
                        url: '/service/v1/getUsers',
                        
                        success: function(result) {
                            self.userData = result;
                            self.addUserName(mb);
                        }
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
            
            $.ajax(
                {
                    type: 'GET',
                    cache: false,
                    url: '/service/v1/messagesInitial',
                    success: function(result) {
                        // We have to sort result
                        result.sort(function(a,b) {
                            return (a.id > b.id ? 1 : ((b.id > a.id) ? -1 : 0));
                        });
                        
                        self.getUserData(result);
                    }
                }
            );
            
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
        <h1>{{ testvar }}</h1>
        <div id="chatText">
            <div v-for="m in messageBuffer"><p>{{ m.created_at }} [{{ m.userName }}] : {{ m.text }}</p></div>
        </div>
        <input v-on:keyup.enter="sendMessage" v-model="message" type="text" name="message" id="message"/>
    </div>
</template>


<style>
    #message {
        background-color: red;
        width: 100%;
    }
    #chatText {
        height: 400px;
        right: 100%;
        background-color: black;
        color: green;
        overflow:auto;
    }
</style>
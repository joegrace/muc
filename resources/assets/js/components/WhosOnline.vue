<script>
    import UserService from '../Services/UserService';

    export default {
        data () {
            return {
                stuff : 'omg',
                userService : new UserService(),
                online : []
            }
        },
        
        created() 
        {
            var self = this;
            
            // Tell the server we are here every 10 seconds
            this.userService.SetUserAlive();
            setInterval(this.userService.SetUserAlive, 10000);
            
            // Get whos online list use websockets for this too TODO
            this.whosOnline();
            setInterval(this.whosOnline, 10000);
        },
        
        methods: 
        {
            whosOnline : function() 
            {
                var self = this;
                
                // This gets who has checked in within the last 10 seconds
                self.userService.WhosOnline().then(function(result) {
                    self.online = result;
                })
            },
            
            
            
        }
    }
    
</script>


<template>
    <div id="whosOnline">
        <h1>Who's Online n' Stuff</h1>
        <ul>
            <li v-for="user in online">{{ user.name }}</li>
        </ul>
        
    </div>
</template>


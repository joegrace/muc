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
            setInterval(this.userService.SetUserAlive, 5000);
            
            // Get whos online list use websockets for this too TODO
            this.whosOnline();
            setInterval(this.whosOnline, 5000);
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
        
        <ul>
            <li v-for="user in online">{{ user.name }}</li>
        </ul>
        <center><i  v-show="online.length == 0" class="fa fa-cog fa-spin fa-3x fa-fw"></i></center>
    </div>
</template>


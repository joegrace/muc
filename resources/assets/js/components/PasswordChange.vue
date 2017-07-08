<script>
    export default {
        data() {
            return {
                oldPassword : '',
                newPassword : '',
                newPasswordVerify : '',
                errors : [],
                success : false
            }
        },
        
        created() {
            var self = this;
            self.resetComponent();
            self.success = false;
        },
        
        methods : {
            resetComponent : function() {
                var self = this;
                
                self.oldPassword = '';
                self.newPassword = '';
                self.newPasswordVerify = '';
                self.errors = [];
                
            },
            
            changePass : function() {
                var self = this;
                
                // Clear out the errors array
                self.errors = [];
                
                // Validate all fields are filled in, then do the
                // old password validation on the server.
                
                if (!self.oldPassword || !self.newPassword || !self.newPasswordVerify) {
                    self.errors.push("All fields are required");
                }
                
                if (self.newPassword != self.newPasswordVerify) {
                    self.errors.push("New passwords do not match");
                }
                
                if (self.errors.length > 0) {
                    $("#errorsDiv").show();
                }
                
                var data = {
                    'oldPassword' : self.oldPassword,  
                    'newPassword' : self.newPassword
                };
                
                $.ajax({
                    type : 'POST',
                    cache : false,
                    url : '/service/v1/changeUserPassword',
                    data : data,
                    
                    success : function(res) {
                        if (res.Status == 'Fail') {
                            self.errors.push(res.StatusMessage);
                            return;
                        } else {
                            self.success = true;
                            
                            self.resetComponent();
                        }
                        
                        
                    },
                    
                    error : function() {
                        alert("Sorry, we could not process your request");
                    }
                });
            }
        }
        
    }
</script>

<template>
    <div id="main">
        <h2>Change Password</h2>
        
        <!-- Errors -->
        <div v-if="errors.length > 0" class="alert alert-danger" id="errorsDiv">
            <table>
                <tr v-for="e in errors">{{ e }}</tr>
            </table>
        </div>
        
        <div v-if="success" class="alert alert-success">
            Password Successfully Changed!
        </div>
        
        <p><label for="oldPassword">Old Password</label><input type="password" id="oldPassword" v-model="oldPassword" class="form-control" /></p>
        <p><label for="newPassword">New Password</label><input type="password" id="newPassword" v-model="newPassword" class="form-control" /></p>
        <p><label for="newPasswordVerify">Verify Password</label><input type="password" id="newPasswordVerifyPassword" v-model="newPasswordVerify" class="form-control" /></p>
        <p><button type="button" v-on:click="changePass" class="btn btn-primary">Change Password</button></p>
    </div>
</template>
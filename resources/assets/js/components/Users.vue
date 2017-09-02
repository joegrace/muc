<script>
    import UserService from '../Services/UserService';

    export default {
        data() {
            return {
                userService : new UserService(),
                usersList: [],
                firstName: '',
                lastName: '',
                email: '',
                password: '',
                passwordVerify: '',
                disableCheck: '',
                loading : true
            }
        },
     
        created() {;
            this.retrieveNewUsersList();
        },
        
        methods: {
            showUserModal: function() {
                $('#myModal').modal('show');
                
                // Clear our the form elements for next time
                this.firstName = '';
                this.lastName = '';
                this.email = '';
                this.password = '';
                this.passwordVerify = '';
                
                this.hideModals();
            },
            
            saveForm: function() {
                var self = this;
                var valfail = false;
                
                // Resetting the errors, should have done this with an
                // errors array.
                self.hideModals();
                
                // Perform form validation
                if (!this.firstName || !this.email || 
                    !this.password || !this.passwordVerify) {
                    $('#fieldsRequired').show();
                    valfail = true;
                }
                
                // Check passwords are the same
                if (this.password != this.passwordVerify) {
                    $('#passwordMatch').show();
                    var valfail = true;
                }
                
                if (valfail == true) {
                    return;
                }
                
                // Now send the add user message
                var userData = {
                    firstName : this.firstName,
                    email : this.email,
                    password : this.password
                };
                
                self.userService.AddNewUser(userData).then(function() {
                    // This refreshes the user list
                    self.retrieveNewUsersList();
                }).catch(function(error) {
                    alert(error);
                })
            },
            
            hideModals: function() {
                $('#fieldsRequired').hide();
                $('#passwordMatch').hide();
                $('#submissionError').hide();
            },
            
            retrieveNewUsersList: function() {
                var self = this;
                
                self.userService.GetAllUsers().then(function(users) {
                   self.usersList = users;
                   self.loading = false;
                }).catch(function(error){
                    alert(error);
                });
            },
            
            toggleEnable : function(userId) {
                var self = this;
                
                // Disable the user with user id userId
                self.userService.ToggleEnable(userId).catch(function() {
                    alert("Sorry, could not toggle user.");
                })
                
            },
        }
    }
</script>


<template>
    <div>
        <h2>User Admin</h2>
        

        
        <button type="button"  v-on:click="showUserModal" class="btn btn-primary" data-togle="modal" data-target="#myModal">Add User</button>
        <br />
        <br />
        <br />
        <div id="usersDiv">
            <table class="table">
                <tr>
                    <th>Id</th><th>Name</th><th>Email</th><th>Disable</th>
                </tr>
                <tr v-for="u in usersList"><td>{{ u.id }}</td><td>{{ u.name }}</td><td>{{ u.email }}</td><td><input type="checkbox" v-on:change="toggleEnable(u.id)" :checked="u.disabled == true" /></td></tr>
            </table>
            <center><i  v-show="loading" class="fa fa-cog fa-spin fa-3x fa-fw"></i></center>
        </div>
        
        <!-- Add Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add User</h4>
              </div>
              <div class="modal-body">
                <p>All fields required.</p>
                <div id="fieldsRequired" class="alert alert-danger" style="display: none">All Fields are required</div>
                <div id="passwordMatch" class="alert alert-danger" style="display: none">Passwords do not match</div>
                <div id="submissionError" class="alert alert-danger" style="display: none">Sorry, something didn't work quite right.</div>
                <p><label for="firstName">Name</label><input type="text" id="firstName" v-model="firstName" class="form-control" /></p>
                <p><label for="email">Email Address</label><input type="text" id="email" v-model="email" class="form-control" /></p>
                <p><label for="password">Password</label><input type="password" id="password" v-model="password" class="form-control" /></p>
                <p><label for="passwordVerify">Verify Your Password</label><input type="password" id="passwordVerify" v-model="passwordVerify" class="form-control" /></p>
              </div>
              <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal" v-on:click="closeForm">Close</button>-->
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" v-on:click="saveForm">Save</button>
              </div>
            </div>
          </div>
        </div>
    
    
    
    
    </div>
</template>
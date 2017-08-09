export default class UserService 
{
    GetAllUsers()
    {
        return new Promise((resolve, reject) => {
            // Call the server
            $.ajax({
                type: 'GET',
                cache: false,
                url: '/service/v1/getUsers',
                
                success: function(result) {
                    resolve(result);
                },
                error: function() {
                    reject("Could not retrieve user info.");
                }
            });
        });
    }
    
    ToggleEnable(userId)
    {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'POST',
                cache: false,
                url: '/service/v1/toggleEnable',
                data: {
                    userId : userId    
                },
                
                success: function() {
                    resolve(true);
                },
                
                error: function() {
                    reject("Could not toggle user enable.");
                }
            });
        });
    }
    
    AddNewUser(userData)
    {
        return new Promise((resolve, reject) => {
            $.ajax({
               method : 'POST',
               url : '/service/v1/addNewUser',
               data : userData,
               success : function() {
                   // Close modal and refresh list
                   $('#myModal').modal('hide');
                   
                   // Refresh the user list
                   //self.retrieveNewUsersList();
                   resolve(true);
               },
               error: function() {
                   //$('#submissionError').show();
                   reject("Could not add this user");
               }
            });
        });        
    }
    
    SetUserAlive()
    {
        return new Promise((resolve, reject) => {
            $.ajax({
                method : 'POST',
                url : '/service/v1/setAlive',
                
                success : function() 
                {
                    resolve(true);
                },
                
                error: function() 
                {
                    reject("Could not update current status");
                }
            })
            
        });
        
        
    }
    
    WhosOnline() 
    {
        return new Promise((resolve, reject) => {
           $.ajax({
              method : 'GET',
              url : '/service/v1/whosOnline',
              
              success : function(result) {
                  resolve(result)
              },
              
              error : function(error) {
                  reject("Could not get whos online list")
              }
           });
            
        });
    }
}
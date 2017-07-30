export default class MessageService
{
    SaveMessage(messageInfo)
    {
        return new Promise((resolve, reject) => {
            $.ajax(
            {
                type: 'POST',
                cache: false,
                url: '/service/v1/message',
                data: messageInfo,
                success: function(result) {
                    resolve(true);
                },
                error: function() {
                    reject("Could not send message");
                }
            });
        });
        
    }
    
    GetLastMessages()
    {
        return new Promise((resolve, reject) => {
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
                    
                    resolve(result);
                },
                error: function() {
                    reject("Could not get recent messages");
                }
            });  
          
          
            
        })
    }
    
    
    
}
var slackChatPair = function () {
  var instance = this;

  instance = {
      user_1: [],
      user_2: [],
      urls : {
         updateStatuses : '/update-statuses-pair',
         getChannelChat : '/get-channel-chat-pair',
         sendMessage    : '/send-slack-message-pair',
         selectPair     : '/select-pair'
      }
  };

  instance.init = function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      instance.user_1 = JSON.parse($('#user_1').attr('data-creds'));
      instance.user_2 = JSON.parse($('#user_2').attr('data-creds'));


      setInterval(function () {
          instance.updateStatuses()
      }, 30000);

      instance.eventListeners();
  };

  instance.toggleLoader = function (show) {
      $('.loading-block').toggleClass('display-none', !show);
  };

  // instance.selectPair = function (id) {
  //
  //     if(id) {
  //         $.ajax({
  //             type: 'post',
  //             url: instance.urls.selectPair,
  //             data: {
  //                 id_: id
  //             },
  //             beforeSend: function () {
  //                 instance.toggleLoader(true);
  //             },
  //             success: function (response) {
  //                 if ('user_1' in response) {
  //                     instance.user_1 = {
  //                         "id": response.user_1.id,
  //                         "slack_id": response.user_1.slack_user_id,
  //                         "channel_id": response.user_1.channel_id,
  //                         "workspace_id": response.workspace_1.id,
  //                         "admin_id": response.admin_1.id
  //                     };
  //                     $('.user_1_status').attr('data-slack_id', response.user_1.slack_user_id);
  //                     $('.user_1_name').html(response.user_1.username);
  //                     $('#admin_1').html(response.admin_1.username);
  //
  //                     instance.user_2 = {
  //                         "id": response.user_2.id,
  //                         "slack_id": response.user_2.slack_user_id,
  //                         "channel_id": response.user_2.channel_id,
  //                         "workspace_id": response.workspace_2.id,
  //                         "admin_id": response.admin_2.id
  //                     };
  //                     $('.user_2_status').attr('data-slack_id', response.user_2.slack_user_id);
  //                     $('.user_2_name').html(response.user_2.username);
  //                     $('#admin_2').html(response.admin_2.username);
  //
  //                     instance.renderMessaging();
  //                     $('.slack-message').val('');
  //                     $('.messaging-block .slack-massages').scrollTop($('.messaging-block .slack-massages')[0].scrollHeight);
  //                 }
  //             }
  //         });
  //     }
  //
  // };

  instance.updateStatuses = function () {
          $.ajax({
              type: 'post',
              url: instance.urls.updateStatuses,
              data: {
                  user_1 : instance.user_1,
                  user_2 : instance.user_2
              },
              success: function (response) {
                  $.each(response.data, function (key, status) {
                      var active = (status == 'active') ? true : false;
                      $('.'+key+'_status.slack-status').toggleClass('active', active);
                  });
              }
          });
  };

  instance.eventListeners = function () {
      instance.renderMessaging();

      $(document).ready(function () {
          var body = $('body');

          // body.on('change', '.select-pair', function () {
          //     instance.selectPair($(this).val());
          // });

          body.on('keypress', '.slack-message',function(e) {
              if(e.which == 13) {
                  if($(this).hasClass('user_1')){
                      $('body .send-message[data-user="user_1"]').click()
                  }else{
                      $('body .send-message[data-user="user_2"]').click()
                  }
              }
          });

          body.on('click', '.send-message', function () {
              var user = $(this).attr('data-user');
              $.ajax({
                  type: 'post',
                  url: instance.urls.sendMessage,
                  data: {
                      developer : instance[user],
                      message : $('.slack-message.'+user).val()
                  },
                  beforeSend: function () {
                      instance.toggleLoader(true);
                  },
                  success: function (response) {
                      instance.renderMessaging();
                      $('.slack-message').val('');
                      $('.messaging-block .slack-massages').scrollTop($('.messaging-block .slack-massages')[0].scrollHeight);
                  }
              });
          });

      });
  };
    instance.renderMessaging = function () {
        $.ajax({
            type: 'post',
            url: instance.urls.getChannelChat,
            data: {
                user_1 : instance.user_1,
                user_2 : instance.user_2
            },
            beforeSend: function () {
                instance.toggleLoader(true);
            },
            success: function (response) {
                console.log(response);
                $('.messaging-block .slack-massages').html('');

                $.each(response.data.user_1, function (index, message) {

                    var avatar = ('user' in message && 'image_512' in message.user.profile) ? message.user.profile.image_512 : $('.messaging-block').attr('data-photo');
                    var display_name = ('user' in message) ? message.user.profile.real_name : '';

                    $('.messaging-block .slack-massages.user_1').append(''+
                        '<div class="table-div"><div class="table-cell w-60-px"><img width="40" height="40" class="img-circle" src="'+ avatar +'"></div>'+
                        '<div class="table-cell info-div"><span class="first-name">'+ display_name +'</span><span class="reply-time">'+message.ts+'</span><p class="info-txt">'+ message.text +'</p></div></div></div>');
                });

                $.each(response.data.user_2, function (index, message) {

                    var avatar = ('user' in message && 'image_512' in message.user.profile) ? message.user.profile.image_512 : $('.messaging-block').attr('data-photo');
                    var display_name = ('user' in message) ? message.user.profile.real_name : '';

                    $('.messaging-block .slack-massages.user_2').append(''+
                        '<div class="table-div"><div class="table-cell w-60-px"><img width="40" height="40" class="img-circle" src="'+ avatar +'"></div>'+
                        '<div class="table-cell info-div"><span class="first-name">'+ display_name +'</span><span class="reply-time">'+message.ts+'</span><p class="info-txt">'+ message.text +'</p></div></div></div>');
                });

                $('.messaging-block .slack-massages').scrollTop($('.messaging-block .slack-massages')[0].scrollHeight);
                instance.toggleLoader(false);
            }
        });
    };

    instance.init();
};
slackChatPair();

var slackChatPair = function () {
  var instance = this;

  instance = {
      user_1: [],
      user_2: [],
      messages_1 : [] ,
      messages_1_last : -1,
      messages_2 : [] ,
      messages_2_last : -1,
      auto: false,
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

      setInterval(function () {
          instance.renderMessaging(true);
      }, 7000);

      instance.eventListeners();
  };

  instance.toggleLoader = function (show) {
      $('.loading-block').toggleClass('display-none', !show);
  };

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
      instance.renderMessaging(false);

      $(document).ready(function () {
          var body = $('body');

          body.on('keypress', '.slack-message',function(e) {
              if(e.which == 13) {
                  if($(this).hasClass('user_1')){
                      $('body .send-message[data-user="user_1"]').click()
                  }else{
                      $('body .send-message[data-user="user_2"]').click()
                  }
              }
          });

          body.on('click', '.set-auto',function(e) {
              var state = $(this).attr('data-state');
              $(this).toggleClass('btn-info').toggleClass('btn-danger').attr('data-state', state== 'auto' ? 'stop' : 'auto' ).html( state== 'auto' ? 'Stop' : 'Automatic' );
              instance.auto = state== 'auto' ? false : true;
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
                      instance.renderMessaging(false);
                      $('.slack-message').val('');
                      $('.messaging-block .slack-massages').scrollTop($('.messaging-block .slack-massages')[0].scrollHeight);
                  }
              });
          });

          body.on('click', '.edit-btn', function (e) {
              instance.sendEditMessage('edit', $(this).parent().attr('data-user'), $(e.target).closest('.info-div').find('.info-txt').html());
              $(this).parent().hide();
          });

          body.on('click', '.send-btn', function (e) {
              instance.sendEditMessage('send', $(this).parent().attr('data-user'), $(e.target).closest('.info-div').find('.info-txt').html());
              $(this).parent().hide();
          });

      });
  };

  instance.sendEditMessage = function (action, user, text) {

          $('body .slack-message.' + user).val(text);
          if(action == 'send') {
              $('body .send-message[data-user="'+ user +'"]').click();
          }

  };

    instance.renderMessaging = function (cron) {
        $.ajax({
            type: 'post',
            url: instance.urls.getChannelChat,
            data: {
                user_1 : instance.user_1,
                user_2 : instance.user_2
            },
            beforeSend: function () {
                if(!cron){
                    instance.toggleLoader(true);
                }
            },
            success: function (response) {
                // $('.messaging-block .slack-massages').html('');

                if(!cron || response.data.user_1.length > 0) {
                    $.each(response.data.user_1, function (index, message) {

                        if(instance.messages_1_last < message.tsi){

                            instance.messages_1.push({ts : message.tsi, act : instance.auto});


                        var avatar = ('user' in message && 'image_512' in message.user.profile) ? message.user.profile.image_512 : $('.messaging-block').attr('data-photo');
                        var display_name = ('user' in message) ? message.user.profile.real_name : '';

                        $('.messaging-block .slack-massages.user_1').append('' +
                            '<div class="table-div"><div class="table-cell w-60-px"><img width="40" height="40" class="img-circle" src="' + avatar + '"></div>' +
                            '<div class="table-cell info-div"><span class="first-name">' + display_name + '</span><span class="reply-time">' + message.ts + '</span><span class="msg-btns" data-ts="'+message.tsi+'" data-user="user_2"><i class="material-icons send-btn">send</i><i class="material-icons edit-btn">edit</i></span><p class="info-txt">' + message.text + '</p></div></div></div>');
                        }
                    });

                    instance.messages_1_last = parseFloat($('.messaging-block .slack-massages.user_1 .msg-btns').last().attr('data-ts'));
                }

                if(!cron || response.data.user_2.length > 0) {
                    $.each(response.data.user_2, function (index, message) {

                        if(instance.messages_2_last < message.tsi) {
                            instance.messages_2.push({ts: message.tsi, act: instance.auto});


                            var avatar = ('user' in message && 'image_512' in message.user.profile) ? message.user.profile.image_512 : $('.messaging-block').attr('data-photo');
                            var display_name = ('user' in message) ? message.user.profile.real_name : '';

                            $('.messaging-block .slack-massages.user_2').append('' +
                                '<div class="table-div"><div class="table-cell w-60-px"><img width="40" height="40" class="img-circle" src="' + avatar + '"></div>' +
                                '<div class="table-cell info-div"><span class="first-name">' + display_name + '</span><span class="reply-time">' + message.ts + '</span><span class="msg-btns" data-ts="' + message.tsi + '" data-user="user_1"><i class="material-icons send-btn">send</i><i class="material-icons edit-btn">edit</i></span><p class="info-txt">' + message.text + '</p></div></div></div>');
                        }
                    });
                    instance.messages_2_last = parseFloat($('.messaging-block .slack-massages.user_2 .msg-btns').last().attr('data-ts'));
                }
                $('.messaging-block .slack-massages').scrollTop($('.messaging-block .slack-massages')[0].scrollHeight);
                if(!cron){
                    instance.toggleLoader(false);
                }
                console.log(instance);
            }
        });
    };

    instance.init();
};
slackChatPair();

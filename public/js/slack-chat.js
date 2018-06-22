var slackChat = function () {
  var instance = this;

  instance = {
      data : {
          developers : [],
          current_dev : {}
      },
      urls : {
         updateStatuses : '/update-statuses',
         getChannelChat : '/get-channel-chat',
         sendMessage    : '/send-slack-message',
         getTempContent : '/templates/get-content/'
      }
  };

  instance.init = function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $('.select-developer').each(function (index, dev) {
          instance.data.developers.push(JSON.parse($(dev).attr('data-creds')));
      });

      setInterval(function () {
          instance.updateStatuses()
      }, 30000);

      instance.selectDeveloper($('.select-developer').first());
      instance.eventListeners();
  };

    instance.renderTemplateContent = function (temp_id) {
        $.ajax({
            type: 'get',
            url: instance.urls.getTempContent + temp_id,
            success: function (content) {
                $('#slack-message').val(content);
            }
        });
    };

  instance.toggleLoader = function (show) {
      $('.loading-block').toggleClass('display-none', !show);
  };

  instance.selectDeveloper = function (developer) {
      $('.select-developer').removeClass('active');
      developer.addClass('active');
      $('#current_developer').html(developer.html());

      instance.data.current_dev = developer.length != 0 ? JSON.parse($(developer).attr('data-creds')) : {};
      instance.renderMessaging();
  };

  instance.updateStatuses = function () {
          $.ajax({
              type: 'post',
              url: instance.urls.updateStatuses,
              data: {
                  developers : instance.data.developers
              },
              success: function (response) {
                  $.each(response.data, function (key, status) {
                      var active = (status == 'active') ? true : false;
                      $('.slack-status[data-slack_id="' + key + '"]').toggleClass('active', active);
                  });
              }
          });
  };

  instance.eventListeners = function () {
      $(document).ready(function () {
          var body = $('body');

          body.on('click', '.select-developer', function () {
              instance.selectDeveloper($(this));
          });

          body.on('click', '.template-block', function () {
              $('.template-block').toggleClass('active', false);
              $(this).toggleClass('active', true);
              instance.renderTemplateContent($(this).attr('data-id'));
          });

          body.on('click', '#send-message', function () {
              $.ajax({
                  type: 'post',
                  url: instance.urls.sendMessage,
                  data: {
                      developer : instance.data.current_dev,
                      message : $('#slack-message').val()
                  },
                  beforeSend: function () {
                      instance.toggleLoader(true);
                  },
                  success: function (response) {
                      instance.renderMessaging();
                      $('#slack-message').val('');
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
                developer : instance.data.current_dev
            },
            beforeSend: function () {
                instance.toggleLoader(true);
            },
            success: function (response) {
                console.log(response);
                $('.messaging-block .slack-massages').html('');

                $.each(response.data, function (index, message) {

                    var avatar = ('user' in message && 'image_512' in message.user.profile) ? message.user.profile.image_512 : $('.messaging-block').attr('data-photo');
                    var display_name = ('user' in message) ? message.user.profile.real_name : '';

                    $('.messaging-block .slack-massages').append(''+
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
slackChat();

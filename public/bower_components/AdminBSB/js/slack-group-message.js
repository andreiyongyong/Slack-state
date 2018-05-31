var slackChatGroup = function () {
  var instance = this;

  instance = {
      user_list: [],
      urls : {
         sendMessage    : '/send-slack-message-group'
      }
  };

  instance.init = function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      instance.eventListeners();
  };

  instance.toggleLoader = function (show) {
      $('.loading-block').toggleClass('display-none', !show);
  };

  instance.eventListeners = function () {
      $(document).ready(function () {
          var body = $('body');
          
          body.on('click', '#browser', function () {

          });

          body.on('change', '#select-users-all', function () {
              if($(this).is(':checked')){
                  $('.select-user').prop('checked', true);
              }else{
                  $('.select-user').prop('checked', false);
              }
              instance.updateUsers();
          });


          body.on('change','.select-user', function(){
              instance.updateUsers();
          });

          body.on('change','.upload-file', function(){
              if($(this).prop('files').length > 0)
              {
                  $('.file_name').html($(this).prop('files')[0]['name']);
              }
          });

          body.on('click', '#send-group-message', function () {
              var formdata = new FormData();

              formdata.append("developers", JSON.stringify(instance.user_list));
              formdata.append("message", $('#group-message').val());

              if($('.upload-file').prop('files').length > 0)
              {
                  formdata.append("attach", $('.upload-file').prop('files')[0]);
              }

              $.ajax({
                  type: 'post',
                  url: instance.urls.sendMessage,
                  data: formdata,
                  processData: false,
                  contentType: false,
                  beforeSend: function () {
                      instance.toggleLoader(true);
                  },
                  success: function (response) {
                      instance.renderNotify(response.error, response.msg);
                      instance.toggleLoader(false);
                  }
              });
          });

      });
  };

  instance.renderNotify = function (error, msg) {
      $('.msg-notify').html(msg).toggleClass('msg-err', error);
  };

  instance.updateUsers = function () {
      instance.user_list = [];
      $('.select-user:checked').each(function (index, user) {
          instance.user_list.push(JSON.parse($(user).attr('data-cred')));
      });
  };

    instance.init();
};
slackChatGroup();
